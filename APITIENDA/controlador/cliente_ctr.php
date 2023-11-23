<?php
class cliente_ctr
{
    public $M_Cliente = null;
    public function __construct()
    {
        $this->M_Cliente = new M_Cliente();
    }

    public function agregarclient($f3)
    {
        $mensaje = "";
        $bandera = 0;
        $cliente = new M_Cliente();
        $cliente->load(['identificacion=?', $f3->get('POST.identificacion')]);
        if ($cliente->loaded() > 0) {
            $mensaje = "este cliente si existe";
        } else {
            $this->M_Cliente->set('id', $f3->get('POST.id'));
            $this->M_Cliente->set('identificacion', $f3->get('POST.identificacion'));
            $this->M_Cliente->set('nombre', $f3->get('POST.nombre'));
            $this->M_Cliente->set('telefono', $f3->get('POST.telefono'));
            $this->M_Cliente->set('correo', $f3->get('POST.correo'));
            $this->M_Cliente->set('direccion', $f3->get('POST.direccion'));
            $this->M_Cliente->set('pais', $f3->get('POST.pais'));
            $this->M_Cliente->set('ciudad', $f3->get('POST.ciudad'));
            $this->M_Cliente->save();
            $mensaje = "se registro con exito";
            $bandera = $this->M_Cliente->get('identificacion');
        }
        echo json_encode(
            [
                'bandera' => $bandera,
                'mensaje' => $mensaje,

            ]
        );
    }

    public function listarcliente($f3)
    {
        $consulta = $this->M_Cliente->find();
        foreach ($consulta as $cliente) {
            $items[] = $cliente->cast();
        }
        echo json_encode(
            [
                'cantidad' => count($items),
                'mensaje' => count($items) > 0 ? 'consulta con datos' : 'no existen datos',
                'data' => $items
            ]
        );
    }
    public function actualizarcliente($f3)
    {
        $mensaje = "";
        $bandera = 0;
        $this->M_Cliente->load(['identificacion=?', $f3->get('POST.identificacion')]);
        if ($this->M_Cliente->loaded() > 0) {
            $this->M_Cliente->set('id', $f3->get('POST.id'));
            $this->M_Cliente->set('identificacion', $f3->get('POST.identificacion'));
            $this->M_Cliente->set('nombre', $f3->get('POST.nombre'));
            $this->M_Cliente->set('telefono', $f3->get('POST.telefono'));
            $this->M_Cliente->set('correo', $f3->get('POST.correo'));
            $this->M_Cliente->set('direccion', $f3->get('POST.direccion'));
            $this->M_Cliente->set('pais', $f3->get('POST.pais'));
            $this->M_Cliente->set('ciudad', $f3->get('POST.ciudad'));
            $this->M_Cliente->save();
            $mensaje = "se MODIFICO con exito";
            $bandera = $this->M_Cliente->get('identificacion');
        } else {
            $mensaje = "la persona con esta cedula no existe en la bd";
        }
        echo json_encode(
            [
                'bandera' => $bandera,
                'mensaje' => $mensaje,
            ]
        );
    }
    public function buscCLIENTE($f3)
    {

        $mensaje = "";
        $bandera = 0;
        $persona = new M_Cliente();
        $persona->load(['identificacion=?', $f3->get('POST.identificacion')]);
        $items = array();

        if ($persona->loaded() > 0) {
            $mensaje = "cliente ENCONTRADO ";
            $bandera = 1;
            $items = $persona->cast();
        } else {
            $mensaje = "ESTE cliente NO EXISTE ";
        }
        echo json_encode(
            [
                'cantidad' => $bandera,
                'mensaje' => $mensaje,
                'data' => $items
            ]
        );
    }

}
?>