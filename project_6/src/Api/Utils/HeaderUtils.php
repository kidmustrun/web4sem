<?php

declare(strict_types=1);

namespace App\Api\Utils;

class HeaderUtils
{
    public function checkLogin($login, $pw){
        if($login=='admin' && $pw=='11111')
        return true;
        else return false;
    }
}