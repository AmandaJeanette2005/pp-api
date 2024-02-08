<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PipelineRepository;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    protected $pipelineRepo;

    public function __construct()
    {
        $this->pipelineRepo = new PipelineRepository();
    }

    public function index(Request $request)
    {
        $filters = $request->only(['pipeline_title']);
        return response()->json($this->pipelineRepo->indexPipeline($filters, $request->header('company_id')));
    }

    public function save(Request $request){

        return response()->json($this->pipelineRepo->save($request->all(), $request->header('company_id')));

    }

    public function delete(Request $request, $id = null){

        return response()->json($this->pipelineRepo->delete($id, $request->header('company_id')));

    }


}
