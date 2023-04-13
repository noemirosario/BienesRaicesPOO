<?php
namespace App;

class Propiedad {

    protected static $db;

    public  $idPropiedad;
    public  $nombre;
    public  $descripcion;
    public  $precio;
    public  $imagen;
    public  $wc;
    public  $habitaciones;
    public  $estacionamiento;
    public  $creado;
    public  $idVendedor;

    public function __construct($args = [])
    {
        // $this->idPropiedad = $args['idPropiedad'] ?? '';
        $this->nombre = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->idVendedor = $args['idVendedor'] ?? '';
    }

    public function guardar(){
    // insertar en la base de datos
    $query = " INSERT INTO propiedades (nombre, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, idVendedor) VALUES 
        ( 
            '$this->nombre', 
            '$this->precio',
            '$this->imagen',
            '$this->descripcion',
            '$this->habitaciones',
            '$this->wc',
            '$this->estacionamiento',
            '$this->creado',
            '$this->idVendedor'
        )";    

        $resultado = self::$db->query($query);

        debug($resultado);
    }

    //definir coneciuon a bd

    public static function setDB($database){
        self::$db = $database;
    }

    // lo que este como Public se hace referencias con $this-> no hay signo de $;
    // lo que este como static se hace referencias con self, si hay $

}