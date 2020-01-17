<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BranchTechnicianZip extends Model
{
    //
    protected $table = 'tb_branch_technician_zip';
    protected $primaryKey = 'technician_zip_id';
    public $timestamps = false;
    protected $fillable = [
    	'branch_technician_id',
    	'zipcode',
    	'status',
    ];


    public function branch_technician()
    {
        return $this->belongsTo(BranchTechnician::class, 'branch_technician_id', 'branch_technician_id');
    }
}
