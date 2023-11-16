<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'Employer';

    protected $primaryKey = 'EmpCode';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $guarded = [];

    public function division(){
        return $this->belongsTo(Division::class,'DivCode','DivCode');
    }
    public function department(){
        return $this->belongsTo(Department::class,'DeptCode','DeptCode');
    }
    public function designation(){
        return $this->belongsTo(Designation::class,'DesgCode','DesgCode');
    }
    public function email(){
        return $this->hasOne(EmployeeEmailId::class,'EmpCode','EmpCode');
    }
    public function personal(){
        return $this->hasOne(Personal::class,'EmpCode','EmpCode');
    }
    public function education(){
        return $this->hasOne(Education::class,'EmpCode','EmpCode')->orderBy('PassYear','desc');
    }
    public function emphist(){
        return $this->hasOne(EMPHIST::class,'EMPCODE','EmpCode')->orderBy('SerialNo','desc');
    }
}
