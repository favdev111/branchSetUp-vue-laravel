<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchAddress extends Model
{
    //
    protected $table = 'tb_branch_address';
    public $primaryKey = 'branch_address_id';
    public $timestamps = false;

    protected $fillable = ['branch_id', 'address_type', 'address', 'address2', 'city', 'county', 'zipcode', 'status', 'state'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

}
