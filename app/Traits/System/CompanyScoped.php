<?php

namespace App\Traits\System;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait CompanyScoped
{
    public static function bootCompanyScoped()
    {
        static::creating(function ($model) {
            $user = Auth::user();
            if ($user && !$model->company_id) {
                $model->company_id = $user['company_id'];
            }
        });

        static::updating(function ($model) {
            $user = Auth::user();
            if ($user && !$model->company_id) {
                $model->company_id = $user['company_id'];
            }
        });

        // Add global scope only for non-admins
        static::addGlobalScope('company_scope', function (Builder $builder) {
            $user = Auth::user();

            if ($user && !self::shouldSkipCompanyScope($user)) {
                $builder->where($builder->getModel()->getTable() . '.company_id', $user['company_id']);
            }
        });
    }

    /**
     * Determine if the global scope should be skipped.
     */
    protected static function shouldSkipCompanyScope($user)
    {
        // Adjust role names as per your system
        return $user->hasRole('SUPER_ADMIN') || $user->hasRole('ADMIN');
    }

    /**
     * Bypass global scope manually when required.
     */
    public function scopeWithAllCompanies($query)
    {
        return $query->withoutGlobalScope('company_scope');
    }
}
