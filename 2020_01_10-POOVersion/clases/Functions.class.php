<?php
    class Functions
    {
        public static function isWellTypedDomain($domain)
        {
            return ($domain[strlen($domain)-1] != "/") ? false:true;
        }
    }
 ?>
