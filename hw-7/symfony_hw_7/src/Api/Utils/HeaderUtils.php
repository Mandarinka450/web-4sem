<?php

declare(strict_types=1);

namespace App\Api\Utils;

class HeaderUtils
{
    public function checkUser($login, $pw){
        if($login=='admin' && $pw=='111111')
        return true;
        else return false;
    }
}
