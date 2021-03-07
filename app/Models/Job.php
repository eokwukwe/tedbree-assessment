<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'submission_deadline' => 'datetime',
    ];

    protected $guarded = [];

    public function type(): BelongsTo
    {
        return  $this->belongsTo(Type::class);
    }

    public function condition(): BelongsTo
    {
        return  $this->belongsTo(Condition::class);
    }

    public function category(): BelongsTo
    {
        return  $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
