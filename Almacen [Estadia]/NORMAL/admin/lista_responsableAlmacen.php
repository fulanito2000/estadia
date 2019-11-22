<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    header("Location: index.php");
}
//include_once("../WEB-INF/Classes/PartesDelComponenteC.class.php");
include_once("../WEB-INF/Classes/Catalogo.class.php");
include_once("../WEB-INF/Classes/PermisosSubMenu.class.php");
$permisos_grid = new PermisosSubMenu();
$same_page = "admin/lista_responsableAlmacen.php";
$permisos_grid->getPermisosSubmenu($_SESSION['idUsuario'], $same_page);

$controlador = $_SESSION['ruta_controler'] . "Controler_ResponsableAlmacen.php";
$alta = "admin/alta_responsableAlmacen.php";

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <script type="text/javascript" language="javascript" src="resources/js/paginas/lista_partesDelComponente.js"></script> 
    </head>
    <body>
        <div class="principal">
            <?php if($permisos_grid->getAlta()){ ?>
            <img class="imagenMouse" src="resources/images/add.png" title="Nuevo" onclick='cambiarContenidos("<?php echo $alta; ?>");' style="float: right; cursor: pointer;" />  
            <?php } ?>
            <br/><br/><br/>
            <table id="tPartesDelEq" class="tabla_datos" style="width: 100%;">
                <thead>
                    <tr>
                        <td align="center">Usuario</td><td align="center">Almacén</td><td></td><td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $catalogo = new Catalogo();
                    $query = $catalogo->obtenerLista("SELECT CONCAT(u.Nombre,' ',u.ApellidoPaterno) AS responsable,a.nombre_almacen,ra.IdUsuario,ra.IdAlmacen
                                                        FROM c_usuario u,c_almacen a,k_responsablealmacen ra
                                                        WHERE u.Activo=1 AND a.Activo=1
                                                        AND ra.IdUsuario=u.IdUsuario AND ra.IdAlmacen=a.id_almacen ORDER BY responsable ASC");
                    while ($rs = mysql_fetch_array($query)) {
                        echo "<tr>";
                        echo "<td align='center' scope='row'>" . $rs['responsable'] . "</td>";
                        echo "<td align='center' scope='row'>" . $rs['nombre_almacen'] . "</td>";
                        ?>
                    <td align='center' scope='row'> 
                        <?php if($permisos_grid->getModificar()){ ?>
                        <a href='#' onclick='editarRegistroProv("<?php echo $alta; ?>", "<?php echo $rs['IdUsuario']; ?>", "<?php echo $rs['IdAlmacen']; ?>");
                        return false;' title='Editar Registro' ><img src="resources/images/Modify.png"/></a>
                        <?php } ?>
                    </td>

                    <td align='center' scope='row'> 
                        <?php if($permisos_grid->getBaja()){ ?>
                        <a href='#' onclick='eliminarRegistroProv("<?php echo $controlador . "?id=" . $rs['IdUsuario'] . "&id2=" . $rs['IdAlmacen'] ?>", "<?php echo $rs['IdUsuario']; ?>", "<?php echo $same_page; ?>");
                        return false;'><img src="resources/images/Erase.png"/></a>
                        <?php } ?>
                    </td> 
                        <?php
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>

