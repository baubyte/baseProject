<?php

/**Controlador Principal
 * Se encarga de cargar las Vistas y Modelos
 */
class Controller
{

    /**Cargar los Modelos
     * @param Modelo $model
     * @return Model
     */
    public function model($model)
    {
        /**Cargamos el Modelo */
        require_once '../app/models/' . $model . '.php';
        /**Instanciamos el Modelo */
        return new $model();
    }

    /**Cargar las Vistas
     * @param Vista $view
     * @param Datos array $data
     */
    public function view($view, $data = [])
    {
        /**Verificamos si el Archivo existe */
        if (file_exists('../app/views/' . $view . '.php')) {
            /**Si ecxistes Cargamos la Vista */
            require_once '../app/views/' . $view . '.php';
        }else {
            die('La Vista que Intenta Acceder no Existe.');
        }
    }
}
