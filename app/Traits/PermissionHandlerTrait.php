<?php

namespace App\Traits;

trait PermissionHandlerTrait
{
    public function validatePermission($permissionName , $payload){
        if(in_array($permissionName , $payload)){
            return true;
        } else {
            return false;
            // return response()->json(['error' => 'unauthorized process'], 401);

        }
    }
}
