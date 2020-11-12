<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'created_by',
        'created_at', 'updated_at'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function($data) {
            $data->created_by = auth()->user()->id;
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'event_users', 'event_id', 'user_id');
    }

    public function scopeFilter($query, $request)
    {
        if ($request->has('q') && $request->q) {
            $query->where('name', 'like', '%'.$request->q.'%')
            ->orWhere('description', 'like', '%'.$request->q.'%');
        }
    }
}
