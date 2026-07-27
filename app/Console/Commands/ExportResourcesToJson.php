<?php

namespace App\Console\Commands;

use App\Models\Resource;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use JsonException;

class ExportResourcesToJson extends Command
{
    /**
     * @var array<int, string>
     */
    private const EXPORTED_FIELDS = [
        'title',
        'url',
        'banner',
        'summary',
        'authors',
        'categories',
        'topics',
        'activities',
        'opportunities',
        'regions',
        'language',
        'content',
    ];

    /**
     * @var array<int, string>
     */
    private const LIST_FIELDS = [
        'authors',
        'categories',
        'topics',
        'activities',
        'opportunities',
        'regions',
        'language',
    ];

    protected $signature = 'resource:export
        {resource? : ID of one Resource database record to export}
        {--all : Export all Resource database records}
        {--since= : Export records created or updated on or after YYYY-MM-DD}
        {--output= : Output file for one record, or output directory for multiple records}
        {--force : Overwrite an existing JSON file}';

    protected $description = 'Export Resource database records as JSON';

    public function handle(): int
    {
        $resourceId = (string) ($this->argument('resource') ?? '');
        $exportAll = (bool) $this->option('all');
        $sinceValue = $this->option('since');
        $hasSinceOption = is_string($sinceValue) && $sinceValue !== '';

        if ($resourceId !== '') {
            if ($exportAll || $hasSinceOption) {
                $this->error('Provide either one Resource ID, --all, or --since.');

                return self::FAILURE;
            }

            if (! ctype_digit($resourceId) || (int) $resourceId < 1) {
                $this->error('The resource argument must be a positive database ID.');

                return self::FAILURE;
            }

            $resource = Resource::query()->find((int) $resourceId);

            if ($resource === null) {
                $this->error("No Resource record was found with ID [{$resourceId}].");

                return self::FAILURE;
            }

            return $this->exportOne($resource);
        }

        if ($exportAll && $hasSinceOption) {
            $this->error('Use either --all or --since, not both.');

            return self::FAILURE;
        }

        if ($hasSinceOption) {
            $since = $this->parseSinceDate($sinceValue);

            if ($since === null) {
                $this->error('The --since option must use a valid YYYY-MM-DD date.');

                return self::FAILURE;
            }

            return $this->exportMany($since);
        }

        if ($exportAll) {
            return $this->exportMany();
        }

        $this->error('Provide a Resource ID, --all, or --since=YYYY-MM-DD.');

        return self::FAILURE;
    }

    private function exportOne(Resource $resource): int
    {
        $outputPath = $this->option('output')
            ? $this->resolvePath((string) $this->option('output'))
            : $this->defaultOutputPath($resource);

        if (! $this->option('output')) {
            File::ensureDirectoryExists(dirname($outputPath));
        }

        if (! is_dir(dirname($outputPath))) {
            $this->error('The output directory ['.dirname($outputPath).'] does not exist.');

            return self::FAILURE;
        }

        return $this->writeResourceJson($resource, $outputPath) === 'written'
            ? self::SUCCESS
            : self::FAILURE;
    }

    private function exportMany(?CarbonImmutable $since = null): int
    {
        $outputDirectory = $this->bulkOutputDirectory();

        if ($outputDirectory === null) {
            return self::FAILURE;
        }

        $resources = Resource::query()
            ->with('links')
            ->when($since !== null, function (Builder $query) use ($since): void {
                $query->where(function (Builder $query) use ($since): void {
                    $query->where('created_at', '>=', $since)
                        ->orWhere('updated_at', '>=', $since);
                });
            })
            ->orderBy('id')
            ->get();

        $written = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($resources as $resource) {
            $status = $this->writeResourceJson($resource, $this->defaultOutputPath($resource, $outputDirectory));

            match ($status) {
                'written' => $written++,
                'skipped' => $skipped++,
                default => $failed++,
            };
        }

        $this->info("Export complete: {$written} written, {$skipped} skipped, {$failed} failed.");

        return $failed === 0 ? self::SUCCESS : self::FAILURE;
    }

    /**
     * @return 'failed'|'skipped'|'written'
     */
    private function writeResourceJson(Resource $resource, string $outputPath): string
    {
        if (is_file($outputPath) && ! $this->option('force')) {
            $this->warn("Skipped Resource #{$resource->getKey()}: [{$outputPath}] already exists. Use --force to overwrite it.");

            return 'skipped';
        }

        try {
            $json = json_encode(
                $this->formatResource($resource),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
            ).PHP_EOL;
        } catch (JsonException $exception) {
            $this->error("Unable to encode Resource #{$resource->getKey()}: {$exception->getMessage()}");

            return 'failed';
        }

        if (file_put_contents($outputPath, $json) === false) {
            $this->error("The JSON file [{$outputPath}] for Resource #{$resource->getKey()} could not be written.");

            return 'failed';
        }

        $this->info("Exported Resource #{$resource->getKey()} to [{$outputPath}].");

        return 'written';
    }

    /**
     * @return array<string, mixed>
     */
    private function formatResource(Resource $resource): array
    {
        $attributes = $resource->only(self::EXPORTED_FIELDS);

        foreach (self::LIST_FIELDS as $field) {
            $attributes[$field] = $this->splitList($attributes[$field] ?? null);
        }

        $resource->loadMissing('links');

        $attributes['links'] = $resource->links
            ->map(fn ($link): array => [
                'label' => $link->label,
                'url' => $link->url,
            ])
            ->values()
            ->all();

        return $attributes;
    }

    /**
     * @return array<int, string>
     */
    private function splitList(mixed $value): array
    {
        if (! is_string($value) || trim($value) === '') {
            return [];
        }

        return array_values(array_filter(
            array_map(trim(...), explode(',', $value)),
            static fn (string $item): bool => $item !== '',
        ));
    }

    private function resolvePath(string $path): string
    {
        if (preg_match('/^(?:[A-Za-z]:[\\\\\/]|\/)/', $path) === 1) {
            return $path;
        }

        return base_path($path);
    }

    private function defaultOutputPath(Resource $resource, ?string $directory = null): string
    {
        $filename = Str::slug((string) $resource->getAttribute('title'));

        if ($filename === '') {
            $filename = 'resource-'.$resource->getKey();
        }

        return ($directory ?? $this->defaultOutputDirectory()).DIRECTORY_SEPARATOR.$filename.'.json';
    }

    private function defaultOutputDirectory(): string
    {
        return storage_path('app/resources');
    }

    private function bulkOutputDirectory(): ?string
    {
        $directory = $this->option('output')
            ? $this->resolvePath((string) $this->option('output'))
            : $this->defaultOutputDirectory();

        if (strtolower(pathinfo($directory, PATHINFO_EXTENSION)) === 'json') {
            $this->error('For --all or --since, the --output option must be a directory, not a JSON file.');

            return null;
        }

        if (is_file($directory)) {
            $this->error("The output directory [{$directory}] is a file.");

            return null;
        }

        File::ensureDirectoryExists($directory);

        return $directory;
    }

    private function parseSinceDate(string $value): ?CarbonImmutable
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) !== 1) {
            return null;
        }

        try {
            $date = CarbonImmutable::createFromFormat('!Y-m-d', $value);
        } catch (\Throwable) {
            return null;
        }

        if (! $date instanceof CarbonImmutable) {
            return null;
        }

        return $date->format('Y-m-d') === $value ? $date : null;
    }
}
