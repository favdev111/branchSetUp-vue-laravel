<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchPhone extends Model
{
    //
    protected $table = 'tb_branch_phone';
    public $primaryKey = 'branch_phone_id';
    public $timestamps = false;

    protected $fillable = ['phone_type', 'phone', 'branch_id'];

}
