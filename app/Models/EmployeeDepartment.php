<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDepartment extends Model
{
    use HasFactory;

    protected $table = 'EmployeeDepartment';
    protected $primaryKey = 'EmpCode';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $guarded = [];
}
