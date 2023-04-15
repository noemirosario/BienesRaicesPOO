<?php
namespace App;

class Propiedad {

    protected static $db;
    protected static $columnasDB = 
    [
        'idPropiedad',
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'wc',
        'habitaciones',
        'estacionamiento',
        'creado',
        'idVendedor',
    ];

    //errores
    protected static $errores = [];


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
        // sanitizar datos
        $atributos = $this->sanitizarDatos();
        
        // sirve par unir los valores de key y values del array
        // $string = join(', ', array_values($atributos) ) ;

        // insertar en la base de datos
        $columnas = join(', ',array_keys($atributos));
        $fila = join("', '",array_values($atributos));
        // debug($columnas);
        // debug($fila);
        
        //*  Consulta para insertar datos
        $query = "INSERT INTO propiedades($columnas) VALUES ('$fila')";
        // debuguear($query);

        // debug($query);

        $resultado = self::$db->query($query);

        return $resultado;
    }

    //definir coneciuon a bd

    public static function setDB($database){
        self::$db = $database;
    }

    //iterar
    public function atributos(){
        $atributos = [];
        foreach (self::$columnasDB as $columna ) {
            if ($columna === 'idPropiedad') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }


    public function sanitizarDatos(){
        $atributos = $this->atributos();
        $sanitizado = [];
        
        foreach ($atributos as $key => $value) {
            // escape_string sirve para sanitizar en la forma POO
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // subida de archivos
    public function setImagen($imagen){
        // asignar el atributo de imagen el nombre de la img
        if ($imagen){
            $this->imagen = $imagen;
        }
    }

    //validacion

    public static function getErrores(){
        return self::$errores;
    }

    public function validar(){
        if (!$this->nombre){
            self::$errores[] = "Debes añadir un titulo";
        }
        if (!$this->precio){
            self::$errores[] = "precio obligatorio";
        }
        if ( strlen($this->descripcion) < 50){
            self::$errores[] = "la descripcion debe de ser de 50 caracteres";
        }
        if (!$this->habitaciones){
            self::$errores[] = "numero de habitaciones obligatorio";
        }
        if (!$this->wc){
            self::$errores[] = "numero de wc obligatorio";
        }
        if (!$this->estacionamiento){
            self:: $errores[] = "numero de estacionamiento obligatorio";
        }
        if (!$this->idVendedor){
            self::$errores[] = "vendedor obligatorio";
        }

        if (!$this->imagen['name']){
            self::$errores[] = 'La imagen es obligatoria';
        }

        return self::$errores;
    }

    // lo que este como Public se hace referencias con $this-> no hay signo de $;
    // lo que este como static se hace referencias con self, si hay $

}