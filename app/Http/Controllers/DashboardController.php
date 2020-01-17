<?php

namespace App\Http\Controllers;

use App\Branch;
use App\BranchAddress;
use App\BranchEmail;
use App\BranchParameter;
use App\BranchPhone;
use App\BranchProvider;
use App\BranchProviderParameter;
use App\BranchSupplier;
use App\BranchSupplierParameter;
use App\BranchTax;
use App\BranchType;
use App\BranchZip;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->load('branchType', 'branch');

        $addresses = BranchAddress::where('branch_id', $user->branch_id)->get();
        $phones = BranchPhone::where('branch_id', $user->branch_id)->get();
        $emails = BranchEmail::where('branch_id', $user->branch_id)->get();
        $taxes = BranchTax::where('branch_id', $user->branch_id)->get();

        list($bp, $p, $pt) = [
            'tb_branch_provider',
            'tb_provider',
            'tb_provider_type',
        ];
        $providers = BranchProvider::query()
            ->select("{$p}.provider_name", "{$bp}.status", "{$pt}.provider_type", "{$bp}.branch_provider_id", "{$p}.provider_id")
            ->join($p, "{$p}.provider_id", "{$bp}.provider_id")
            ->join($pt, "{$pt}.provider_type_id", "{$p}.provider_type_id")
            ->where("{$p}.status", 'Active')
            ->where("{$pt}.status", 'Active')
            ->where("{$bp}.branch_id", $user->branch_id)
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
            ->where("{$bs}.branch_id", $user->branch_id)
            ->get();

        $parameters = BranchParameter::query()
            ->select('branch_parameter_id',
                'parameter_name',
                'parameter_type',
                'parameter_length',
                'parameter_precision',
                'parameter_value',
                'parameter_desc',
                'parameter_mask')
            ->where("branch_id", $user->branch_id)
            ->where("status", 'Active')
            ->get();
        $radius = null;
        foreach ($parameters as $k => $parameter) {
            if ($parameter->parameter_name == 'radius') {
                $radius = $parameter->parameter_value;
                unset($parameters[$k]);
            }
        }

        $zipcodes = BranchZip::query()->where('branch_id', $user->branch_id)->pluck('zipcode');

        $data = $user->toArray() +
            compact('addresses', 'phones', 'emails', 'taxes', 'providers',
                'suppliers', 'parameters', 'zipcodes', 'radius');

        return view('dashboard', compact('data'));
    }

    public function saveBranch(Request $request)
    {
        $user = $request->user();
        $branch = $user->branch;

        BranchAddress::where('branch_id', $branch->branch_id)->delete();
        BranchEmail::where('branch_id', $branch->branch_id)->delete();
        BranchPhone::where('branch_id', $branch->branch_id)->delete();
        BranchTax::where('branch_id', $branch->branch_id)->delete();
        BranchZip::query()->where('branch_id', $branch->branch_id)->delete();
        BranchProvider::where('branch_id', $branch->branch_id)->update(['status' => 'Inactive']);
        BranchSupplier::where('branch_id', $branch->branch_id)->update(['status' => 'Inactive']);

        $requestBranch = $request->get('branch');
        $branch->branch_type_id = $requestBranch['type'];
        $branch->branch_name = $requestBranch['name'];
        $branch->time_zone = $requestBranch['time_zone'];
        $branch->save();

        foreach ($request->get('addresses', []) as $data) {
            BranchAddress::create($data + ['branch_id' => $branch->branch_id]);
        }

        foreach ($request->get('phones', []) as $data) {
            BranchPhone::create($data + ['branch_id' => $branch->branch_id]);
        }

        foreach ($request->get('emails', []) as $data) {
            BranchEmail::create($data + ['branch_id' => $branch->branch_id]);
        }

        foreach ($request->get('taxes', []) as $data) {
            BranchTax::create($data + ['branch_id' => $branch->branch_id]);
        }

        foreach ($request->get('providers', []) as $providerId) {
            BranchProvider::query()->updateOrCreate([
                'branch_id' => $branch->branch_id,
                'provider_id' => $providerId
            ], [
                'branch_id' => $branch->branch_id,
                'provider_id' => $providerId,
                'status' => 'Active'
            ]);
        }

        foreach ($request->get('suppliers', []) as $supplierId) {
            BranchSupplier::query()->updateOrCreate([
                'branch_id' => $branch->branch_id,
                'supplier_id' => $supplierId
            ], [
                'branch_id' => $branch->branch_id,
                'supplier_id' => $supplierId,
                'status' => 'Active'
            ]);
        }

        foreach ($request->get('parameters', []) as $key => $value) {
            if ($value === true)
                $value = "Y";

            if($value === false)
                $value = "N";

            BranchParameter::where('branch_parameter_id', $key)
                ->update(['parameter_value' => $value]);
        }

        foreach ($request->get('zipcodes', []) as $zipcode) {
            $zip = new BranchZip;
            $zip->branch_id = $branch->branch_id;
            $zip->zipcode = $zipcode;
            $zip->save();
        }

        $radiusRecord = BranchParameter::query()
            ->where('branch_id', $branch->branch_id)
            ->where('parameter_name', 'radius')
            ->first();
        if ($radiusRecord) {
            $radiusRecord->parameter_value = (int)$request->get('radius', 0);
            $radiusRecord->status = 'Active';
            $radiusRecord->save();
        }


        return response()->json(['result' => true]);
    }

    public function providerParameters(Request $request)
    {
        $branch = $request->user()->branch;

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
            ->where("{$bp}.branch_id", $branch->branch_id)
            ->where("{$bp}.branch_provider_id", $request->branch_provider_id)
            ->where("{$bpp}.status", 'Active')
            ->get();

        return response()->json(['parameters' => $parameters]);
    }

    public function supplierParameters(Request $request)
    {
        $branch = $request->user()->branch;

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
            ->where("{$bp}.branch_id", $branch->branch_id)
            ->where("{$bp}.branch_supplier_id", $request->branch_supplier_id)
            ->where("{$bpp}.status", 'Active')
            ->get();

        return response()->json(['parameters' => $parameters]);
    }

    public function saveProviderParameters(Request $request)
    {
        $input = $request->all();
        $provider_id = $input['provider_id'];
        unset($input['provider_id']);
        BranchProvider::where('branch_provider_id', $provider_id)->update(['status' => 'Active']);
        foreach($input as $key=>$value) {
            if ($value === true) {
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

    public function saveSupplierParameters(Request $request)
    {
        $input = $request->all();
        $supplier_id = $input['supplier_id'];
        unset($input['supplier_id']);
        BranchSupplier::where('branch_supplier_id', $supplier_id)->update(['status' => 'Active']);
        foreach($input as $key=>$value) {
            if ($value === true) {
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
}
