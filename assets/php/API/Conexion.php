<?php
class Database {

    private $host = 'db5015061601.hosting-data.io';
    private $usuario = 'dbu2560523';
    private $password = 'cuevana281204@';
    private $nombre_base_datos = 'dbs12508294';
    private $conexion;

    public function conectar(){
        $this->conexion = new mysqli($this->host, $this->usuario, $this->password, $this->nombre_base_datos);
        
        if ($this->conexion -> connect_error) {
            die ("Error en la conexion con la base de datos". $this->conexion -> connect_error);
        }
        
        return $this->conexion;

    }
    public function desconectar() {
        $this->conexion->close();
    }
}
?>