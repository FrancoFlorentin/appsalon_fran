<?php 

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar() {

        // Almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        // Almacena la cita y el servicio
        $servicios = $_POST['servicios'];
        $idServicios = explode(',', $servicios);

        // Almacena los servicios con el id de la cita (itera por cada uno de los servicios)
        foreach ($idServicios as $idServicio) {
            $args = [
                'citaId' => $resultado['id'],
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        // Retornamos una respuesta
        $respuesta = [
            'resultado' => $resultado
        ];
        echo json_encode($respuesta);
    }

    public static function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cita = Cita::find($_POST['id']);
            $cita->eliminar();

            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}
