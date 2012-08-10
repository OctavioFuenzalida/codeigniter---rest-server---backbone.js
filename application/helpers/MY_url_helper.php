<?php

// ------------------------------------------------------------------------

if (!function_exists('base_modules')) {

    function base_modules($modules = NULL) {
        $CI = & get_instance();
        return $CI->config->base_modules($modules);
    }

}
?>
