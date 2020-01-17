<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BranchEmployee extends Model
{
    //
    protected $table = 'tb_branch_employee';
    protected $primaryKey = 'branch_employee_id';
    public $timestamps = false;
    protected $fillable = [
    	'branch_id',
    	'employee_id',
    	'status',
    ];


    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

      public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'employee_id');
    }

    
    public function branch_employee_parameters()
    {
        return $this->hasMany(BranchEmployeeParameter::class, 'branch_employee_id', 'branch_employee_id')->orderBy('branch_employee_id', 'DESC');
    }
}
