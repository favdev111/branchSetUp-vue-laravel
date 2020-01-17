<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BranchTechnician extends Model
{
    //
    protected $table = 'tb_branch_technician';
    protected $primaryKey = 'branch_technician_id';
    public $timestamps = false;
    protected $fillable = [
    	'branch_id',
    	'technician_id',
    	'status',
    ];


    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id', 'technician_id');
    }


    public function branch_technician_parameters()
    {
        return $this->hasMany(BranchTechnicianParameter::class, 'branch_technician_id', 'branch_technician_id')->orderBy('branch_technician_id', 'DESC');
    }


    public function branch_technician_zips()
    {
        return $this->hasMany(BranchTechnicianZip::class, 'branch_technician_id', 'branch_technician_id')->orderBy('branch_technician_id', 'DESC');
    }


    public function technician_branch_providers()
    {
        return $this->hasMany(TechnicianBranchProvider::class, 'branch_technician_id', 'branch_technician_id')->orderBy('branch_technician_id', 'DESC');
    }


    public function branch_technician_stacks()
    {
        return $this->hasMany(BranchTechnicianStack::class, 'branch_technician_id', 'branch_technician_id')->orderBy('branch_technician_id', 'DESC');
    }
    
}
