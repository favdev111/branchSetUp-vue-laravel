<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $table = 'tb_provider';
    public $primaryKey = 'provider_id';
    public $timestamps = false;

    public function type(){
        return $this->belongsTo(ProviderType::class, 'provider_type_id');
    }
    
    public function branchProviders (){
        return $this->hasMany(BranchProvider::class, 'provider_id');
    }
}
