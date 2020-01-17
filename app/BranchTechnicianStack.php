<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BranchTechnicianStack extends Model
{
    //
    protected $table = 'tb_branch_technician_stack';
    protected $primaryKey = 'branch_technician_stack_id';
    public $timestamps = false;
    protected $fillable = [
    	'branch_technician_id',
        'stack_type',
        'branch_part_number',
        'part_manufacturer',
        'part_manufacturer_number',
        'part_in',
        'part_out',
        'price_in',
        'price_sold',
        'price_technician',
    	'note',
    	'status',
    ];


    public function branch_technician()
    {
        return $this->belongsTo(BranchTechnician::class, 'branch_technician_id', 'branch_technician_id');
    }
}
