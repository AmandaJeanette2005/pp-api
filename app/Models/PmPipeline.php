<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmPipeline extends Model
{
    use HasFactory;
    use SoftDeletes;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    const DELETED_AT = 'deleted_at';
    
    protected $table = 'pm_pipelines';
    protected $guarded = [];

    public function pm_type(){
        return $this->hasOne(PmType::class, 'id', 'pm_type_id');
    }
    public function pm_stages() {
        return $this->hasMany(PmStage::class, 'pipeline_id', 'id');
    }
    
}
