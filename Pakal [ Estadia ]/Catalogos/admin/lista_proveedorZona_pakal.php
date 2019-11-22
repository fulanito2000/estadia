<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    header("Location: index.php");
}

include_once("../WEB-INF/Classes/Catalogo.class.php");
include_once("../WEB-INF/Classes/Proveedor.class.php");
$prov = new Proveedor();
$controlador = $_SESSION['ruta_controler'] . "Controler_ProveedorZona.php";
$same_page = "admin/lista_proveedorZona.php";
$alta = "admin/alta_proveedorZona_pakal.php";
$id_proveedor = "";
$where = "";
$proveedor = "";
if (isset($_POST['id']) && $_POST['id'] != "") {
    $id_proveedor = $_POST['id'];
    $where = " WHERE p.ClaveProveedor='$id_proveedor'";
    $proveedor = "Zonas del proveedor: <b>" . $prov->get_nombre_prov($id_proveedor) . "</b>";
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
            <style>
            #tAlmacen{
            width: 100% !important;
            }
            
            .dataTables_paginate{
            margin: 10px auto !important;
            }
            
            </style>
            <button class="btn btn-info" title="Nuevo" onclick='cambiarCont("<?php echo $alta; ?>", "<?php echo $id_proveedor; ?>");' style="float: right; margin-right: 25px;  cursor: pointer;" ><i class="fal fa-plus-circle"></i></button>
            <!--img class="imagenMouse" src="resources/images/add.png" title="Nuevo" onclick='cambiarCont("<?php// echo $alta; ?>", "<?php// echo $id_proveedor; ?>");' style="float: right; margin-right: 25px;  cursor: pointer;" /-->  
            <br/>
            <h3 ><b><?php echo $proveedor; ?></b></h3>
            <br/>
            <div id="tAlmacen_wrapper" class="dataTables_wrapper" role="grid">
                <table  id="tAlmacen" class="tabla_datos dataTable table">
                    <thead class="thead-dark">
                        <tr>
                        <?php if ($id_proveedor == "") { ?>
                            <th class='text-center'>Proveedor</th>
                        <?php } ?>
                        <td class='text-center'>Sucursal</td>
                        <td class='text-center'>Grupo zona</td>
                        <td class='text-center'>zona</td>
                        <td class='text-center'>Tiempo maximo respuesta</td>
                        <td class='text-center'>Modificar</td>
                        <td class='text-center'>Eliminar</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $catalogo = new Catalogo();
                        $consulta = "SELECT pz.id_prov_suc_zona AS id,p.NombreComercial AS proveedor,psuc.NombreComercial AS sucursal,gz.nombre AS gZona,z.NombreZona AS zona,pz.TiempoMaximoSolucion AS tiempo,psuc.NombreComercial AS nomSuc 
                                        FROM k_proveedorzona pz INNER JOIN c_proveedor p ON pz.IdProveedor=p.ClaveProveedor INNER JOIN c_gzona gz ON pz.idGZona=gz.id_gzona INNER JOIN c_zona z ON pz.ClaveZona=z.ClaveZona  
                                        INNER JOIN k_proveedorsucursal psuc ON pz.IdProveedor=psuc.ClaveProveedor AND pz.IdSucursal=psuc.id_prov_sucursal $where  ORDER BY p.NombreComercial ASC";
                        $query = $catalogo->obtenerLista($consulta);
                        while ($rs = mysql_fetch_array($query)) {
                            echo "<tr>";
                            if ($id_proveedor == "") {
                                echo "<td class='text-center'>" . $rs['proveedor'] . "</td>";
                            }
                            echo "<td class='text-center'>" . $rs['nomSuc'] . "</td>";
                            echo "<td class='text-center'>" . $rs['gZona'] . "</td>";
                            echo "<td class='text-center'>" . $rs['zona'] . "</td>";
                            echo "<td class='text-center'>" . $rs['tiempo'] . "</td>";
                            ?>
                        <td class='text-center'>
                            <a href='#' onclick='editar_suc("<?php echo $alta; ?>", "<?php echo $rs['id']; ?>");
                                        return false;' title='Editar Registro' ><i class="fal fa-pencil text-warning" style="font-size: 1.5rem;"></i></a>
                        </td>

                        <td class='text-center'>
                            <a href='#' onclick='eliminar_suc("<?php echo $controlador . "?id=" . $rs['id']; ?>", "<?php echo $same_page; ?>");
                                        return false;'><i class="fal fa-trash text-danger" style="font-size: 1.5rem;"></i></a> 
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