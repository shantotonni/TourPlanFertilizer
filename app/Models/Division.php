<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'Division';

    protected $primaryKey = 'DivCode';

    protected $keyType = 'string';
    public $timestamps = false;
    protected $guarded = [];
}
