<?php

namespace App\Repositories;

use App\Models\PmDeal;
use App\Models\PmDealProgress;
use App\Models\PmPipeline;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PmDealRepository
{

    public function index($filters, $companyId)
    {
        $PmDeal = PmDeal::with([]);
        if (!empty($filters['deal_title'])) {
            $PmDeal = $PmDeal->where('deal_title', 'LIKE', '%' . $filters['deal_title'] . '%');
        }
        $PmDeal = $PmDeal->where('company_id', $companyId);
        $PmDeal = $PmDeal->orderBy('id', 'desc')->paginate(25);
        return $PmDeal;
    }


    public function saveDeal($data, $companyId)
    {
        try {
            DB::beginTransaction();

            $v = Validator::make($data, [
                'pm_type_id' => 'required',
                'deal_title' => 'required',
                'deal_description' => 'required',
                'deal_owner' => 'required',
                'deal_value' => 'required',
                'pipeline_id' => 'required',
                'stage_id' => 'required'
            ]);
            if ($v->fails()) {
                return response()->json(['error' => $v->errors()->first()]);
            }

            $company = Company::find($companyId);
            if (!$company) {
                return response()->json(['error' => 'Company not found']);
            }

            $PmPipeline = PmPipeline::find($data['pipeline_id']);
            if (!$PmPipeline) {
                return response()->json(['error' => 'Pipeline not found']);
            }

            //update or create?
            if($data['id']){
                $PmDeal = PmDeal::find($data['id']);
                if(!$PmDeal) return response()->json(['error' => 'Stage not found']);
            }else{
                $PmDeal = new PmDeal();
            }
    
            $PmDeal->company_id = $company->id;
            $PmDeal->pm_type_id = $data['pm_type_id'];
            $PmDeal->deal_title = $data['deal_title'];
            $PmDeal->deal_description = $data['deal_description'];
            $PmDeal->deal_owner = $data['deal_owner'];
            $PmDeal->deal_value = $data['deal_value'];
            $PmDeal->save();

            if(!$data['id']){
                $PmDealProgress = new PmDealProgress();
                $PmDealProgress->company_id = $company->id;
                $PmDealProgress->pipeline_id = $data['pipeline_id'];
                $PmDealProgress->stage_id = $data['stage_id'];
                $PmDealProgress->deal_id = $PmDeal->id;

                $PmDealProgress->save();
            }
    
            DB::commit();

            return response()->json(['message' => 'created successfully', $PmDeal]);
    
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function delete($id){

        try {
            $PmDeal = PmDeal::find($id);
            if(!$PmDeal) return response()->json(['error' => 'Stage not found']);

            $PmDeal->delete();

            return response()->json(['message' => 'Stage deleted successfully']);

        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }

    }

}