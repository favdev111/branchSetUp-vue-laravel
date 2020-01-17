<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicianBranchProvider extends Model
{
    //
    protected $table = 'tb_technician_branch_provider';
    protected $primaryKey = 'tb_technician_branch_provider_id';
    public $timestamps = false;
    
    protected $fillable = [
        'branch_provider_id',
        'branch_technician_id',
        'status'
    ];



    public function branch_technician()
    {
        return $this->belongsTo(BranchTechnician::class, 'branch_technician_id', 'branch_technician_id');
    }

    public function branch_provider()
    {
        return $this->belongsTo(BranchProvider::class, 'branch_provider_id', 'branch_provider_id');
    }
}
