<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'tb_supplier';
    public $primaryKey = 'supplier_id';
    public $timestamps = false;

    public function type(){
        return $this->belongsTo(SupplierType::class, 'supplier_type_id');
    }

    public function branchSuppliers (){
        return $this->hasMany(BranchSupplier::class, 'supplier_id');
    }
}
