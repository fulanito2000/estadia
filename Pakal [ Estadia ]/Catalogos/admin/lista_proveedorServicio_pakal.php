<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    header("Location: index.php");
}

include_once("../WEB-INF/Classes/Catalogo.class.php");
include_once("../WEB-INF/Classes/Proveedor.class.php");
$prov = new Proveedor();
$same_page = "admin/lista_proveedorServicio_pakal.php";
$controlador = $_SESSION['ruta_controler'] . "Controler_ProveedorServicio.php";
$alta = "admin/alta_proveedorServicio_pakal.php";
$id_proveedor = "";
$where = "";
$proveedor = "";
if (isset($_POST['id']) && $_POST['id'] != "") {
    $id_proveedor = $_POST['id'];
    $where = " WHERE p.ClaveProveedor='$id_proveedor'";
    $proveedor = "Servicios del proveedor: <b>" . $prov->get_nombre_prov($id_proveedor) . "</b>";
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
            <button class="btn btn-info"  title="Nuevo" onclick='cambiarCont("<?php echo $alta; ?>", "<?php echo $id_proveedor; ?>");' style="float: right; cursor: pointer;" ><i class="fal fa-plus-circle"></i></button>
            <!--img class="imagenMouse" src="resources/images/add.png" title="Nuevo" onclick='cambiarCont("<?php echo $alta; ?>", "<?php //echo $id_proveedor; ?>");' style="float: right; cursor: pointer;" /-->  
            <br/>
            <h3 ><b><?php echo $proveedor; ?></b></h3>
            <br/>
            <table id="tAlmacen" class="table">
                <thead class="thead-dark">
                    <tr>
                        <?php if ($id_proveedor == "") { ?>
                            <th align='center' scope='row'>Proveedor</th>
                        <?php } ?>
                        <td align='center' scope='row'>Sucursal</td>
                        <td align='center' scope='row'>Servicio</td>
                        <td align='center' scope='row'>Modificar</td>
                        <td align='center' scope='row'>Eliminar</td>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $catalogo = new Catalogo();
                    $consulta = "SELECT ps.IdSucursal,ps.IdServicio,c.Modelo,ps.idProvSucServ AS id,p.NombreComercial,psuc.NombreComercial AS nomComercial FROM k_proveedorservicio ps 
                                INNER JOIN c_componente c ON ps.IdServicio=c.NoParte INNER JOIN c_proveedor p ON ps.IdProveedor=p.ClaveProveedor 
                                INNER JOIN k_proveedorsucursal psuc ON ps.IdProveedor=psuc.ClaveProveedor AND ps.IdSucursal=psuc.id_prov_sucursal
                                $where ORDER BY psuc.NombreComercial;";
                    $query = $catalogo->obtenerLista($consulta);
                    while ($rs = mysql_fetch_array($query)) {
                        echo "<tr>";
                        if ($id_proveedor == "") {
                            echo "<td align='center' scope='row'>" . $rs['NombreComercial'] . "</td>";
                        }
                        echo "<td align='center' scope='row'>" . $rs['nomComercial'] . "</td>";
                        echo "<td align='center' scope='row'>" . $rs['Modelo'] . "</td>";
                        ?>
                    <td align='center' scope='row'>
                        <a href='#' onclick='editar_suc("<?php echo $alta; ?>", "<?php echo $rs['id']; ?>");
                                    return false;' title='Editar Registro' ><img src="resources/images/Modify.png"/>
                    </td>

                    <td align='center' scope='row'>
                        <a href='#' onclick='eliminar_suc("<?php echo $controlador . "?id=" . $rs['id']; ?>", "<?php echo $same_page; ?>");
                                    return false;'><img src="resources/images/Erase.png"/></a> 
                    </td> 
                    <?php
                    echo "</tr>";
                }
                ?>
                </tbody>   
            </table>
            <br/>
            <input type="hidden" id="txt_proveedor" name="txt_proveedor" value="<?php echo $id_proveedor ?>"/>
            <input type="button" value="Proveedores" class="btn btn-success" style="float: right" onclick="cambiarContenidos('admin/lista_proveedor_pakal.php');"/>
        </div>
    </body>
</html>