<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use App\Branch;
use App\BranchEmployee;
use App\BranchEmployeeParameter;
use App\EmployeeRole;
use DB;
use Auth;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $branchEmployees = BranchEmployee::where('branch_id', Auth::user()->branch->branch_id)
            ->with('employee')
            ->orderBy('created', 'DESC')
            ->get();
    	return response()->json($branchEmployees);
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
    		$exists = Employee::where('employee_login', $username)->first();

    		if (!$exists) break;
    		$i++;
    	endwhile;

        $digits = 3;
    	$password = $username . rand(pow(10, $digits-1), pow(10, $digits)-1);

    	$employee_id = DB::select('call sp_branch_create_employee(?,?,?,?,?,?)',[
    		Auth::user()->branch->branch_id, 
    		$username,
    		bcrypt($password),
    		$request->first_name, 
    		$request->middle_name, 
    		$request->last_name, 
    	]);

    	$employee = Employee::find($employee_id[0]->result);
        $employee->password_encrypt = $password;
        $employee->save();

        $branchEmployee = BranchEmployee::where('employee_id', $employee->employee_id)->first();
    	return response()->json($branchEmployee->load('employee'));
    }




    public function show($id)
    {
    	$employee = Employee::where('employee_id', $id)->firstOrFail();
    	return response()->json($employee->load('branch_employee.branch_employee_parameters', 'roles.role'));
    }



    public function update($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:Active,Inactive,Created,Approved'
        ]);
        $employee = Employee::where('employee_id', $id)->firstOrFail();
        $employee->update([
            'status' => $request->status
        ]);
        return response()->json($employee->load('branch_employee.branch_employee_parameters', 'roles.role'));
    }



    public function updateRole($id, Request $request)
    {
        $this->validate($request, [
            'role_id' => 'required|exists:tb_role,role_id'
        ]);
        $employee = Employee::where('employee_id', $id)->firstOrFail();
        $employeeRole = EmployeeRole::updateOrCreate(
            [
                'role_id' => $request->role_id,
                'employee_id' => $employee->employee_id,
            ],
            [
                'status' => $request->status
            ]
        );
        return response()->json($employee->load('branch_employee.branch_employee_parameters', 'roles.role'));
    }



    public function updateParameters($id, Request $request)
    {
    	$employee = Employee::where('employee_id', $id)->firstOrFail();
    	$this->validate($request, [
    		'parameters' => 'nullable|array',
    	]);


    	$parameters = [];

    	if (count($request->parameters) > 0): 
    		foreach ($request->parameters as $parameter):
                $parameters[] = BranchEmployeeParameter::find($parameter['branch_employee_parameter_id'])->update(
                    [
                        'parameter_value' => $parameter['parameter_value']
                    ]
                );
    		endforeach;
    	endif;

    	return response()->json($parameters);
    }


    public function branchRoles($id)
    {
    	$branchEmployee = BranchEmployee::where('employee_id', $id)->first();
    	if ($branchEmployee):
    		$roles = $branchEmployee->branch->type->roles;
    		return response()->json($roles);
    	endif;

    	return [];
    }
}
