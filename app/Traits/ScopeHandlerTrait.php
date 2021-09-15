<?php

namespace App\Traits;

trait ScopeHandlerTrait
{
    public function validateScope($scopeName , $payload){
        if(in_array($scopeName , $payload)){
            return true;
        } else {
            return false;
            // return response()->json(['error' => 'unauthorized process'], 401);

        }
    }
}
