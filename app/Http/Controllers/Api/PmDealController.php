<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PmDealRepository;
use Illuminate\Http\Request;

class PmDealController extends Controller
{
    protected $PmDealRepo;

    public function __construct()
    {
        $this->PmDealRepo = new PmDealRepository();
    }

    public function index(Request $request)
    {
        $filters = $request->only(['deal_title']);
        return response()->json($this->PmDealRepo->index($filters, $request->header('company_id')));
    }

    public function save(Request $request){
 
        return response()->json($this->PmDealRepo->save($request->all(), $request->header('company_id')));

    }

    public function delete(Request $request, $id = null){

        return response()->json($this->PmDealRepo->delete($id, $request->header('company_id')));

    }


}
