<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'Department';

    protected $primaryKey = 'DeptCode';

    protected $keyType = 'string';
    public $timestamps = false;
    protected $guarded = [];
}
