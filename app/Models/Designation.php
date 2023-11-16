<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $table = 'Designation';

    protected $primaryKey = 'DesgCode';
    public $timestamps = false;
    protected $guarded = [];
}
