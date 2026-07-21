<?php

namespace App\Console\Commands;

use App\Models\Resource;
use Illuminate\Console\Command;
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
        {resource : ID of the Resource database record to export}
        {--output= : Path for the generated JSON file}
        {--force : Overwrite an existing JSON file}';

    protected $description = 'Export one Resource database record as JSON';

    public function handle(): int
    {
        $resourceId = (string) $this->argument('resource');

        if (! ctype_digit($resourceId) || (int) $resourceId < 1) {
            $this->error('The resource argument must be a positive database ID.');

            return self::FAILURE;
        }

        $resource = Resource::query()->find((int) $resourceId);

        if ($resource === null) {
            $this->error("No Resource record was found with ID [{$resourceId}].");

            return self::FAILURE;
        }

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

        if (is_file($outputPath) && ! $this->option('force')) {
            $this->error("The output file [{$outputPath}] already exists. Use --force to overwrite it.");

            return self::FAILURE;
        }

        try {
            $json = json_encode(
                $this->formatResource($resource),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR,
            ).PHP_EOL;
        } catch (JsonException $exception) {
            $this->error("Unable to encode the Resource export: {$exception->getMessage()}");

            return self::FAILURE;
        }

        if (file_put_contents($outputPath, $json) === false) {
            $this->error("The JSON file [{$outputPath}] could not be written.");

            return self::FAILURE;
        }

        $this->info("Exported Resource #{$resource->getKey()} to [{$outputPath}].");

        return self::SUCCESS;
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

    private function defaultOutputPath(Resource $resource): string
    {
        $filename = Str::slug((string) $resource->getAttribute('title'));

        if ($filename === '') {
            $filename = 'resource-'.$resource->getKey();
        }

        return storage_path('app/resources/'.$filename.'.json');
    }
}
