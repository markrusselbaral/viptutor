<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'status', 'priority', 'order', 'sort_order', 'user_id'];

    public function scopeFilterStatus($query, $status)
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopeFilterPriority($query, $priority)
    {
        return $priority ? $query->where('priority', $priority) : $query;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
