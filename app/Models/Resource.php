<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['title', 'url', 'banner', 'summary', 'categories', 'topics', 'activities', 'opportunities', 'regions', 'language', 'content'])]
class Resource extends Model
{
    use HasFactory;
}
