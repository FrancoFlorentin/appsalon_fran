<?php 

namespace Model;

class Usuario extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    // Mensajes de validación para la creación de una cuneta
    public function validarNuevaCuenta() {
        if (!$this->nombre) {
            static::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if (!$this->apellido) {
            static::$alertas['error'][] = 'El apellido es obligatorio';
        }

        if (!$this->email) {
            static::$alertas['error'][] = 'El email es obligatorio';
        }

        if (!$this->password) {
            static::$alertas['error'][] = 'El password es obligatorio';
        }

        if (strlen($this->password) < 6) {
            static::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';     
        }

        return static::$alertas;
    }

    // Validar login
    public function validarLogin() {
        if (!$this->email) {
            static::$alertas['error'][] = 'El email es obligatorio';
        }

        if (!$this->password) {
            static::$alertas['error'][] = 'El password es obligatorio';
        }

        return static::$alertas;
    }

    // Validar el email para la recuperacion de la contraseña
    public function validarEmail() {
        if (!$this->email) {
            static::$alertas['error'][] = 'El email es obligatorio';
        }
        return static::$alertas;
    }

    // Validar password para reestablecer 
    public function validarPassword () {
        if (!$this->password) {
            static::$alertas['error'][] = 'El password es obligatorio';
        }

        if (strlen($this->password) < 6) {
            static::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';     
        }

        return static::$alertas;
    }

    // Revisa si el usuario ya existe
    public function existeUsuario() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query) ?? null;
        
        if ($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya está registrado';
        }

        return $resultado;
    }

    // Funcion para hashear el password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Crear el token
    public function crearToken() {
        $this->token = uniqid(); 
    }

    // Verificar si el usuario está confirmado o no
    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->password);

        if (!$resultado || !$this->confirmado) {
            static::$alertas['error'][] = 'Password incorrecto o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }        
    }

    
    
}