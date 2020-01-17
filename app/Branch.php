<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    protected $table = 'tb_branch';
    public $primaryKey = 'branch_id';
    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo(BranchType::class, 'branch_type_id');
    }
    public function addresses()
    {
        return $this->hasMany(BranchAddress::class, 'branch_address_id');
    }

    public function emails()
    {
        return $this->hasMany(BranchEmail::class, 'branch_id');
    }
    public function providers()
    {
        return $this->hasMany(BranchProvider::class, 'branch_id');
    }
    public function taxes()
    {
        return $this->hasMany(BranchTax::class, 'branch_id');
    }

    public function delete()
    {
        $this->addresses()->delete();
        $this->emails()->delete();
        $this->providers()->delete();
        $this->taxes()->delete();
        
        return parent::delete();
    }

}
