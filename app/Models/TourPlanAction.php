<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPlanAction extends Model
{
    use HasFactory;

    protected $table = 'TourPlanActions';
    protected $primaryKey = 'TourActionId';
    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'tour';
    public function TourPlan(){
        return $this->hasMany(TourPlan::class,'TourPlanId','TourPlanId');
    }
}
