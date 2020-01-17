<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchSupplierType extends Model
{
    //
    protected $table = 'tb_branch_supplier_type';
    public $primaryKey = 'branch_supplier_type_id';
    public $timestamps = false;

    /* public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }*/
}
