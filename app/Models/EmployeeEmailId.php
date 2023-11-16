<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeEmailId extends Model
{
    use HasFactory;

    protected $table = 'EmployeeEmailId';

    protected $primaryKey = 'EmpCode';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $guarded = [];
}
