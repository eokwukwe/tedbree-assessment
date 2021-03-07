<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Condition extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function job(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
