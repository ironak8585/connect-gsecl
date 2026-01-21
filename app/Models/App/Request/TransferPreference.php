<?php

namespace App\Models\App\Request;

use App\Models\Location\Location;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mattiverse\Userstamps\Traits\Userstamps;

class TransferPreference extends Model
{
    use Timestamp, Userstamps;
    
    protected $fillable = [
        'transfer_id',
        'location_id',
        'preference',
        'request_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'request_date' => 'date',
    ];

    // Relationships
    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    // public function histories(): HasMany
    // {
    //     return $this->hasMany(TransferPreferencesHistory::class);
    // }

    // Scopes
    // public function scopeActive($query)
    // {
    //     return $query->where('is_active', true);
    // }

    // public function scopeByPreference($query, int $preference)
    // {
    //     return $query->where('preference', $preference);
    // }

    // Helper methods
    // public function getPreferenceLabel(): string
    // {
    //     $labels = [1 => 'First', 2 => 'Second', 3 => 'Third'];
    //     return $labels[$this->preference] ?? 'Unknown';
    // }
}
