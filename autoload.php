<?php

function mukadi_chart_js_autoloader($class) {
    
    if (substr($class, 0, 13) !== 'Mukadi\\Chart\\') {
      return;
    }

    $pos = strlen('Mukadi\\Chart\\');
    $c = substr($class, $pos);
    $c = str_replace('\\', '/', $c);
    $file = dirname(__FILE__).'/src/'.$c.'.php';
    if (is_readable($file)) {
        require_once $file;
    }
}
spl_autoload_register('mukadi_chart_js_autoloader');