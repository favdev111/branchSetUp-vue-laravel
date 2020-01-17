<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchProviderType extends Model
{
    //
    protected $table = 'tb_branch_provider_type';
    public $primaryKey = 'branch_provider_type_id';
    public $timestamps = false;

    /* public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }*/
}
