<?php

    session_start();

    if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {

        header("Location: index.php");

    }

    include_once("../WEB-INF/Classes/Catalogo.class.php");

    include_once("../WEB-INF/Classes/PermisosSubMenu.class.php");

    $permisos_grid = new PermisosSubMenu();

    $same_page = "admin/lista_tipocliente.php";

    $permisos_grid->getPermisosSubmenu($_SESSION['idUsuario'], $same_page);

    $cabeceras = array("Nombre", "Descripción","Radio (Búsqueda KM)","","");

    $columnas = array("Nombre", "Descripcion", "Radio" ,"IdTipoCliente");

    $controlador = $_SESSION['ruta_controler'] . "Controler_TipoCliente.php";

    $tabla = "c_tipocliente";

    $order_by = "Nombre";

    $alta = "admin/alta_tipocliente.php";

?>

<!DOCTYPE html>

<html lang="es">

    <head>

        <script type="text/javascript" language="javascript" src="resources/js/paginas/lista.js"></script>

    </head>

    <body>

        <div class="principal" style="font-size: 14px;">

            <div class="row">

                <div class="col-12 d-flex justify-content-end">

                    <?php if ($permisos_grid->getAlta()) { ?>

                        <button class="imagenMouse btn btn-success" title="Nuevo" onclick='cambiarContenidos("<?php echo $alta; ?>");' style=" cursor: pointer;"><span class="oi oi-plus"></span> Nuevo</button>

                    <?php } ?>
                        
                </div>

            </div><br>

            <!-- inicio de la tabla -->
                
                <div class="bg-light rounded" style="height:120%; padding:8px;"> 

                    <table id="tAlmacen" class="compact table-bordered table-striped table-xs">
                        <thead>
                            <tr>
                                <?php
                                for ($i = 0; $i < (count($cabeceras) - 2); $i++) {
                                    echo "<th width=\"2%\" align=\"center\" scope=\"col\">" . $cabeceras[$i] . "</th>";
                                }
                                echo "<th width=\"2%\" align=\"center\" scope=\"col\"></th>";
                                echo "<th width=\"2%\" align=\"center\" scope=\"col\"></th>";
                                ?> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            /* Inicializamos la clase */
                            $catalogo = new Catalogo();
                            $query = $catalogo->getListaAlta($tabla, $order_by);
                            while ($rs = mysql_fetch_array($query)) {
                                echo "<tr>";
                                for ($i = 0; $i < count($columnas) - 1; $i++) {
                                    echo "<td align='center' scope='row'>" . $rs[$columnas[$i]] . "</td>";
                                }
                                ?>
                                <td align='center' scope='row'>  
                                    <?php if($permisos_grid->getModificar()){ ?>
                                    <a href='#' onclick='editarRegistro("<?php echo $alta; ?>", "<?php echo $rs[$columnas[count($columnas) - 1]]; ?>");return false;' title='Editar Registro' class="text-warning" style="font-size: 1.5rem;">
                                        <i class="fal fa-pencil-alt"></i>
                                    </a>
                                    <?php } ?>
                                </td>
                                
                                <td align='center' scope='row'> 
                                    <?php if($permisos_grid->getBaja()){ ?>
                                    <a href='#' onclick='eliminarRegistro("<?php echo $controlador . "?id=" . $rs[$columnas[count($columnas) - 1]]; ?>", "<?php echo $same_page; ?>");
                                    return false;' class='text-danger' style='font-size: 1.5rem;'><i class="fal fa-trash"></i></a> 
                                    <?php } ?>
                                </td>                                        
                                    <?php                        
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table><br><br>

                </div>

            <!-- fin de la tabla --> 

        </div>

    </body>

</html>