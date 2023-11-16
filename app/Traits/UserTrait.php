<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait UserTrait
{
    public function getUserData($empCode)
    {
        return DB::table('Personal','p')
            ->select('e.EmpCode as UserId','p.Name','d.DesgName')
            ->join('Employer as e','e.EmpCode','p.EmpCode')
            ->join('Designation as d','d.DesgCode','e.DesgCode')
            ->where('p.EmpCode',$empCode)->first();
    }


}