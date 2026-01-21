<?php

namespace App\Models\Master;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class CircularCategory extends Model
{
    use Timestamp, Userstamps, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Mutator
    // set the name attribute to title case
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower($value));
    }

    // Accessor
    // get the name attribute in title case
    // public function getNameAttribute($value)
    // {
    //     return ucwords(strtolower($value));
    // }

    // Relationships

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Global scope to exclude soft deleted records
    protected static function booted()
    {
        static::addGlobalScope('not_deleted', function ($query) {
            $query->whereNull('deleted_at');
        });
    }

    // Global scope to include only active records
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('active', function ($query) {
            $query->where('is_active', true);
        });
    }

    // Gloabl scope to order by name ascending
    protected static function bootedName()
    {
        static::addGlobalScope('order_by_name', function ($query) {
            $query->orderBy('name', 'asc');
        });
    }

    // Scope to display the latest records first
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Scope to filter by name
    public function scopeName($query, $name)
    {
        if ($name) {
            return $query->where('name', 'like', '%' . $name . '%');
        }
        return $query;
    }

    public static function getCategories()
    {
        return self::all()->pluck('name', 'id');
    }

    // Add method to add the circular category
    public static function add($data)
    {
        return self::firstOrCreate([
            'name' => $data['name'],
            'code' => $data['code'],
            'description' => $data['description'],
            'is_active' => $data['is_active'] ?? true,
        ]);
    }
}
