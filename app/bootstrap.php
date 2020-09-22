<?php

/**config Constantes Necesarias para Aplicacion*/
require_once 'config/config.php';
/**autoload las Librerías Necesarias desde ./libraries*/
spl_autoload_register(function ($className) {
    require_once 'libraries/' . $className . '.php';
});
