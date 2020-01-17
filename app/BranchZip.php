<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchZip extends Model
{
    protected $table = 'tb_branch_zip';
    protected $primaryKey = 'branch_zip_id';
    public $timestamps = false;
}
