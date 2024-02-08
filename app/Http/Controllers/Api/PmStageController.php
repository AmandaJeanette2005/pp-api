<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PmStageRepository;
use Illuminate\Http\Request;

class PmStageController extends Controller
{
    protected $PmStageRepo;

    public function __construct()
    {
        $this->PmStageRepo = new PmStageRepository();
    }

    public function index(Request $request)
    {
        $filters = $request->only(['stage_title']);
        return response()->json($this->PmStageRepo->index($filters));
    }

    public function save(Request $request){

        return response()->json($this->PmStageRepo->save($request->all()));

    }

    public function delete(Request $request, $id = null){

        return response()->json($this->PmStageRepo->delete($id));

    }


}
