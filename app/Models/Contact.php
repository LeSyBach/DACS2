<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'admin_note',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Chờ xử lý',
            'processing' => 'Đang xử lý',
            'resolved' => 'Đã giải quyết',
        ];

        return $labels[$this->status] ?? 'Không xác định';
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'processing' => 'info',
            'resolved' => 'success',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Scope: Pending contacts
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Processing contacts
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    /**
     * Scope: Resolved contacts
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }
}