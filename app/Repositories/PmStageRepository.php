<?php

namespace App\Repositories;

use App\Models\PmStage;
use App\Models\Company;
use App\Models\PmPipeline;
use Illuminate\Support\Facades\Validator;

class PmStageRepository
{
    public function index($filters)
    {
        $pmStage = PmStage::with([]);
        if (!empty($filters['stage_title'])) {
            $pmStage = $pmStage->where('stage_title', 'LIKE', '%' . $filters['stage_title'] . '%');
        }
        $pmStage = $pmStage->orderBy('id', 'desc')->paginate(25);
        return $pmStage;
    }


    public function save($data)
    {
        try {
            $v = Validator::make($data, [
                'pipeline_id' => 'required',
                'pm_type_id' => 'required',
                'pipeline_index' => 'required',
                'stage_title' => 'required'
            ]);
            if ($v->fails()) {
                return response()->json(['error' => $v->errors()->first()]);
            }

            $PmPipeline = PmPipeline::find($data['pipeline_id']);
            if (!$PmPipeline) {
                return response()->json(['error' => 'Pipeline not found']);
            }

            //update or create?
            if($data['id']){
                $pmStage = PmStage::find($data['id']);
                if(!$pmStage) return response()->json(['error' => 'Stage not found']);
            }else{
                $pmStage = new PmStage();
            }
    
            $pmStage->pipeline_id = $data['pipeline_id'];
            $pmStage->pm_type_id = $data['pm_type_id'];
            $pmStage->pipeline_index = $data['pipeline_index'];
            $pmStage->stage_title = $data['stage_title'];
            $pmStage->save();
    
            return response()->json(['message' => 'created successfully', $pmStage]);
    
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function delete($id){

        try {
            $pmStage = PmStage::find($id);
            if(!$pmStage) return response()->json(['error' => 'Stage not found']);

            $pmStage->delete();

            return response()->json(['message' => 'Stage deleted successfully']);

        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }

    }
    

}