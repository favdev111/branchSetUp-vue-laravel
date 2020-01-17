<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchDefaultParameter extends Model
{
    //
    protected $table = 'tb_branch_default_parameter';
    public $primaryKey = 'branch_default_parameter_id';
    public $timestamps = false;

    /* public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }*/
}
