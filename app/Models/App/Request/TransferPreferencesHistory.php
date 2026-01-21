<?php

namespace App\Models\App\Request;

use App\Models\Location\Location;
use App\Models\User;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class TransferPreferencesHistory extends Model
{
    use SoftDeletes, Timestamp, Userstamps;
    
    protected $table = 'transfer_preferences_history';

    protected $fillable = [
        'transfer_id',
        'transfer_preference_id',
        'location_id',
        'preference',
        'action_type',
        'request_type',
        'renewed_at',
        'cancelled_at',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'preference' => 'integer',
        'renewed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // Relationships
    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }

    public function transferPreference(): BelongsTo
    {
        return $this->belongsTo(TransferPreference::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    // Scopes
    public function scopeByAction($query, string $action)
    {
        return $query->where('action_type', $action);
    }

    public function scopeRenewed($query)
    {
        return $query->whereNotNull('renewed_at');
    }

    public function scopeCancelled($query)
    {
        return $query->whereNotNull('cancelled_at');
    }
}
