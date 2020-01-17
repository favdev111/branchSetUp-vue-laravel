<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * Class BranchSupplier
 * @package App
 * @mixin Builder
 */
class BranchSupplier extends Model
{
    //
    protected $table = 'tb_branch_supplier';
    public $primaryKey = 'branch_supplier_id';
    public $timestamps = false;

    protected $fillable = ['branch_id', 'supplier_id', 'status'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    
    public function parameters()
    {
        return $this->hasMany(BranchSupplierParameter::class, 'branch_supplier_id');
    }
}
