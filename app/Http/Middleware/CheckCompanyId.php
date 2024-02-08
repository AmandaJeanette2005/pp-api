<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;

class CheckCompanyId
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @paramstring  $role
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->header('company_id')) return response()->json(['error' => 'Company Id is required']);

        $company = Company::where('id', $request->header('company_id'))->first(); 
        if (!$company) return response()->json(['error' => 'Company not found']);

        $request->headers->set('company_id', $company->id);
        return $next($request);
        
    }
}