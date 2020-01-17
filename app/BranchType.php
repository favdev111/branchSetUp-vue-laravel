<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchType extends Model
{

    const STATUS_ACTIVE = 'active';

    //
    protected $table = 'tb_branch_type';
    protected $primaryKey = 'branch_type_id';


    public function roles()
    {
        return $this->hasMany(Role::class, 'branch_type_id', 'branch_type_id');
    }
}
