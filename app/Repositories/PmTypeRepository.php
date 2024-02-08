<?php

namespace App\Repositories;

use App\Models\PmType;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PmTypeRepository
{
    public function index($filters, $companyId)
    {
        $pmType = PmType::with([]);
        if (!empty($filters['pm_type_name'])) {
            $pmType = $pmType->where('pm_type_name', 'LIKE', '%' . $filters['pm_type_name'] . '%');
        }
        $pmType = $pmType->where('company_id', $companyId);
        $pmType = $pmType->orderBy('id', 'desc')->paginate(25);
        return $pmType;
    }


    public function save($data, $companyId)
    {
        try {
            $v = Validator::make($data, [
                'pm_type_name' => 'required'
            ]);
            if ($v->fails()) {
                return response()->json(['error' => $v->errors()->first()]);
            }
    
            $company = Company::find($companyId);
            if (!$company) {
                return response()->json(['error' => 'Company not found']);
            }

            //update or create?
            if($data['id']){
                $pmType = PmType::find($data['id']);
                if(!$pmType) return response()->json(['error' => 'Type not found']);
            }else{
                $pmType = new PmType();
            }
    
            $pmType->company_id = $company->id;
            $pmType->pm_type_name = $data['pm_type_name'];
            $pmType->save();
    
            return response()->json(['message' => 'created successfully', $pmType]);
    
        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function delete($id, $companyId){

        try {
            $pmType = PmType::find($id);
            if(!$pmType) return response()->json(['error' => 'type not found']);

            //check by company_id
            if($pmType->company_id != $companyId) return response()->json(['error' => 'type not found']);

            $pmType->delete();

            return response()->json(['message' => 'type deleted successfully']);

        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }

    }
    

}