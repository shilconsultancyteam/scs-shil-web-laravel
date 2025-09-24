<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'name',
        'email',
        'phone',
        'cover_letter',
        'portfolio_link',
        'cv_path',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}