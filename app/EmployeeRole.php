<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRole extends Model
{
    //
    protected $table = 'tb_employee_role';
    protected $primaryKey = 'employee_role_id';
    public $timestamps = false;
    protected $fillable = [
    	'role_id',
    	'employee_id',
        'status'
    ];



    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

}
