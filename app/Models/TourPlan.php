<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPlan extends Model
{
    use HasFactory;

    protected $table = 'TourPlans';
    protected $primaryKey = 'TourPlanId';
    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'tour';

    public function tourActions()
    {
        return $this->hasMany(TourPlanAction::class,'TourPlanId','TourPlanId');
    }
}
