<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyProfile extends Model
{
    use HasFactory;

    /**
     * Get the Details from eUrja 
     * @param \App\Models\User $user
     * @return array
     */
    public static function syncEUrja(User $user)
    {
        try {
            $employeeDetails = EUrja::eUrjaGetEmployeeDetails('gsecl', $user->employee_number);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $employeeDetails;
    }

}
