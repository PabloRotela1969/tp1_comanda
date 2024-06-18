<?php
include_once './txt/archivos.php';
class Pedido
{
    public $id_pedido;
    public $estado_pedido;
    public $tiempoEstimado;
    public $id_mesa;
    public $activo;
    public $fecha;
    public $id_usuario;
    public $foto;

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO Pedido (id_pedido,estado_pedido,tiempoEstimado,id_mesa,activo,fecha,id_usuario,foto) VALUES (:id_pedido,:estado_pedido,:tiempoEstimado,:id_mesa,:activo,:fecha,:id_usuario,:foto)");
        $consulta->bindValue(':id_pedido', $this->id_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':estado_pedido', $this->estado_pedido, PDO::PARAM_STR);
        $consulta->bindValue(':tiempoEstimado', $this->tiempoEstimado, PDO::PARAM_INT);
        $consulta->bindValue(':id_mesa', $this->id_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':activo', 1);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public function cargarTablasDesdeCSV()
    {
        $array = archivos::LeerArchivo('./data/pedidos.csv');
        foreach ($array as $linea)
        {
            $dato = explode(',',$linea);
            if(isset($dato[1]))
            {
                $this->id_pedido         = $dato[0];
                $this->estado_pedido     = $dato[1];
                $this->tiempoEstimado    = $dato[2];
                $this->id_mesa           = $dato[3];
                $this->activo            = $dato[4];
                $this->fecha             = $dato[5];
                $this->id_usuario        = $dato[6];
                $this->foto              = $dato[7];
                $this->crearPedido();

            }
        }
    }

    public function cargarCSVdesdeTablas()
    {
        $array = self::obtenerTodos();
        foreach($array as $linea)
        {
            $cadena = $linea->id_pedido.",".$linea->estado_pedido.",".$linea->tiempoEstimado.",".$linea->id_mesa.",".$linea->activo.",".$linea->fecha.",".$linea->id_usuario.",".$linea->foto."\n";
            archivos::escribirCadenaHaciaArchivo('./data/pedidosBajados.csv',$cadena);
        }
    }


    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_pedido,estado_pedido,tiempoEstimado,id_mesa,activo,fecha,id_usuario,foto FROM Pedido WHERE activo > 0");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function obtenerPedido($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id_pedido,estado_pedido,tiempoEstimado,id_mesa,activo,fecha,id_usuario,foto  FROM Pedido WHERE id_pedido = :id_pedido");
        $consulta->bindValue(':id_pedido', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchObject('Pedido');
    }

    public static function modificarPedido($Pedido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE Pedido SET estado_pedido = :estado_pedido, tiempoEstimado = :tiempoEstimado , id_mesa = :id_mesa, fecha = :fecha,id_usuario = :id_usuario, foto = :foto WHERE id_pedido = :id");
        $consulta->bindValue(':estado_pedido', $Pedido->estado_pedido, PDO::PARAM_STR);
        $consulta->bindValue(':tiempoEstimado', $Pedido->tiempoEstimado, PDO::PARAM_INT);
        $consulta->bindValue(':id_mesa', $Pedido->id_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':fecha', $Pedido->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':id_usuario', $Pedido->id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $Pedido->foto, PDO::PARAM_STR);
        $consulta->bindValue(':id', $Pedido->id_pedido, PDO::PARAM_INT);
        $consulta->execute();
    }

    public static function borrarPedido($id)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE Pedido SET activo = 0 WHERE id_pedido = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    }

}