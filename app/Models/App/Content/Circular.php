<?php

namespace App\Models\App\Content;

use App\Models\Company\Company;
use App\Models\Location\Location;
use App\Models\Master\CircularCategory;
use App\Models\Master\Department;
use App\Models\User;
use App\Services\FileUploadService;
use App\Traits\System\CompanyScoped;
use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Mattiverse\Userstamps\Traits\Userstamps;

class Circular extends Model
{
    use SoftDeletes, Timestamp, Userstamps, CompanyScoped;

    protected $fillable = [
        'company_id',
        'department_id',
        'category_id',
        'title',
        'description',
        'circular_number',
        'attachment',
        'issue_date',
        'effective_date',
        'expiry_date',
        'published_at',
        'status',
        'visibility',
        'all_locations',
        'audience',
        'created_by',
        'approved_by',
        'published_by',
        'views_count',
        'download_count',
        'is_active',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'audience' => 'array',
        'all_locations' => 'boolean',
        'issue_date' => 'date',
        'effective_date' => 'date',
        'expiry_date' => 'date',
        'published_at' => 'datetime',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function category()
    {
        return $this->belongsTo(CircularCategory::class, 'category_id');
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class, 'circular_location')
            ->withTimestamps();
    }

    // User references
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function publisher()
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('status', 'PUBLISHED')
            ->where('is_active', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForLocation($query, $locationId)
    {
        return $query->where(function ($q) use ($locationId) {
            $q->where('all_locations', true)
                ->orWhereHas('locations', fn($q2) => $q2->where('locations.id', $locationId));
        });
    }

    // Correctly combine all global scopes in a single booted() method
    protected static function booted()
    {
        static::addGlobalScope('active', function ($query) {
            $query->where('is_active', true);
        });

        static::addGlobalScope('latest_first', function ($query) {
            $query->orderBy('created_at', 'desc');
        });
    }

    // Mutator
    /**
     * Accessor to get downloadable file URL.
     */
    public function getAttachmentUrlAttribute()
    {
        if (!$this['attachment']) {
            return null;
        }

        // Construct full URL using your config constant
        return Storage::url(config('constants.system.PATH.PREFIX.CIRCULAR') . '/' . $this['attachment']);
    }

    /**
     * Summary of add
     * 
     * @param mixed $data
     * @return Circular
     */
    public static function add($data)
    {
        $circular = [
            'department_id' => $data['department_id'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'circular_number' => $data['circular_number'] ?? null,
            'attachment' => $data['attachment'],
            'issue_date' => $data['issue_date'],
            'effective_date' => $data['effective_date'] ?? null,
            'expiry_date' => $data['expiry_date'] ?? null,
            'published_at' => $data['published_at'] ?? null,
            'status' => $data['status'] ?? config('constants.master.CIRCULAR_STATUS.DRAFT'),
            'visibility' => $data['visibility'] ?? config('constants.master.CIRCULAR_VISIBILITY.INTERNAL'),
            'all_locations' => $data['all_locations'] ?? true,
            'audience' => $data['audience'] ?? null,
            'approved_by' => $data['approved_by'] ?? null,
            'published_by' => $data['published_by'] ?? null,
            'views_count' => 0,
            'download_count' => 0,
            'is_active' => $data['is_active'] ?? true,
        ];

        // create the record
        try {
            //code...
            return self::create($circular);
        } catch (\Throwable $th) {
            report($th);
            throw $th;
        }
    }

    /**
     * Summary of edit
     * 
     * @param mixed $data
     * @return static
     */
    public function edit($data)
    {
        try {
            $this->update($data);
        } catch (\Throwable $th) {
            report($th);
            throw $th;
        }

        return $this;
    }

    /**
     * Soft delete the circular and optionally remove the file.
     *
     * @param bool $deleteFile
     * @return bool
     */
    public function softRemove(bool $deleteFile = false): bool
    {
        try {
            if ($deleteFile && $this['attachment']) {
                FileUploadService::delete($this['attachment']);
            }

            return $this->delete();
        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }

    /**
     * Restore a soft-deleted circular.
     *
     * @return bool
     */
    public function restoreCircular(): bool
    {
        try {
            return $this->restore();
        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }

    /**
     * Permanently delete a circular and its file.
     *
     * @return bool
     */
    public function forceRemove(): bool
    {
        try {
            if ($this['attachment']) {
                FileUploadService::delete($this['attachment']);
            }

            return $this->forceDelete();
        } catch (\Throwable $th) {
            report($th);
            return false;
        }
    }
}