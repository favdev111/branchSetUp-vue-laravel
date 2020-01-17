<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupplierType extends Model
{
    protected $table = 'tb_supplier_type';
    public $primaryKey = 'supplier_id';
    public $timestamps = false;

//    public function providers(){
//        return $this->hasMany(Provider::class, '');
//    }
}
