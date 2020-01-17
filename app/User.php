<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_user';
    protected $primaryKey = 'user_id';

    public $timestamps = false;



    protected $fillable = [
        'user_email', 'password', 'branch_name', 'branch_type_id'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id')->with('type')->with('taxes');
    }

    public function branchType()
    {
        return $this->belongsTo(BranchType::class, 'branch_type_id');
    }

    public function getEmailAttribute()
    {
        return $this->attributes['user_email'];
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['user_email'] = $value;
    }
}
