<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkOrderController extends Controller
{
    public function save(Request $request)
    {
        $data = $request->json();
        $workOrders = [];
        try {
            foreach ($data->all() as $workOrder) {
                $customerNames = explode(' ', $workOrder['customer']);
                $createdAppliances = [];
                $createdWorkOrder = DB::select("CALL sp_work_order_create(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                    $workOrder['company'],
                    $workOrder['external_work_order_number'] ?? null,
                    $workOrder['authorization_number'] ?? null,
                    $workOrder['policy'] ?? null,
                    $customerNames[0] ?? null,
                    $customerNames[1] ?? null,
                    $customerNames[2] ?? null,
                    $workOrder['address_note'] ?? null,
                    $workOrder['apt'] ?? null,
                    $workOrder['city'],
                    $workOrder['country'],
                    $workOrder['state'],
                    $workOrder['zip_city'],
                    $workOrder['phone_info'][2]['value'] ?? null,
                    $workOrder['phone_info'][0]['value'] ?? null,
                    $workOrder['phone_info'][1]['value'] ?? null,
                    $workOrder['purchase_date'],
                    $workOrder['call_received'],
                    $workOrder['repaired_date'],
                    $workOrder['complete_by_date'] ?? null,
                    $workOrder['note'] ?? null,
                    $workOrder['employee'] ?? null
                ]);

                $workOrderId = \reset($createdWorkOrder)->result;

                foreach ($workOrder['appliances'] as $appliance) {
                    $problems = [];
                    foreach ($appliance['problems'] as $problem) {
                        $problems[] = $problem['value'];
                    }
                    $createdAppliance = DB::select("CALL sp_work_order_appliance_create(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                        $workOrderId,
                        $appliance['dealer'] ?? null,
                        $appliance['appliance'] ?? null,
                        $appliance['store'] ?? null,
                        $appliance['location'] ?? null,
                        $appliance['style'] ?? null,
                        $appliance['power'] ?? null,
                        $appliance['model'] ?? null,
                        $appliance['serial'] ?? null,
                        implode(', ', $problems),
                        $appliance['service_performed'] ?? null,
                        $appliance['labor'] ?? null,
                        $appliance['note'] ?? null,
                        $workOrder['employee']
                    ]);
                    $createdAppliances[] = \reset($createdAppliance)->result;
                }

                $workOrders[] = $workOrderId;
            }
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => 'Could not create work order: ' . $e->getMessage()], 200);
        }

        return new JsonResponse(['success' => 'Work order created check following id:' . implode(', ', $workOrders)], 200);
    }

    private function getProviders($branchIds)
    {

        $sqlProviders =
            'select
	                bp.branch_provider_id as branch_provider_id,
                    p.provider_name as provider_name,
                    pt.provider_type as provider_type
                from
	                tb_branch_provider bp
                join tb_provider p on
	                p.provider_id = bp.provider_id
	                and p.status = \'Active\'
                join tb_provider_type pt on
	                pt.provider_type_id = p.provider_type_id
	                and pt.status = \'Active\'
                where
	                bp.branch_id IN (' . $branchIds . ')
	                and bp.status = \'Active\'
                order by
	                pt.provider_type,
	                p.provider_name,
	                bp.branch_provider_id;'
        ;

        $resultsProviders = DB::select($sqlProviders);
        foreach ($resultsProviders as $key => $value) {
            $providers[$value->branch_provider_id] = $value->provider_name;
        }

        return $providers;
    }

    private function getLocations($branchIds) {

        $sqlLocations =
            'select
                t.appliance_location_id,
                t.appliance_location_name,
                t.note
            from
                tb_appliance_location t
            join tb_branch b on
                b.branch_type_id = t.branch_type_id
                and t.status = \'Active\'
            where
	            b.branch_id IN (' . $branchIds . ')'
            ;

        $resultsLocations = DB::select($sqlLocations);
        foreach ($resultsLocations as $key => $value) {
            $locations[$value->appliance_location_id] = $value->appliance_location_name;
        }

        return $locations;
    }

    private function getTypes($branchIds) {

        $sqlTypes =
            'select
            	t.branch_type_appliance_type_id,
	            t.appliance_type,
	            t.note
            from
	            tb_branch_type_appliance_type t
            join tb_branch b on
	            b.branch_type_id = t.branch_type_id
	            and t.status = \'Active\'
            where
	            b.branch_id IN (' . $branchIds . ')'
        ;

        $resultsTypes = DB::select($sqlTypes);
        foreach ($resultsTypes as $key => $value) {
            $types[$value->branch_type_appliance_type_id] = $value->appliance_type;
        }

        return $types;
    }

    private function getStyles($branchIds) {

        $sqlStyles =
            'select
	            t.appliance_style_id,
	            t.appliance_style_name,
	            t.note
            from
	            tb_appliance_style t
            join tb_branch b on
	            b.branch_type_id = t.branch_type_id
	            and t.status = \'Active\'
            where
	            b.branch_id IN (' . $branchIds . ')'
        ;

        $resultsStyles = DB::select($sqlStyles);
        foreach ($resultsStyles as $key => $value) {
            $styles[$value->appliance_style_id] = $value->appliance_style_name;
        }

        return $styles;
    }

    private function getPowers($branchIds)
    {
        $powers = [];

        $sqlPowers =
            'select
	            t.appliance_power_id,
	            t.appliance_power_name,
	            t.note
            from
                tb_appliance_power t
                join tb_branch b on
	            b.branch_type_id = t.branch_type_id
	            and t.status = \'Active\'
            where
	            b.branch_id IN (' . $branchIds . ')'
        ;

        $resultsStyles = DB::select($sqlPowers);
        foreach ($resultsStyles as $key => $value) {
            $powers[$value->appliance_power_id] = $value->appliance_power_name;
        }

        return $powers;
    }

    private function getDealers($branchIds)
    {

        $dealers = [];

        $sqlDealers =
            'select
	            t.branch_type_manufacturer_id,
	            t.manufacturer_name,
	            t.note
            from
	            tb_branch_type_manufacturer t
            join tb_branch b on
	            b.branch_type_id = t.branch_type_id
	            and t.status = \'Active\'
            where
	            b.branch_id IN (' . $branchIds . ')'
        ;

        $resultsDealers = DB::select($sqlDealers);
        foreach ($resultsDealers as $key => $value) {
            $dealers[$value->branch_type_manufacturer_id] = $value->manufacturer_name;
        }

        return $dealers;
    }

    private function getStores($branchIds)
    {

        $stores = [];

        $sqlStores =
            'select
	            t.store_id,
	            t.store_name,
	            t.note
            from
	            tb_store t
            join tb_branch b on
	            b.branch_type_id = t.branch_type_id
	            and t.status = \'Active\'
            where
	            b.branch_id IN (' . $branchIds . ')'
        ;

        $resultsStores = DB::select($sqlStores);
        foreach ($resultsStores as $key => $value) {
            $stores[$value->store_id] = $value->store_name;
        }

        return $stores;
    }

    public function getApplianceData(Request $request)
    {
        $branchIds = [];
        $results = [];

        $employeeId = $request->request->get('employee_id');

            if ($employeeId) {
                $branches = $this->getBranchByEmployeeId($employeeId);
                foreach ($branches as $branch) {
                    $branchIds[] = $branch->branch_id;
                }

            $branchIds = implode(',', array_values($branchIds));

            if ($branchIds) {
                $providers = $this->getProviders($branchIds);
                $locations = $this->getLocations($branchIds);
                $types = $this->getTypes($branchIds);
                $styles = $this->getStyles($branchIds);
                $powers = $this->getPowers($branchIds);
                $dealers = $this->getDealers($branchIds);
                $stores = $this->getStores($branchIds);

                $results = array(
                  "providers" => $providers,
                  "locations" => $locations,
                  "types" => $types,
                  "styles" => $styles,
                  "powers" => $powers,
                  "dealers" => $dealers,
                  "stores" => $stores
                );
            }
        }

        return $results;
    }

    public function getEmployees(Request $request)
    {
        $sql =
            'select 
                emp.employee_id,
                emp.first_name,
                emp.last_name,
                emp.middle_name
                from
	                tb_employee emp
                where
	                emp.status = \'Active\'
	                or emp.status = \'Approved\'
                order by
                emp.first_name asc;'
        ;

        $results = DB::select($sql);
        $employees = [];
        foreach ($results as $key => $value) {
            $employees[$value->employee_id] = $value->first_name .' ' . $value->middle_name  .' '. $value->last_name;
        }

        return $employees;
    }

    public function getWorkOrdersList(Request $request)
    {
        $workOrders = [];
        $employee = null;
        $branch = null;
        $employeeId = $request->request->get('employeeId');
        $branchId = $request->request->get('branchId');

        if ($employeeId && $branchId) {

            $workOrdersSql = DB::select("CALL sp_employee_get_work_orders(?, ?)", [
                $employeeId,
                $branchId
            ]);

            foreach ($workOrdersSql as $key => $value) {
                $appliances = DB::select("CALL sp_work_order_appliance_list_get(?, ?)", [
                    $value->work_order_id,
                    $employeeId
                ]);

                foreach ($appliances as $applianceKey => $applianceValue) {
                    $workOrders[$applianceValue->work_order_appliance_id] = [
                        'address' => $value->address ?? null,
                        'workOrderId' => $value->work_order_id,
                        'workOrderApplianceId' => $applianceValue->work_order_appliance_id,
                        'company' => $value->provider_name,
                        'scheduleButton' => $value->appliance ?? null,
                        'appliance' => $applianceValue->appliance_type ?? null
                    ];
                }
            }
        }

        return $workOrders;
    }

    public function getBranchesByEmployeeId(Request $request)
    {
        $employeeId = $request->request->get('employeeId');
        $branches = [];
        $branchList = [];

        if ($employeeId) {
            $branches = $this->getBranchByEmployeeId($employeeId);
            foreach ($branches as $branch) {
                $branchIds[] = $branch->branch_id;
            }

            $branchIds = implode(',', array_values($branchIds));

            if ($branchIds) {
                $sql =
                    'select
	                b.branch_id as branch_id,
                    b.branch_name as branch_name
                from
	                tb_branch b
                where
	                b.branch_id IN (' . $branchIds . ')
	                and (b.status = \'Active\' or b.status = \'Created\')
                order by
	                b.branch_name;'
                ;

                $results = DB::select($sql);
                foreach ($results as $key => $value) {
                    $branchList[$value->branch_id] = $value->branch_name;
                }
            }
        }

        return $branchList;
    }

    private function getBranchByEmployeeId(int $employeeId) {
        $branchesSql =
            'select 
                be.branch_id
                from
	                tb_branch_employee be
                where
	                 be.employee_id =' . $employeeId  ;

        $branches = DB::select($branchesSql);

        return $branches;
    }
}
