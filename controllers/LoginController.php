<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {
        $auth = new Usuario();
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                // Comprobar que el usuario exista en la BD
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario) {
                    // Verificar password
                    if ($usuario->comprobarPasswordyVerificado($auth->password)) {
                        // session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /appointment');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no existe');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            "alertas" => $alertas,
            "usuario" => $auth
        ]);
    }

    public static function logout()
    {
        echo 'desde logout';
    }

    public static function olvide(Router $router)
    {
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);

                if($usuario && $usuario->confirmado === "1"){
                    // Generar un token
                    $usuario->crearToken();
                    $usuario->guardar();
                    // Enviar correo
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    // Alerta de exito
                    Usuario::setAlerta('exito', 'Se envio instrucciones a tu correo electronico para recuperar tu cuenta');
                }else{
                    // Alerta de error
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado'); 
                }
            }
        }
        
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide', [
            "alertas" => $alertas
        ]);
    }

    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = '';

                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /');
                }else{
                    Usuario::setAlerta('error', 'Ocurrio un error, contacte con el administrador');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar', [
            "alertas" => $alertas,
            "error" => $error
        ]);
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario($_POST);
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Revisas que alertas este vacio
            if (empty($alertas)) {
                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();
                    $usuario->crearToken();

                    // Enviar el Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    // Crear el usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: /no-confirm-account');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {

        $router->render('auth/mensaje', []);
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];

        $token = $_GET['token'] ?? null;
        if (!$token) {
            header('Location: /');
        }
        $usuario = Usuario::where('token', s($token));

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no valido');
        } else {
            // Modificar a usuario confirmado
            $usuario->confirmado = 1;
            $usuario->token = '';
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }
        // Obtener alertas
        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            "alertas" => $alertas
        ]);
    }
}
