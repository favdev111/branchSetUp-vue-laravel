<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchTechnicianParameter extends Model
{
    //
    protected $table = 'tb_branch_technician_parameter';
    protected $primaryKey = 'branch_technician_parameter_id';
    public $timestamps = false;
    protected $fillable = [
        'branch_technician_id',
    	'parameter_name',
    	'parameter_grouping',
    	'parameter_order',
    	'parameter_type',
    	'parameter_length',
    	'parameter_precision',
    	'parameter_value',
        'parameter_desc',
    	'parameter_mask',
    	'status',
    ];

    public function getParameterValueAttribute($value)
    {
        if ($this->attributes['parameter_type'] == 'CHECK') return $value == 'Y' ? true : false;

        return $value;
    }


    public function setParameterValueAttribute($value)
    {
        if ($this->attributes['parameter_value'] == 'CHECK') :
            $this->attributes['parameter_value'] = $value ? 'Y' : 'N';
        else :
            $this->attributes['parameter_value'] = $value;
        endif;
    }
}
