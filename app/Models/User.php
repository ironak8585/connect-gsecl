<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Company\Company;
use App\Models\Employee\EurjaEmployee;
use App\Models\Location\Location;
use Config;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, Notifiable, SoftDeletes, Userstamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'employee_number',
        'password',
        'company_id',
        'location_id',
        'department_id',
        'validate_through_eUrja',
        'is_active',
        'status',
        'last_eUrja_synced_at',
        'remember_token',
    ];

    // Relationship with company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relationship with company
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Mutators
    public function setNameAttribute($value)
    {
        // Remove common prefixes like Mr., Ms., etc.
        $value = preg_replace('/^(Mr\.?|Mrs\.?|Ms\.?|Shri\.?|Smt\.?)\s+/i', '', $value);

        // Convert to uppercase and split into parts
        $parts = preg_split('/\s+/', trim(strtoupper($value)));

        // Ensure there are at least 2 parts: first name and surname
        if (count($parts) >= 3) {
            // Initials of first and middle name
            $initials = substr($parts[0], 0, 1) . substr($parts[1], 0, 1);
            $surname = $parts[2];
        } elseif (count($parts) == 2) {
            // Just first initial and surname
            $initials = substr($parts[0], 0, 1);
            $surname = $parts[1];
        } else {
            // Fallback to original value
            $this->attributes['name'] = $value;
            return;
        }

        $this->attributes['name'] = $initials . ' ' . ucfirst(strtolower($surname));
    }

    // Relationships
    public function eurjaEmployee()
    {
        return $this->belongsTo(EurjaEmployee::class, 'employee_number', 'employee_number');
    }

    /**
     * Check if the user has the 'ADMIN' role.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('ADMIN');
    }

    /**
     * Check if the user has the 'SUPER_ADMIN' role.
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('SUPER_ADMIN');
    }

    /**
     * Check if the user is either ADMIN or SUPER_ADMIN.
     */
    public function isAdminOrSuperAdmin(): bool
    {
        return $this->hasAnyRole(['ADMIN', 'SUPER_ADMIN']);
    }

    /**
     * Register new user
     *
     * @param array $data     
     * @return User
     */
    public static function register($data)
    {
        DB::beginTransaction();

        $data['is_active'] = true;
        $data['status'] = Config::get("constants.admin.USER.STATUS.ACTIVE");

        // Update company to company id data
        // $data['company_id'] = Company::getCompanyByShortName($data['company'])->id;

        //create user
        try {
            $user = User::create($data);
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Exception("User create : " . $th->getMessage(), 1);
        }

        //assigne roles
        try {
            $user->assignRole(Config::get("constants.admin.USER.ROLES.EMPLOYEE"));
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Exception("Role assignment : " . $th->getMessage(), 1);
        }

        DB::commit();
        return $user;
    }

    /**
     * Update password in local db
     *
     * @param array $data     
     * @return User
     */
    public function updatePassword($data)
    {
        DB::beginTransaction();

        //create user
        try {
            $this->password = $data['password'];
            $this->save();
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Exception("User create : " . $th->getMessage(), 1);
        }

        DB::commit();

        return $this;
    }

}
