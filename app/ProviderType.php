<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProviderType extends Model
{
    protected $table = 'tb_provider_type';
    public $primaryKey = 'provider_id';
    public $timestamps = false;

//    public function providers(){
//        return $this->hasMany(Provider::class, '');
//    }
}
