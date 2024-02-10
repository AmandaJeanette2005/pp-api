<?php

namespace App\Repositories;

use App\Models\PmPipeline;
use App\Models\Company;
use App\Models\PmType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PipelineRepository
{
    public function indexPipeline($filters, $companyId)
    {
        $pipeline = PmPipeline::with(['pm_type']);
        if (!empty($filters['pipeline_title'])) {
            $pipeline = $pipeline->where('pipeline_title', 'LIKE', '%' . $filters['pipeline_title'] . '%');
        }
        $pipeline = $pipeline->where('company_id', $companyId);
        $pipeline = $pipeline->orderBy('id', 'desc')->paginate(25);
        return $pipeline;
    }

    public function save($data, $companyId)
    {
        try {
            $v = Validator::make($data, [
                'pm_type_id' => 'required',
                'parent_id' => 'required',
                'pipeline_title' => 'required',
            ]);
            if ($v->fails()) {
                return response()->json(['error' => $v->errors()->first()]);
            }
    
            $company = Company::find($companyId);
            if (!$company) {
                return response()->json(['error' => 'Company not found']);
            }

            $PmType = PmType::find($data['pm_type_id']);
            if (!$PmType) {
                return response()->json(['error' => 'Pipeline Type not found']);
            }

            //update or create?
            if($data['id']){
                $pipeline = PmPipeline::find($data['id']);
                if(!$pipeline) return response()->json(['error' => 'pipeline not found']);
            }else{
                $pipeline = new PmPipeline();
            }
    
            $pipeline->company_id = $company->id;
            $pipeline->pm_type_id = $data['pm_type_id'];
            $pipeline->isParent = $data['isParent'];
            $pipeline->parent_id = $data['parent_id'];
            $pipeline->pipeline_title = $data['pipeline_title'];
            $pipeline->save();
    
            return response()->json(['message' => 'Pipeline created successfully', $pipeline]);
    
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function delete($id, $companyId){

        try {
            $pipeline = PmPipeline::find($id);
            if(!$pipeline) return response()->json(['error' => 'pipeline not found']);
            
            //check by company_id
            if($pipeline->company_id != $companyId) return response()->json(['error' => 'pipeline not found']);

            $pipeline->delete();

            return response()->json(['message' => 'Pipeline deleted successfully']);

        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }

    }
    

}