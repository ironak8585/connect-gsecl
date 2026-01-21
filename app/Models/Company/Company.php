<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public static function getCompanies()
    {
        return Company::get()->pluck('name', 'slug');
    }

    public static function getCompanyByShortName($shortName)
    {
        return Company::where('slug', '=', $shortName)->first();
    }

    public static function add($data){
        try {
            //code...
            $company = Company::firstOrCreate($data);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $company;
    }
}
