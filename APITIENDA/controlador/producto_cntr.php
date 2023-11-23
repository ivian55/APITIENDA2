<?php
class producto_cntr
{
    public $M_producto = null;
    public function __construct()
    {
        $this->M_producto = new M_producto();
    }
    public function add_producto($f3)
    {
        $mensaje = "";
        $bandera = 0;
        $producto1 = new M_producto();
        $producto1->load(['codigo=?', $f3->get('POST.codigo')]);
        if ($producto1->loaded() > 0) {
            $mensaje = "este producto ya existe en el inventario";
        } else {
            $this->M_producto->set('id', $f3->get('POST.id'));
            $this->M_producto->set('codigo', $f3->get('POST.codigo'));
            $this->M_producto->set('nombre', $f3->get('POST.nombre'));
            $this->M_producto->set('stock', $f3->get('POST.stock'));
            $this->M_producto->set('precio', $f3->get('POST.precio'));
            $this->M_producto->set('activo', $f3->get('POST.activo'));
            $this->M_producto->set('imagen', $f3->get('POST.imagen'));
            $this->M_producto->save();
            $mensaje = "se registro con exito";
            $bandera = $this->M_producto->get('codigo');
        }
        echo json_encode(
            [
                'bandera' => $bandera,
                'mensaje' => $mensaje,

            ]
        );
    }
    public function add_prod_sql($f3)
    {
        $mensaje = "";
        $bandera = 0;
        $producto1 = new M_producto();
        $producto1->load(['codigo=?', $f3->get('POST.codigo')]);
        if ($producto1->loaded() > 0) {
            $mensaje = "este producto ya existe en el inventario";
        } else {
            $cadenaSQL = "";
            $cadenaSQL = $cadenaSQL . " insert into productos values(' ";
            $cadenaSQL = $cadenaSQL . $f3->get('POST.id') . "','";
            $cadenaSQL = $cadenaSQL . $f3->get('POST.codigo') . "','";
            $cadenaSQL = $cadenaSQL . $f3->get('POST.nombre') . "',";
            $cadenaSQL = $cadenaSQL . $f3->get('POST.stock') . ",";
            $cadenaSQL = $cadenaSQL . $f3->get('POST.precio') . ",";
            $cadenaSQL = $cadenaSQL . $f3->get('POST.activo') . ",'";
            $cadenaSQL = $cadenaSQL . $f3->get('POST.imagen') . "')";
            $items = $f3->DB->exec($cadenaSQL);
            echo $cadenaSQL;
        }
        echo json_encode(
            [
                'bandera' => $bandera,
                'mensaje' => $mensaje,

            ]
        );
    }
    //listar product
    public function listarproducto($f3)
    {
        $consulta = $this->M_producto->find();
        foreach ($consulta as $producto) {
            $items[] = $producto->cast();
        }
        echo json_encode(
            [
                'cantidad' => count($items),
                'mensaje' => count($items) > 0 ? 'consulta con datos' : 'no existen datos',
                'data' => $items
            ]
        );
    }
    public function postupdatePersona($f3)
    {
        $mensaje = "";
        $bandera = 0;
        $this->M_producto->load(['codigo=?', $f3->get('POST.codigo')]);
        if ($this->M_producto->loaded() > 0) {
            $this->M_producto->set('id', $f3->get('POST.id'));
            $this->M_producto->set('codigo', $f3->get('POST.codigo'));
            $this->M_producto->set('nombre', $f3->get('POST.nombre'));
            $this->M_producto->set('stock', $f3->get('POST.stock'));
            $this->M_producto->set('precio', $f3->get('POST.precio'));
            $this->M_producto->set('activo', $f3->get('POST.activo'));
            $this->M_producto->set('imagen', $f3->get('POST.imagen'));
            $this->M_producto->save();
            $mensaje = "se modifico correctamente la persona";
            $bandera = $this->M_producto->get('codigo');
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
    public function BUSCARPRODUCT($f3)
    {

        $mensaje = "";
        $bandera = 0;
        $persona = new M_producto();
        $persona->load(['codigo=?', $f3->get('POST.codigo')]);
        $items = array();

        if ($persona->loaded() > 0) {
            $mensaje = "PRODUCTO ENCONTRADO ";
            $bandera = 1;
            $items = $persona->cast();
        } else {
            $mensaje = "ESTE PRODUCTO NO EXISTE EN LA BASE DE DATOS ";
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