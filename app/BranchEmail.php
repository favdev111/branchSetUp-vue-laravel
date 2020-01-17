<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchEmail extends Model
{
    //
    protected $table = 'tb_branch_email';
    public $primaryKey = 'branch_email_id';
    public $timestamps = false;

    protected $fillable = ['email_type', 'email', 'branch_id'];

}
