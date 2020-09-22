<?php

/**Clase que nos Permite a conectar a la Base de datos */
class Database
{
    private $dbHost = DB_HOST;
    private $dbDatabase = DB_DATABASE;
    private $dbUserName = DB_USERNAME;
    private $dbPassword = DB_PASSWORD;

    private $dbh;
    private $stmt;
    private $error;
    /**Constructor */
    public function __construct()
    {
        /**Configuramos la Conexion */
        $dsn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbDatabase;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        /**Creamos la Instancia de PDO */
        try {
            $this->dbh = new PDO($dsn, $this->dbUserName, $this->dbPassword, $options);
            $this->dbh->exec('set names utf8');
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
    /**Preparamos la Consulta
     *@param Una query $sql
     */
    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }
    /**Vinculamos la Consulta con bind
     * @param Parametro $parameter
     * @param Valor $value
     * @param Tipo $type
     */
    public function bind($parameter, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }
        $this->stmt->bindValue($parameter, $value, $type);
    }
    /**Ejecuta la Consulta
     * @return stmt execute
     */
    public function execute()
    {
        return $this->stmt->execute();
    }
    /**Obtener los Registros
     * @return Multiples Registros
     */
    public function getAll()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /**Obtener Registro
     * @return Un Registro
     */
    public function getOne()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    /**Obtener la Cantidad de Registros
     * @return Rows
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
