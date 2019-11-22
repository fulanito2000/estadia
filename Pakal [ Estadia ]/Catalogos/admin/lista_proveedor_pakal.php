<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    header("Location: index.php");
}

include_once("../WEB-INF/Classes/Catalogo.class.php");
include_once("../WEB-INF/Classes/PermisosSubMenu.class.php");
$permisos_grid = new PermisosSubMenu();
$same_page = "admin/lista_proveedor_pakal.php";
$permisos_grid->getPermisosSubmenu($_SESSION['idUsuario'], $same_page);

$controlador = $_SESSION['ruta_controler'] . "Controler_Proveedor.php";

$cabeceras = array("Nombre", "RFC", "", "");
$columnas = array("NombreComercial", "RFC", "ClaveProveedor");
$tabla = "c_proveedor";
$order_by = "NombreComercial";
$alta = "admin/alta_proveedor_pakal.php";
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <script type="text/javascript" language="javascript" src="resources/js/paginas/lista.js"></script>
    </head>
    <body>

        
        <div class="principal">
            <div class="section">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <?php if ($permisos_grid->getAlta()) { ?>
                            <button class="btn btn-secondary m-3" onclick='cambiarContenidos("<?php echo $alta; ?>");' style="float: right; cursor: pointer;" >Nuevo proveedor <i class="fal fa-plus-circle" style="font-size: 1.2rem;"></i></button>
                        <?php } ?>
                        <?php if ($permisos_grid->getAlta()) { ?>
                            &nbsp;&nbsp;
                            <button class="btn btn-secondary m-3" onclick='cambiarContenidos("admin/alta_proveedorSucursal_pakal.php");' style="float: right; cursor: pointer;" >Nueva sucursal <i class="fal fa-plus-circle"
                                style="font-size: 1.2rem;"></i></button>
                        <?php } ?>
                        <?php if ($permisos_grid->getAlta()) { ?>&nbsp;&nbsp;
                            <button class="btn btn-secondary m-3" title="Nuevo servicio" onclick='cambiarContenidos("admin/alta_proveedorServicio_pakal.php");' style="float: right; cursor: pointer;" >Nuevo servicio <i class="fal fa-plus-circle" style="font-size: 1.2rem;"></i></button>
                        <?php } ?>
                        <?php if ($permisos_grid->getAlta()) { ?>&nbsp;&nbsp;
                            <button class="btn btn-secondary m-3" title="Nuevo producto" onclick='cambiarContenidos("admin/alta_proveedorProducto_pakal.php");' style="float: right; cursor: pointer;" >Nuevo producto <i class="fal fa-plus-circle" style="font-size: 1.2rem;"></i></button>
                        <?php } ?>
                        <?php if ($permisos_grid->getAlta()) { ?>&nbsp;&nbsp;
                            <button class="btn btn-secondary m-3" title="Nueva zona" onclick='cambiarContenidos("admin/alta_proveedorZona_pakal.php");' style="float: right; cursor: pointer;" >Nueva zona <i class="fal fa-plus-circle" style="font-size: 1.2rem;"></i></button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!--style>
	            #tAlmacen{
				    width: 100%;
				}/*
				.dataTables_paginate{
				    margin: 10px auto !important;
				}*/
	        </style-->
            	<table  id="tAlmacen" class="tabla_datos dataTable table">
	                <thead class="thead-dark">
	                    <tr role="row">
	                        <?php
	                        for ($i = 0; $i < (count($cabeceras) - 2); $i++) {
	                            echo "<th width=\"2%\" align=\"center\" scope=\"col\">" . $cabeceras[$i] . "</th>";
	                        }
	                        echo "<th width=\"2%\" class=\"text-center\" scope=\"col\">Proveedor</th>";
	                        echo "<th width=\"2%\" class=\"text-center\" scope=\"col\">Sucursales</th>";
	                        echo "<th width=\"2%\" class=\"text-center\" scope=\"col\">Servicio</th>";
	                        echo "<th width=\"2%\" class=\"text-center\" scope=\"col\">Producto</th>";
	                        echo "<th width=\"2%\" class=\"text-center\" scope=\"col\">Zona</th>";
	                        echo "<th width=\"2%\" class=\"text-center\" scope=\"col\"></th>";                        
	                        ?>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php
	                    /* Inicializamos la clase */
	                    $consulta="SELECT ClaveProveedor,NombreComercial,RFC,tp.Nombre AS tipo ,p.Activo
	                        FROM `$tabla` AS p INNER JOIN c_tipoproveedor AS tp ON tp.Activo = 1 /*AND tp.IdTipoProveedor = p.IdTipoProveedor */
	                        /*ORDER BY $order_by*/ GROUP BY ClaveProveedor;";
	                    $catalogo = new Catalogo();
	                    $query = $catalogo->obtenerLista($consulta);
	                    while ($rs = mysql_fetch_array($query)) {
	                        echo "<tr>";
	                        //echo "<td align='center' scope='row'>" . $rs["ClaveProveedor"] . "</td>";
	                        echo "<td align='center' scope='row'>" . $rs["NombreComercial"] . "</td>";
	                        echo "<td align='center' scope='row'>" . $rs["RFC"] . "</td>";
	                        //echo "<td align='center' scope='row'>" . $rs["tipo"] . "</td>";
	                        
	                        ?>
	                    <td align='center' scope='row'>      
	                        <?php if ($permisos_grid->getModificar()) { ?>
	                            <a href='#' onclick='editarRegistro("<?php echo $alta; ?>", "<?php echo $rs[$columnas[count($columnas) - 1]]; ?>");
	                            return false;' title='Editar Registro' >
	                                <i class="fal fa-pencil text-primary" style="font-size: 1.5rem;"></i>
	                            </a>
	                        <?php } ?>
	                    </td>
	                    <td align='center' scope='row'> 
	                        <?php if ($permisos_grid->getModificar()) { ?>
	                            <a href='#' onclick='editarRegistro("admin/lista_proveedorSucursal_pakal.php", "<?php echo $rs[$columnas[count($columnas) - 1]]; ?>");
	                            return false;' title='Editar Sucursales' ><i class="fal fa-pencil text-secondary" style="font-size: 1.5rem;"></i></a>
	                           <?php } ?>
	                    </td>
	                    <td align='center' scope='row'>      
	                        <?php if ($permisos_grid->getModificar()) { ?>
	                            <a href='#' onclick='editarRegistro("admin/lista_proveedorServicio_pakal.php", "<?php echo $rs[$columnas[count($columnas) - 1]]; ?>");
	                            return false;' title='Editar Servicios' >
	                                <i class="fal fa-pencil text-success" style="font-size: 1.5rem;"></i>
	                            </a>
	                        <?php } ?>
	                    </td>
	                    <td align='center' scope='row'> 
	                        <?php if ($permisos_grid->getModificar()) { ?>
	                            <a href='#' onclick='editarRegistro("admin/lista_proveedorProducto_pakal.php", "<?php echo $rs[$columnas[count($columnas) - 1]]; ?>");
	                            return false;' title='Editar Productos' ><i class="fal fa-pencil text-warning" style="font-size: 1.5rem;"></i></a>
	                           <?php } ?>
	                    </td>
	                    <td align='center' scope='row'> 
	                        <?php if ($permisos_grid->getModificar()) { ?>
	                            <a href='#' onclick='editarRegistro("admin/lista_proveedorZona_pakal.php", "<?php echo $rs[$columnas[count($columnas) - 1]]; ?>");
	                            return false;' title='Editar Zonas' ><i class="fal fa-pencil text-info" style="font-size: 1.5rem;"></i></a>
	                           <?php } ?>
	                    </td>
	                    
	                    
	                    <td align='center' scope='row'> 
	                        <?php if ($permisos_grid->getBaja()) { ?>
	                            <a href='#' onclick='eliminarRegistro("<?php echo $controlador . "?id=" . $rs[$columnas[count($columnas) - 1]]; ?>", "<?php echo $same_page; ?>");
	                            return false;'><i class="fal fa-trash text-danger" style="font-size: 1.5rem;"></i></a> 
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