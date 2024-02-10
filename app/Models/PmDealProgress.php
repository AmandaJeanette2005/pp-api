<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmDealProgress extends Model
{
    use HasFactory;
    use SoftDeletes;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';
    
    protected $table = 'pm_deal_progress';
    protected $guarded = [];

    public function pm_pipeline(){
        return $this->hasOne(PmPipeline::class, 'id', 'pipeline_id');
    }
    public function pm_stage(){
        return $this->hasOne(PmStage::class, 'id', 'stage_id');
    }
    public function pm_deal(){
        return $this->hasOne(PmDeal::class, 'id', 'deal_id');
    }

}
