<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    public function jobs()
    {
        // In this case we must explicitly provide the relatedPivotKey name since the Job class name
        // is different from the table name for that class. Laravel cannot deduce the relatedPivotKey
        // automatically in this case
        return $this->belongsToMany(Job::class, relatedPivotKey: "job_listing_id");
    }
}
