<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    // Explicitly specify the name of the table in the DB (in case it cannot be deduced automatically)
    protected $table = 'job_listings';
    // Specify fields that can be mass-assigned
    // protected $fillable = ['employer_id', 'title', 'salary'];
    // Define an empty $guarded field will disable mass assignment protection feature
    protected $guarded = [];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function tags()
    {
        // In this case we must explicitly provide the foreignPivotKey name since the Job class name
        // is different from the table name for that class. Laravel cannot deduce the foreignPivotKey
        // automatically in this case
        return $this->belongsToMany(Tag::class, foreignPivotKey: "job_listing_id");
    }
}
