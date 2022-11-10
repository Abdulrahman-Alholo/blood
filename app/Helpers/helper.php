<?php

use App\Models\donate_schedual;

if (!function_exists("operation_fun")) {
    # code...
     function operation_fun($operation , $value)
    {
         $amounts = donate_schedual::all()->sum("amount") ;

         if ($operation == "+") {
            # code...
            $amounts = $amounts + $value;
         }else {
            $amounts = $amounts - $value;
         }
    }
}
