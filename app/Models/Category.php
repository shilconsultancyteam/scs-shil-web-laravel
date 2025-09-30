<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    /**
     * A category belongs to one parent category (null for top-level).
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * A category can have many subcategories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Scope to fetch only top-level (parent) categories.
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }
}