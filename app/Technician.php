<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    //
    protected $table = 'tb_technician';
    protected $primaryKey = 'technician_id';
    public $appends = ['password_decrypt'];
    public $timestamps = false;

    protected $fillable = [
    	'technician_login',
    	'password',
        'password_encrypt',
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


    public function branch_technician()
    {
        return $this->belongsTo(BranchTechnician::class, 'technician_id', 'technician_id');
    }
}
