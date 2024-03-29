<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
    header("Location: index.php");
}
include_once("../WEB-INF/Classes/ResponsableAlmacen.class.php");
include_once("../WEB-INF/Classes/Catalogo.class.php");
$pagina_lista = "admin/lista_responsableAlmacen.php";
$id = "";
$usuario = "";
$almacen = "";
$read = "";
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <script type="text/javascript" language="javascript" src="resources/js/paginas/alta_responsableAlmacen.js"></script>
        <script>
            $(document).ready(function() {
                $('.boton').button().css('margin-top', '20px');
            });
        </script>
    </head>
    <body>
        <div class="principal">
                
            <?php
            $obj = new ResponsableAlmacen();
            if (isset($_POST['id']) && isset($_POST['id2'])) {

                $obj->getRegistroById($_POST['id'], $_POST['id2']);
                // $read = "disabled='disabled'";
                $usuario = $obj->getUsuario();
                $almacen = $obj->getAlmacen();
            }
            ?>
            <form id="formresponsableAlmacen" name="formresponsableAlmacen" action="/" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="responsable">Responsable<span class="obligatorio"> *</span></label>
                            <select id="responsable" name="responsable" <?php echo $read; ?> class="custom-select">
                                <?php
                                $catalogo = new Catalogo();
                                $query = $catalogo->obtenerLista("SELECT * FROM c_usuario u WHERE (u.IdPuesto=24 OR !ISNULL(IdAlmacen)) AND u.Activo=1 ORDER BY u.Nombre,u.ApellidoPaterno ASC;");
                                echo "<option value='0' >Selecciona una opción</option>";
                                while ($rs = mysql_fetch_array($query)) {
                                    $s = "";
                                    if ($usuario == $rs['IdUsuario'] || $usuario == $rs['IdUsuario']) {
                                        $s = "selected";
                                    }
                                    echo "<option value=" . $rs['IdUsuario'] . " " . $s . ">" . $rs['Nombre'] . " " . $rs['ApellidoPaterno'] . "</option>";
                                }
                                ?>
                            </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="almacen">Almacén<span class="obligatorio"> *</span></label>
                          <select id="almacen" name="almacen" class="custom-select">
                                <?php
                                $catalogo1 = new Catalogo();
                                $query1 = $catalogo1->getListaAlta("c_almacen", "nombre_almacen");
                                echo "<option value='0' >Selecciona una opción</option>";
                                while ($rs = mysql_fetch_array($query1)) {
                                    $s = "";
                                    if ($almacen == $rs['id_almacen'] || $almacen == $rs['id_almacen']) {
                                        $s = "selected";
                                    }
                                    echo "<option value=" . $rs['id_almacen'] . " " . $s . ">" . $rs['nombre_almacen'] . "</option>";
                                }
                                ?>
                            </select>
                    </div>
                    <div class="form-group col-md-3 p-3">
                        <input type="submit" class="btn btn-success btn-block" value="Guardar" />
                    </div>
                    <div class="form-group col-md-3 p-3">
                       <input type="submit" class="btn btn-danger btn-block" value="Cancelar" onclick="cambiarContenidos('<?php echo $pagina_lista; ?>');
                return false;"/>
                <input type="hidden" id="id" name="id" value="<?php echo $usuario ?>"/>
                <input type="hidden" id="id2" name="id2" value="<?php echo $almacen ?>"/> 
                    </div>
                </div> 
            </form>
        </div>
    </body>
</html>
