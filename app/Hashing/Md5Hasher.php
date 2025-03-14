<?php
// filepath: /C:/laragon/www/oauthssbb/app/Hashing/Md5Hasher.php
namespace App\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class Md5Hasher implements HasherContract
{
    public function make($value, array $options = [])
    {
        return md5($value);
    }

    public function check($value, $hashedValue, array $options = [])
    {
        return md5($value) === $hashedValue;
    }

    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }
    
    function info($hashedValue)
    {
        return password_get_info($hashedValue);
    }
}