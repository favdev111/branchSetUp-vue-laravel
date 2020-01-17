<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchTax extends Model
{
    //
    protected $table = 'tb_branch_tax';
    protected $primaryKey = 'branch_tax_id';
    public $timestamps = false;

    protected $fillable = ['tax_type', 'tax_percent', 'branch_id'];

}
