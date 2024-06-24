<?php
require_once './models/Usuario.php';
require_once './seguridad/AutentificadorJWT.php';
require_once './pdf/fpdf.php';

class UsuarioController extends Usuario
{
    public function CargarUno($request,$response,$args)
    {
        $parametros = $request->getParsedBody();
        $nombre     = $parametros['nombre'];
        $apellido   = $parametros['apellido'];
        $mail       = $parametros['mail'];
        $rol        = $parametros['rol'];
        $usr = new Usuario();
        
        $usr->nombre = $nombre;
        $usr->apellido = $apellido;
        $usr->mail = $mail;
        $usr->rol = $rol;
        $usr->crearUsuario();
        $payload = json_encode(array("mensaje" => "Usuario creado exitosamente"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function Login($request,$response,$args)
    {
        $parametros = $request->getParsedBody();
        $nombre     = $parametros['nombre'];
        $apellido   = $parametros['apellido'];
        $usuario = Usuario::obtenerUsuario($nombre,$apellido);
        if(isset($usuario))
        {
            $datos = array('usuario' => $usuario);
            $token = AutentificadorJWT::CrearToken($datos);
            $payload = json_encode(array('jwt' => $token));

        }
        else
        {
            $payload = json_encode(array("mensaje" => "No se encontró el usuario"));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function cargarTablaDesdeCSV($request,$response,$args)
    {
        $uno = new Usuario();
        $uno->cargarTablasDesdeCSV();

        $payload = json_encode(array("mensaje" => "Tabla Usuario cargada exitosamente"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function cargarCSVdesdeTabla($request,$response,$args)
    {
        $lista = Usuario::obtenerTodos(); // Obtén los datos de la base de datos
        $csvContent = "id_usuario,nombre,apellido,mail,rol,activo\n"; // Encabezado CSV
        foreach ($lista as $usuario) 
        {
            $csvContent .= $usuario->id_usuario.",".$usuario->nombre.",".$usuario->apellido.",".$usuario->mail.",".$usuario->rol.",".$usuario->activo."\n";
        }
        $response->getBody()->write($csvContent);
        return $response->withHeader('Content-Type', 'text/csv');
    }


    public function cargarPDFdesdeTabla($request,$response,$args)
    {
        $lista = Usuario::obtenerTodos(); // Obtén los datos de la base de datos
        $csvContent = "id_usuario,nombre,apellido,mail,rol,activo\n"; // Encabezado CSV
        foreach ($lista as $usuario) 
        {
            $csvContent .= $usuario->id_usuario.",".$usuario->nombre.",".$usuario->apellido.",".$usuario->mail.",".$usuario->rol.",".$usuario->activo."\n";
        }
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','',12);
        $pdf->Multicell(0,10,$csvContent,0,'L');

        $pdf->Output('Archivo.pdf','D');

        $response->getBody()->write($csvContent);
        return $response->withHeader('Content-Type', 'text/csv');
    }



    public function TraerUno($request, $response, $args)
    {
        // Buscamos usuario por nombre
        $nombre = $args['nombre'];
        $apellido = $args['apellido'];
        $usuario = Usuario::obtenerUsuario($nombre,$apellido);
        $payload = json_encode($usuario);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();
        $payload = json_encode(array("listaUsuario" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        
        $parametros = $request->getParsedBody();
        $nombre     = $parametros['nombre'];
        $apellido   = $parametros['apellido'];
        $usuario    = Usuario::obtenerUsuario($nombre,$apellido);
        $mail       = $parametros['mail'];
        $rol        = $parametros['rol'];
        $usuario->apellido = $apellido;
        $usuario->mail = $mail;
        $usuario->rol = $rol;
        Usuario::modificarUsuario($usuario);

        $payload = json_encode(array("mensaje" => "Usuario ".$nombre." ".$apellido." modificado exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function BorrarUno($request, $response, $args)
    {
        $nombre = $args['nombre'];
        $apellido = $args['apellido'];

        Usuario::borrarUsuario($nombre,$apellido);
        $payload = json_encode(array("mensaje" => "Usuario ".$nombre." ".$apellido." borrado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

}