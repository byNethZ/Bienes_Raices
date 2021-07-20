<?php

namespace App;

class Vendedor extends ActiveRecord{

    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono', 'imagen', 'email'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $imagen;
    public $email;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
    }

    public function validar(){
        if(!$this->nombre){
            self::$errores[]= 'El nombre es obligatorio';
        }

        if(!$this->apellido){
            self::$errores[]= 'El apellido es obligatorio';
        }

        if(!$this->telefono){
            self::$errores[]= 'El telefono es obligatorio';
        }

        if(!$this->email){
            self::$errores[]= 'El email es obligatorio';
        }

        if(!$this->imagen){
            self::$errores[]= 'Agregue una foto de imagen';
        }

        if(!preg_match('/[0-9]{10}/', $this->telefono)){
            self::$errores[]= 'Formato no valido';
        }

        return self::$errores;
    }

}