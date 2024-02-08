<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PmTypeRepository;
use Illuminate\Http\Request;

class PmTypeController extends Controller
{
    protected $PmTypeRepo;

    public function __construct()
    {
        $this->PmTypeRepo = new PmTypeRepository();
    }

    public function index(Request $request)
    {
        $filters = $request->only(['pm_type_name']);
        return response()->json($this->PmTypeRepo->index($filters, $request->header('company_id')));
    }

    public function save(Request $request){

        return response()->json($this->PmTypeRepo->save($request->all(), $request->header('company_id')));

    }

    public function delete(Request $request, $id = null){

        return response()->json($this->PmTypeRepo->delete($id, $request->header('company_id')));

    }


}
