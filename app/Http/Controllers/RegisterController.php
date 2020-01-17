<?php

namespace App\Http\Controllers;

use App\BranchParameter;
use App\BranchProviderParameter;
use App\BranchType;
use App\BranchZip;
use Illuminate\Http\Request;

use DB;
use App\User;
use App\BranchAddress;
use App\Branch;
use App\BranchEmail;
use App\BranchPhone;
use App\BranchProvider;
use App\BranchSupplier;
use App\BranchTax;
use App\Provider;
use App\BranchProviderType;

class RegisterController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
		$user = \Auth::user();
		$specificUser = User::where('user_id', \Auth::user()->user_id)->with('branchType')->first();
		
		$branch = Branch::find($user->branch_id);

		$branch_types = BranchType::where('status', '=', 'Active')->get();
		$addresses  = BranchAddress::where('branch_id', $user->branch_id)->get();
		
		$phones = BranchPhone::where('branch_id', $user->branch_id)->get();
		$emails = BranchEmail::where('branch_id', $user->branch_id)->get();
		$taxes =  BranchTax::where('branch_id', $user->branch_id)->get();
		
		list($bp, $p, $pt) = [
			'tb_branch_provider',
			'tb_provider',
			'tb_provider_type',
		];
		$providers = BranchProvider::query()
		->select("{$p}.provider_name", "{$bp}.status", "{$pt}.provider_type", "{$bp}.branch_provider_id")
		->join($p, "{$p}.provider_id", "{$bp}.provider_id")
		->join($pt, "{$pt}.provider_type_id", "{$p}.provider_type_id")
		->where("{$p}.status", 'Active')
		->where("{$pt}.status", 'Active')
		->where("{$bp}.branch_id", $branch->branch_id)
		->get();
		
		list($bs, $s, $st) = [
            'tb_branch_supplier',
            'tb_supplier',
            'tb_supplier_type',
        ];
		$suppliers = BranchSupplier::query()
            ->select("{$s}.supplier_name", "{$bs}.status", "{$st}.supplier_type", "{$bs}.branch_supplier_id", "{$s}.supplier_id")
            ->join($s, "{$s}.supplier_id", "{$bs}.supplier_id")
            ->join($st, "{$st}.supplier_type_id", "{$s}.supplier_type_id")
            ->where("{$s}.status", 'Active')
		    ->where("{$st}.status", 'Active')
            ->where("{$bs}.branch_id", $branch->branch_id)
            ->get();
            
            list($bp, $p, $pt) = [
            'tb_branch_provider',
            'tb_provider',
            'tb_provider_type',
        ];
            
        $parameters = BranchParameter::query()
            ->select('branch_parameter_id',
                'parameter_name',
                'parameter_type',
                'parameter_length',
                'parameter_precision',
                'parameter_value',
                'parameter_desc',
                'parameter_mask')
            ->where("branch_id", $branch->branch_id)
            ->where("status", 'Active')
            ->get();
        $radius = null;
        foreach($parameters as $k=>$parameter)
        {
            if($parameter->parameter_name == 'radius')
            {
                $radius = $parameter->parameter_value;
                unset($parameters[$k]);
            }
        }

        $zipcodes = BranchZip::query()->where('branch_id', $branch->branch_id)->get();

        return view('register', [
				// 'providertypes'=>$rows, 
				'branch_types'=>$branch_types, 
				'branch'    => $branch,
				'addresses' => $addresses,
				'phones'    => $phones,
				'emails'    => $emails,
				'taxes'     => $taxes,
				'providers'   => $providers,
				'suppliers' => $suppliers,
				'user'   => $specificUser,
				'parameters' => $parameters,
                'zipcodes' => $zipcodes,
                'radius' => $radius
			]
		    ); 
    }

    public function getProviderName(Request $request){
        $input = $request->all();
        $pid = $input['type_ids'];
        $rows = DB::table('tb_provider')->whereIn('provider_type_id', $pid)->get()->toArray();
        return response()->json(['names'=>$rows]);
    }
}
