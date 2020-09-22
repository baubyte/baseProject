<?php

/**Mapeamos la URL ingresada
 * 1 - Controlador
 * 2 - Método
 * 3 - Parámetros 
 * /article/update/1
 */
class Core
{
    protected $defaultController = 'page';
    protected $defaultMethod = 'index';
    protected $parameters = [];

    /**Constructor */
    public function __construct()
    {
        $url = $this->getUrl();
        /**Buscamos en controllers si es que el controlador existe */
        if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            /**Si existe se sestea como el controlador por defecto */
            $this->defaultController = ucwords($url[0]);
            /**Eliminamos el elemento del indice 0 */
            unset($url[0]);
        }

        /**Requerimos el controlador */
        require_once '../app/controllers/' . $this->defaultController . '.php';
        $this->defaultController = new $this->defaultController;
        /**Si se seteo el Método desde la url */
        if (isset($url[1])) {
            /**Verificamos el segundo elemento de la url que seria el método */
            if (method_exists($this->defaultController, $url[1])) {
                /**Setetamos el Método */
                $this->defaultMethod = $url[1];
                /**Eliminamos el elemento del indice 1 */
                unset($url[1]);
            }
        }
        /**Obtener los Parámetros */
        $this->parameters = $url ? array_values($url) : [];
        /**Llamar callback parámetros del array */
        call_user_func_array([$this->defaultController, $this->defaultMethod], $this->parameters);
    }

    public function getUrl()
    {
        /**Si la URL esta seteada */
        if (isset($_GET['url'])) {
            /**Limpiamos los espacios */
            $url = rtrim($_GET['url'], '/');
            /**Filtro de URL y limpiamos */
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            /**Retornamos las URL */
            return $url;
        }
    }
}
