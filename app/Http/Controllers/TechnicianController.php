<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Technician;
use App\Branch;
use App\BranchTechnician;
use App\BranchTechnicianParameter;
use App\TechnicianBranchProvider;
use App\BranchTechnicianZip;
use App\BranchTechnicianStack;
use App\BranchZip;
use DB;
use Auth;

class TechnicianController extends Controller
{
    //
    public function index()
    {
        $branchTechnicians = BranchTechnician::where('branch_id', Auth::user()->branch->branch_id)
            ->with('technician')
            ->orderBy('created', 'DESC')
            ->get();
    	return response()->json($branchTechnicians);
    }


    public function store(Request $request)
    {
    	$this->validate($request, [
    		'first_name' => 'required|string',
    		'last_name' => 'required|string',
    	]);

    	$i = 1;
    	while (true):
    		$username  = preg_replace('/\s+/', '', strtolower($request->first_name . $request->last_name)) . $i;
    		$exists = Technician::where('technician_login', $username)->first();

    		if (!$exists) break;
    		$i++;
    	endwhile;

        $digits = 3;
        $password = $username . rand(pow(10, $digits-1), pow(10, $digits)-1);

    	$technician_id = DB::select('call sp_technician_create(?,?,?,?,?)',[
    		$username, 
    		bcrypt($password),
    		$request->first_name, 
            $request->middle_name, 
    		$request->last_name, 
    	]);


        $branch = Auth::user()->branch;
        $branch_technician_id = DB::select('call sp_branch_technician_assign(?,?)',[
            $branch->branch_id, 
            $technician_id[0]->result
        ]);

        /*$branchZips = BranchZip::where('branch_id', $branch->branch_id)->get();
        foreach ($branchZips as $zip):
            BranchTechnicianZip::create([
                'branch_technician_id' => $branch_technician_id[0]->result,
                'zipcode' => $zip->zipcode,
                'status' => 'Active'
            ]);
        endforeach;*/



        $technician = Technician::find($technician_id[0]->result);
        $technician->password_encrypt = $password;
        $technician->save();

    	return response()->json(BranchTechnician::where('technician_id', $technician->technician_id)->first()->load('technician'));
    }




    public function show($id)
    {
    	$technician = Technician::where('technician_id', $id)->firstOrFail();
    	return response()->json($technician->load(
            'branch_technician.branch_technician_parameters',
            'branch_technician.technician_branch_providers.branch_provider.provider',
            'branch_technician.branch_technician_zips',
            'branch_technician.branch_technician_stacks'
        ));
    }



    public function update($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:Active,Inactive,Created,Approved'
        ]);
        $technician = Technician::where('technician_id', $id)->firstOrFail();
        $technician->update([
            'status' => $request->status
        ]);
        return response()->json($technician);
    }

    public function updateStack($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:Active,Inactive'
        ]);

        $technician = Technician::where('technician_id', $id)->firstOrFail();
        $branchTechnicianStack = BranchTechnicianStack::updateOrCreate(
            [
                'branch_technician_stack_id' => $request->branch_technician_stack_id
            ],
            [
                'status' => $request->status
            ]
        );
        return response()->json($branchTechnicianStack);
    }


    public function updateZip($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:Active,Inactive'
        ]);

        $technician = Technician::where('technician_id', $id)->firstOrFail();
        $branchTechnicianZip = BranchTechnicianZip::updateOrCreate(
            [
                'technician_zip_id' => $request->technician_zip_id
            ],
            [
                'status' => $request->status
            ]
        );
        return response()->json($branchTechnicianZip);
    }




    public function updateBranch($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:Active,Inactive'
        ]);

        $technician = Technician::where('technician_id', $id)->firstOrFail();
        $technicianBranchProvider= TechnicianBranchProvider::updateOrCreate(
            [
                'tb_technician_branch_provider_id' => $request->tb_technician_branch_provider_id
            ],
            [
                'status' => $request->status
            ]
        );
        return response()->json($technicianBranchProvider);
    }




    public function updateParameters($id, Request $request)
    {
    	$technician = Technician::where('technician_id', $id)->firstOrFail();
    	$this->validate($request, [
    		'parameters' => 'nullable|array',
    	]);


    	$parameters = [];

    	if (count($request->parameters) > 0): 
    		foreach ($request->parameters as $parameter):
    			$parameters[] = BranchTechnicianParameter::find($parameter['branch_technician_parameter_id'])->update(
    				[
                        'parameter_value' => $parameter['parameter_value']
    				]
    			);
    		endforeach;
    	endif;

    	return response()->json($parameters);
    }
}
