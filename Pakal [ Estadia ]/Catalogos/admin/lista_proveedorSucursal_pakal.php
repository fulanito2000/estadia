<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    header("Location: index.php");
}

include_once("../WEB-INF/Classes/Catalogo.class.php");
include_once("../WEB-INF/Classes/PermisosSubMenu.class.php");
include_once("../WEB-INF/Classes/Proveedor.class.php");
$prov = new Proveedor();
$permisos_grid = new PermisosSubMenu();
$same_page = "admin/lista_proveedorSucursal_pakal.php";
$permisos_grid->getPermisosSubmenu($_SESSION['idUsuario'], $same_page);

$controlador = $_SESSION['ruta_controler'] . "Controler_ProveedorSucursal.php";
$alta = "admin/alta_proveedorSucursal_pakal.php";
$id_proveedor = "";
$where = "";
$proveedor = "";
if (isset($_POST['id']) && $_POST['id'] != "") {
    $id_proveedor = $_POST['id'];
    $where = " WHERE p.ClaveProveedor='$id_proveedor'";
    $proveedor = "Sucursales del proveedor: <b>" . $prov->get_nombre_prov($id_proveedor) . "</b>";
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <script type="text/javascript" language="javascript" src="resources/js/paginas/lista.js"></script>
        <script type="text/javascript" language="javascript" src="resources/js/paginas/alta_proveedorSucursal_pakal.js"></script>
        <script>
            $(document).ready(function() {
                $('.button').button();
            });
        </script>
    </head>
    <body>
        <div class="principal">
            <button class="btn btn-info" onclick='cambiarCont("<?php echo $alta; ?>", "<?php echo $id_proveedor; ?>");' style="float: right; cursor: pointer;" ><i class="fal fa-plus-circle"></i></button>
            <!--img class="imagenMouse" src="resources/images/add.png" title="Nuevo"/-->  
            <br/>
            <h3><b><?php echo $proveedor; ?></b></h3>
            <style>
                .dataTables_paginate{
                    margin: 10px auto !important;
                }
            </style>
            <div id="tAlmacen_wrapper" class="dataTables_wrapper" role="grid">
                <table id="tAlmacen" class="table">
                        <thead class="thead-dark">
                            <tr>
                                <?php if ($id_proveedor == "") { ?>
                                    <th align='center' scope='row'>Proveedor</th>
                                <?php } ?>
                                <th class="text-center" scope='row'>Nombre Comercial</th>
                                <th class="text-center" scope='row'>Modificar</th>
                                <th class="text-center" scope='row'>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php
                                $catalogo = new Catalogo();
                                $query = $catalogo->obtenerLista("SELECT ps.id_prov_sucursal,p.NombreComercial AS nombreProveedor, ps.NombreComercial AS nombresucursal,ps.id_prov_sucursal,ps.ClaveProveedor FROM k_proveedorsucursal ps LEFT JOIN c_proveedor p ON ps.ClaveProveedor=p.ClaveProveedor $where");
                                while ($rs = mysql_fetch_array($query)) {
                                    echo "<tr>";
                                    if ($id_proveedor == "") {
                                        echo "<td align='center' scope='row'>" . $rs['nombreProveedor'] . "</td>";
                                    }
                                    echo "<td align='center' scope='row'>" . $rs['nombresucursal'] . "</td>";
                                    ?>
                                <td align='center' scope='row'>   
                                    <a href='#' onclick='editar_suc("<?php echo $alta; ?>", "<?php echo $rs['id_prov_sucursal']; ?>");
                                                return false;' title='Editar Registro' ><i class="fal fa-pencil text-warning" style="font-size: 1.5rem;"></i></a>
                                </td>

                                <td align='center' scope='row'> 
                                    <a href='#' onclick='eliminar_suc("<?php echo $controlador . "?id=" . $rs['id_prov_sucursal']; ?>", "<?php echo $same_page; ?>");
                                                return false;'><i class="fal fa-trash text-danger" style="font-size: 1.5rem;"></i></a> 
                                </td>                                        
                                <?php
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                </table>
                <input type="hidden" id="txt_proveedor" name="txt_proveedor" value="<?php echo $id_proveedor ?>"/>
                <br/><br/>
                <input type="button" class="btn btn-success" value="Proveedores" title="ir a proveedores" onclick='cambiarContenidos("<?php echo "admin/lista_proveedor_pakal.php"; ?>");' style="float: right; cursor: pointer;"/>
            </div>
        </div>
    </body>
</html>