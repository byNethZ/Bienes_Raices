<?php

namespace App;

class ActiveRecord {

    //Base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

    //Validacion

    protected static $errores = [];



    //Definiendo la conexión a la DB
    public static function setDB($database){
        self::$db = $database;
    }



    public function guardar(){
        if(!is_null($this->id)){
            //Actualizando
            $this->actualizar();
        }else{
            //Creando nuevo
            $this->crear();
        }
    }

    public function crear(){
        //Sanitizar los datos

        $atributos = $this->sanitizarDatos();

        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query.= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        
        $resultado = self::$db->query($query);

        if($resultado){
            //Redireccionar al usuario
            header('Location: /admin?resultado=1');
        }

        // debug($query);

    }

    public function actualizar(){
        //Sanitizar datos
        $atributos = $this->sanitizarDatos();
        $valores =[];
        foreach($atributos as $key => $value){
            $valores[]= "{$key} = '{$value}'";
        }
        $query = "UPDATE " . static::$tabla . " SET ";
        $query.= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";
        
        $resultado = self::$db->query($query);
        
        if($resultado){
            //Redireccionar al usuario
            header('Location: /admin?resultado=2');
        }
    }

    public  function eliminar($opcion){

        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($opcion == 1){
            if($resultado){
                $this->borrarImagen();
                //Redireccionar al usuario
                header('Location: /admin?resultado=3');
            }
        } else if($opcion == 2){
            if($resultado){
                $this->borrarPerfil();
                //Redireccionar al usuario
                header('Location: /admin?resultado=3');
            }
        }

    }

    //Identificar y unir los datos en memorio con los espacios en DB
    public function atributos(){
        $atributos = [];
        foreach(static::$columnasDB as $columna){
            if ($columna==='id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarDatos(){
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key=> $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    //Subida de archivos
    public function setImagen($imagen){
        //elimina la imagen previa
        if(!is_null($this->id)){
            //Comprobar si existe archivo
            $this->borrarImagen();
        }

        if($imagen){
            $this->imagen = $imagen;
        }
    }

    //Eliminar archivo
    public function borrarImagen(){
        //Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo){
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //Eliminar archivo
    public function borrarPerfil(){
        //Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_PERFILES . $this->imagen);
        if ($existeArchivo){
            unlink(CARPETA_PERFILES . $this->imagen);
        }
    }

    //Validacion

    public static function getErrores(){
        return static::$errores;
    }

    public function validar(){
        static::$errores=[];
        return static::$errores;
    }

    //Lista todas el registro de las tablas"

    public static function all(){
        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    //Obtiene el terminado de numero de registros
    public static function get($cantidad){
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    //busca objeto por id
    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    public static function consultarSQL($query){
        //Consultar base de datos
        $resultado = self::$db->query($query);

        //Iterar resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        }

        //Liberar la memoria
        $resultado->free();

        //Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new static;

        foreach($registro as $key => $value){
            if (property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //sincroniza datos que ingresa el usuario con el servidor
    public function sincronizar($args = []){
        foreach($args as $key => $value){
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    }

}
