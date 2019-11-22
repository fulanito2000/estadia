<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    header("Location: index.php");
}

include_once("../WEB-INF/Classes/Catalogo.class.php");
include_once("../WEB-INF/Classes/Proveedor.class.php");
$prov = new Proveedor();
$controlador = $_SESSION['ruta_controler'] . "Controler_ProveedorProducto.php";
$same_page = "admin/lista_proveedorProducto_pakal.php";
$alta = "admin/alta_proveedorProducto_pakal.php";
$proveedor = "";
$id_proveedor = "";
$where = "";
if (isset($_POST['id']) && $_POST['id'] != "") {
    $id_proveedor = $_POST['id'];
    $where = " AND pp.IdProveedor='$id_proveedor'";
    $proveedor = "Productos del proveedor: <b>" . $prov->get_nombre_prov($id_proveedor) . "</b>";
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <script type="text/javascript" language="javascript" src="resources/js/paginas/lista.js"></script>
        <script type="text/javascript" language="javascript" src="resources/js/paginas/alta_sucursal_pakal.js"></script>
        <script type="text/javascript" language="javascript" src="resources/js/paginas/alta_proveedorSucursal_pakal.js"></script>
    </head>
    <body>
        <div class="principal">
            <button class="btn btn-info" title="Nuevo" onclick='cambiarCont("<?php echo $alta; ?>", "<?php echo $id_proveedor; ?>");' style="float: right; margin-right: 25px;  cursor: pointer;" ><i class="fal fa-plus-circle"></i></button>
            <br/>
            <h3 ><b><?php echo $proveedor; ?></b></h3>
            <br/>
            <div id="tAlmacen_wrapper" class="dataTables_wrapper" role="grid">
                <table id="tAlmacen" class="table">
                <thead class="thead-dark">
                    <tr>
                        <?php if ($id_proveedor == "") { ?>
                            <td align='center' scope='row'>Proveedor</td>
                        <?php } ?>
                        <td align='center' scope='row'>Sucursal</td>
                        <td align='center' scope='row'>Producto</td>
                        <td align='center' scope='row'>Precio dólares</td>
                        <td align='center' scope='row'>Modificar</td>
                        <td align='center' scope='row'>Eliminar</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $catalogo = new Catalogo();
                    $consulta = "SELECT pp.Id_prov_suc_prod AS id,pp.IdSucursal,pp.IdProducto,psuc.NombreComercial AS sucursal,c.Modelo AS producto, c.PrecioDolares,
                                    p.NombreComercial AS proveedor, CONCAT(c.Modelo,' // ',c.NoParte,' // ', c.Descripcion) AS modelo 
                                    FROM k_proveedorproducto AS pp 
                                    INNER JOIN c_componente AS c ON c.NoParte = pp.IdProducto 
                                    INNER JOIN c_proveedor p ON p.ClaveProveedor=pp.IdProveedor $where
                                    INNER JOIN k_proveedorsucursal psuc ON pp.IdProveedor=psuc.ClaveProveedor AND pp.IdSucursal=psuc.id_prov_sucursal 
                                    ORDER BY c.Modelo;";
                    $query = $catalogo->obtenerLista($consulta);
                    while ($rs = mysql_fetch_array($query)) {
                        echo "<tr>";
                        if ($id_proveedor == "") {
                            echo "<td align='center' scope='row'>" . $rs['proveedor'] . "</td>";
                        }
                        echo "<td align='center' scope='row'>" . $rs['sucursal'] . "</td>";
                        echo "<td align='center' scope='row'>" . $rs['modelo'] . "</td>";
                        echo "<td align='center' scope='row'>$" . number_format($rs['PrecioDolares'],2) . "</td>";
                        ?>
                    <td align='center' scope='row'>
                        <a href='#' class="text-warning" style="font-size: 1.5rem;" onclick='editar_suc("<?php echo $alta; ?>", "<?php echo $rs['id']; ?>");
                                    return false;' title='Editar Registro' ><i class="fal fa-pencil-alt"></i></a>
                    </td>

                    <td align='center' scope='row'>
                        <a href='#' class="text-danger" style="font-size: 1.5rem;" onclick='eliminar_suc("<?php echo $controlador . "?id=" . $rs['id']; ?>", "<?php echo $same_page; ?>");
                                    return false;'><i class="fal fa-trash"></i></a> 
                    </td> 
                    <?php
                    echo "</tr>";
                }
                ?>
                </tbody>
                </table>
            </div>
            <br/>
            <input type="hidden" id="txt_proveedor" name="txt_proveedor" value="<?php echo $id_proveedor ?>"/>
            <input type="button" id="regresar" name="regresar" value="Proveedores" class="btn btn-success" style="float: right" onclick="cambiarContenidos('admin/lista_proveedor_pakal.php');"/>
        </div>
    </body>
</html>