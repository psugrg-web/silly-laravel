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
    protected $fillable = ['title', 'salary'];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
}
