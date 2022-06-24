<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name'];
    /**
     * Get all the post for the category
     * 
     * @return Illuminate\Database\Eloquent\Relations\HasMany;
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
