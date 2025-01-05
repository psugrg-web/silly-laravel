<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * NOTE: This migration will create TWO tables: tags and job_tag
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        /**
         * Create Pivot table named job_tag
         * 
         * It's integrated with the migration of tags table. This is also fine but maybe less readable compared to keeping it separate
         */
        Schema::create('job_tag', function (Blueprint $table) {
            $table->id();
            /** Since our list of jobs has a non-standard name, we have to specify it explicitly as a second argument of foreignIdFor() */
            $table->foreignIdFor(\App\Models\Job::class, 'job_listing_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Tag::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('job_tag');
    }
};
