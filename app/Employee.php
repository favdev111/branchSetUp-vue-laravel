<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $table = 'tb_employee';
    protected $primaryKey = 'employee_id';
    public $appends = ['password_decrypt'];
    public $timestamps = false;
    protected $fillable = [
    	'employee_login',
    	'first_name',
    	'middle_name',
    	'last_name',
    	'status',
    ];

    protected $hidden = [
        'password', 
        'password_encrypt',
    ];


    public function setPasswordEncryptAttribute($value)
    {
        $this->attributes['password_encrypt'] = self::encryptPassword($value);
    }


    protected static function encryptPassword($password) 
    {
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
        $crypted_password = openssl_encrypt($password, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);

        return $crypted_password;
    }

    public function getPasswordDecryptAttribute()
    {
        $decryption = '';
        if ($this->attributes['password_encrypt'])
        {

            list($this->attributes['password_encrypt'], $enc_iv) = explode("::", $this->attributes['password_encrypt']);;
            $cipher_method = 'aes-128-ctr';
            $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
            $decryption = openssl_decrypt($this->attributes['password_encrypt'], $cipher_method, $enc_key, 0, hex2bin($enc_iv));
            unset($crypted_token, $cipher_method, $enc_key, $enc_iv);
        }
        return $decryption;
    }


    public function branch_employee()
    {
        return $this->belongsTo(BranchEmployee::class, 'employee_id', 'employee_id');
    }

    public function roles()
    {
        return $this->hasMany(EmployeeRole::class, 'employee_id', 'employee_id');
    }
}
