<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchProvider extends Model
{
    //
    protected $table = 'tb_branch_provider';
    public $primaryKey = 'branch_provider_id';
    public $timestamps = false;

    protected $fillable = ['branch_id', 'provider_id', 'status'];

    public function provider()
    {
        return $this->belongsTo(Provider::class, 'provider_id', 'provider_id');
    }
}
