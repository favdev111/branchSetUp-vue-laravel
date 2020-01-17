<?php

namespace App\Http\Controllers;

use App\BranchDefaultParameter;
use App\BranchSupplier;
use App\BranchParameter;
use App\BranchSupplierParameter;
use App\BranchZip;
use App\Provider;
use App\User;
use Illuminate\Http\Request;
use App\BranchAddress;
use App\Branch;
use App\BranchEmail;
use App\BranchPhone;
use App\BranchProvider;
use App\BranchProviderType;
use App\BranchSupplierType;
use App\BranchProviderParameter;
use App\BranchTax;
use DB;

class BranchController extends Controller
{
    public function index() {

    }

    //add branch
    public function add_branch(Request $request){
        // dd('aaa');
        $branch = $request['branch'];
        $address = $request['address_arr'];
        $phone = $request['phone_arr'];
        $email = $request['email_arr'];
        $tax = $request['tax_arr'];
        $provider = $request['provider_arr'];
        $supplier = $request['supplier_arr'];
        $parameters = $request['parameters'];
        $zipcodes = $request->get('zipcodes', []);
        $radius = $request['radius'];

        $user = User::find(\Auth::user()->user_id);
        $user->branch_created = true;
        $user->save();


        $updateRecord = false;

        if(isset(\Auth::user()->branch_id) && !empty(\Auth::user()->branch_id)){
            $updateRecord = true;
        }
        $branch_id = \Auth::user()->branch_id;
        BranchAddress::where('branch_id', $branch_id)->delete();
        BranchEmail::where('branch_id', $branch_id)->delete();
        BranchPhone::where('branch_id', $branch_id)->delete();
        BranchTax::where('branch_id', $branch_id)->delete();

        try {
            $updated_ids = array();


            if($updateRecord){

                $new_branch = Branch::find(\Auth::user()->branch_id);

            }else{

                $new_branch = new Branch;
                $user = User::find(\Auth::user()->user_id);
                $user->branch_id = $new_branch->branch_id;
                $user->save();
            }
            $new_branch->branch_type_id = $branch['type'];
            $new_branch->branch_name = $branch['name'];
            $new_branch->time_zone  = $branch['timezone'];
            // $new_branch->Service_Radius = $branch['radius'];
            // $new_branch->Mult_Reg = $branch['mulreg'] == 'true'? 1: 0;
            // $new_branch->No_Skills = $branch['noskill'] == 'true'? 1: 0;
            // $new_branch->Time_Format = $branch['timeformat'];
            $new_branch->save();

            $updated_ids['branch']    =   $new_branch->branch_id;

            foreach ($address as $key => $data) {
                # code...
                $new_address = new BranchAddress;
                $new_address->branch_id = $new_branch->branch_id;

                if($data['type'] != '')
                {
                    $new_address->address_type = $data['type'];
                    $new_address->address_type = 'office';
                    $new_address->address = $data['address1'];
                    $new_address->address2 = $data['address2'];
                    $new_address->city = $data['city'];
                    $new_address->county = $data['county'];
                    //$new_address->country = $data['county'];
                    //$new_address->state = $data['city'];
                    $new_address->zipcode = $data['zip'];
                    $new_address->save();

                    $updated_ids['address'][]    =   $new_address->branch_address_id;
                }
            }

            foreach ($phone as $key => $data) {
                # code...
                if($data['type'] != '')
                {
                    $new_phone = new BranchPhone();
                    $new_phone->branch_id = $new_branch->branch_id;
                    $new_phone->phone_type = config('const.phone_type')[$data['type']];
                    $new_phone->phone = $data['number'];
                    $new_phone->save();

                    $updated_ids['phone'][]    =   $new_phone->branch_phone_id;
                }

            }

            foreach ($email as $key => $data) {
                if($data['type'] != '')
                {
                    $new_email = new BranchEmail();
                    $new_email->branch_id = $new_branch->branch_id;
                    $new_email->email_type = config('const.email_type')[$data['type']];
                    $new_email->email = $data['address'];
                    $new_email->save();

                    $updated_ids['email'][]    =   $new_email->branch_email_id;
                }
            }

            foreach ($tax as $key => $data) {
                # code...
                $new_tax = new BranchTax();

                $new_tax->branch_id =  $new_branch->branch_id;
                $new_tax->tax_type = $data['type'];
                $new_tax->tax_percent = $data['percent'];
                $new_tax->save();

                $updated_ids['tax'][]    =   $new_tax->branch_tax_id;
            }

            $provider   =   array_pop($provider);
            foreach ($provider['name'] as $pro) {
                $pr = BranchProvider::find($pro);
                $new_provider = new BranchProvider();
                $new_provider->branch_id = $new_branch->branch_id;
                $new_provider->provider_id = $pr->provider_id;
                $new_provider->save();

                $updated_ids['provider_name'][]    =   $new_provider->branch_provider_id;
            }

            if (isset($provider['type'])) {
                foreach ($provider['type'] as $pro) {
                    $new_provider_type = new BranchProviderType();
                    $new_provider_type->branch_type_id = $branch['type'];
                    $new_provider_type->provider_type_id = $pro;
                    $new_provider_type->save();
                    $updated_ids['provider_type'][]    =   $new_provider_type->branch_provider_type_id;
                }
            }
            
            $supplier   =   array_pop($supplier);
            if (isset($supplier['name']))
            foreach ($supplier['name'] as $pro) {
                $sup = BranchSupplier::find($pro);
                $new_supplier = new BranchSupplier();
                $new_supplier->branch_id = $new_branch->branch_id;
                $new_supplier->supplier_id = $sup->supplier_id;
                $new_supplier->save();

                $updated_ids['supplier_name'][]    =   $new_supplier->branch_supplier_id;
            }

            if (isset($supplier['type'])) {
                foreach ($supplier['type'] as $pro) {
                    $new_provider_type = new BranchSupplierType();
                    $new_provider_type->branch_type_id = $branch['type'];
                    $new_provider_type->supplier_type_id = $pro;
                    $new_provider_type->save();
                    $updated_ids['supplier_type'][]    =   $new_provider_type->branch_supplier_type_id;
                }
            }
            
            foreach($parameters as $key=>$value) {
                if ($value == "on") {
                    $value = "Y";
                }
                BranchParameter::where('branch_parameter_id', $key)
                    ->update(['parameter_value' => $value]);
            }
            $parameters_check = BranchParameter::select('branch_parameter_id')
                ->where('branch_id', $new_branch->branch_id)
                ->where('parameter_type', 'CHECK')
                ->get();
    
            foreach($parameters_check as $parameter_check) {
                if(!isset($parameters[$parameter_check->branch_parameter_id])) {
                    BranchParameter::where('branch_parameter_id', $parameter_check->branch_parameter_id)
                        ->update(['parameter_value' => 'N']);
                }
            }

            BranchZip::query()->where('branch_id', $new_branch->branch_id)->delete();
            foreach($zipcodes as $zipcode)
            {
                $zip = new BranchZip;
                $zip->branch_id = $new_branch->branch_id;
                $zip->zipcode = $zipcode;
                $zip->save();
            }

            $radiusRecord = BranchParameter::query()
                ->where('branch_id', $new_branch->branch_id)
                ->where('parameter_name', 'radius')
                ->first();
            $radiusRecord->parameter_value = $radius;
            $radiusRecord->status = 'Active';
            $radiusRecord->save();

            return response()->json(['result' => "success", "message" => "successfully registered!", "updated_ids" => json_encode($updated_ids)]);
        }
        catch (Exception $e) {
            return response()->json(['result' => 'failed', 'message' => $e->getMessage()]);
        }
        catch (InvalidArgumentException $e) {
            return response()->json(['result' => 'failed', 'message' => $e->getMessage()]);
        }
    }

    public function branchTypeProviders(Request $request)
    {
        if(!(\Auth::user()->branch_id)){
            $new_branch = new Branch;
            $new_branch->save();
            $user = User::find(\Auth::user()->user_id);
            $user->branch_id = $new_branch->branch_id;
            $user->save();
        } else {
            $new_branch = Branch::find(\Auth::user()->branch_id);
        }
        $new_branch->branch_type_id = $request->branch_type_id;
        $new_branch->save();
        list($bp, $p, $pt) = [
            'tb_branch_provider',
            'tb_provider',
            'tb_provider_type',
        ];

        $providers = BranchProvider::query()
            ->select("{$p}.provider_name","{$pt}.provider_type","{$bp}.branch_provider_id", "{$bp}.status")
            ->join($p, "{$p}.provider_id", "{$bp}.provider_id")
            ->join($pt, "{$pt}.provider_type_id", "{$p}.provider_type_id")
            ->where("{$p}.status", 'Active')
            ->where("{$pt}.status", 'Active')
            ->where("{$bp}.branch_id", $new_branch->branch_id)
            ->get();

        return response()->json(['providers' => $providers]);
    }
    public function add_provider_parameters(Request $request)
    {
        $new_branch = Branch::find(\Auth::user()->branch_id);
        $input = $request->all();
        $provider_id = $input['provider_id'];
        unset($input['provider_id']);
        BranchProvider::where('branch_provider_id', $provider_id)
            ->update(['status' => 'Active']);
        foreach($input as $key=>$value) {
            if ($value == "on") {
                $value = "Y";
            }
            BranchProviderParameter::where('branch_provider_parameter_id', $key)
                ->update(['parameter_value' => $value]);
        }
        $parameters_check = BranchProviderParameter::select('branch_provider_parameter_id')
            ->where('branch_provider_id', $provider_id)
            ->where('parameter_type', 'CHECK')
            ->get();

        foreach($parameters_check as $parameter_check) {
            if(!isset($input[$parameter_check->branch_provider_parameter_id])) {
                BranchProviderParameter::where('branch_provider_parameter_id', $parameter_check->branch_provider_parameter_id)
                    ->update(['parameter_value' => 'N']);
            }
        }
        return response()->json(['result' => "success", "message" => "successfully saved!"]);
    }

    public function branchTypeProviderParameters(Request $request)
    {
        $new_branch = Branch::find(\Auth::user()->branch_id);

        list($bpp, $bp) = [
            'tb_branch_provider_parameter',
            'tb_branch_provider',
        ];
        $parameters = BranchProviderParameter::query()
            ->select('branch_provider_parameter_id',
                'parameter_name',
                'parameter_type',
                'parameter_length',
                'parameter_precision',
                'parameter_value',
                'parameter_desc',
                'parameter_mask')
            ->join($bp, "{$bp}.branch_provider_id", "{$bpp}.branch_provider_id")
            ->where("{$bp}.branch_id", $new_branch->branch_id)
            ->where("{$bp}.branch_provider_id", $request->branch_provider_id)
            ->where("{$bpp}.status", 'Active')
            ->get();

        return response()->json(['parameters' => $parameters]);
    }

    public function branchTypeSuppliers(Request $request)
    {
        if(!(\Auth::user()->branch_id)){
            $new_branch = new Branch;
            $new_branch->save();
            $user = User::find(\Auth::user()->user_id);
            $user->branch_id = $new_branch->branch_id;
            $user->save();
        } else {
            $new_branch = Branch::find(\Auth::user()->branch_id);
        }
        $new_branch->branch_type_id = $request->branch_type_id;
        $new_branch->save();
        list($bs, $s, $st) = [
            'tb_branch_supplier',
            'tb_supplier',
            'tb_supplier_type',
        ];
        $suppliers = BranchSupplier::query()
            ->select("{$s}.supplier_name", "{$st}.supplier_type", "{$bs}.branch_supplier_id", "{$s}.supplier_id")
            ->join($s, "{$s}.supplier_id", "{$bs}.supplier_id")
            ->join($st, "{$st}.supplier_type_id", "{$s}.supplier_type_id")
            ->where("{$s}.status", 'Active')
		    ->where("{$st}.status", 'Active')
            ->where("{$bs}.branch_id", $new_branch->branch_id)
            ->get();

        return response()->json(['suppliers' => $suppliers]);
    }
    public function add_supplier_parameters(Request $request)
    {
        $new_branch = Branch::find(\Auth::user()->branch_id);
        $input = $request->all();
        $supplier_id = $input['supplier_id'];
        unset($input['supplier_id']);
        BranchSupplier::where('branch_supplier_id', $supplier_id)
            ->update(['status' => 'Active']);
        foreach($input as $key=>$value) {
            if ($value == "on") {
                $value = "Y";
            }
            BranchSupplierParameter::where('branch_supplier_parameter_id', $key)
                ->update(['parameter_value' => $value]);
        }
        $parameters_check = BranchSupplierParameter::select('branch_supplier_parameter_id')
            ->where('branch_supplier_id', $supplier_id)
            ->where('parameter_type', 'CHECK')
            ->get();

        foreach($parameters_check as $parameter_check) {
            if(!isset($input[$parameter_check->branch_supplier_parameter_id])) {
                BranchSupplierParameter::where('branch_supplier_parameter_id', $parameter_check->branch_supplier_parameter_id)
                    ->update(['parameter_value' => 'N']);
            }
        }
        return response()->json(['result' => "success", "message" => "successfully saved!"]);
    }

    public function branchTypeSupplierParameters(Request $request)
    {
        $new_branch = Branch::find(\Auth::user()->branch_id);

        list($bpp, $bp) = [
            'tb_branch_supplier_parameter',
            'tb_branch_supplier',
        ];
        $parameters = BranchSupplierParameter::query()
            ->select('branch_supplier_parameter_id',
                'parameter_name',
                'parameter_type',
                'parameter_length',
                'parameter_precision',
                'parameter_value',
                'parameter_desc',
                'parameter_mask')
            ->join($bp, "{$bp}.branch_supplier_id", "{$bpp}.branch_supplier_id")
            ->where("{$bp}.branch_id", $new_branch->branch_id)
            ->where("{$bp}.branch_supplier_id", $request->branch_supplier_id)
            ->where("{$bpp}.status", 'Active')
            ->get();

        return response()->json(['parameters' => $parameters]);
    }
}
