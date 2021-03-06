<?php

    define("BYPASS_INSTANCE_CHECK", true);

    require_once("../../server/bootstrap.php");

    $response = null;

    function dispatcher()
    {
        global $response;

        switch ($_GET["action"]) {
            case "mod":
                $response = json_decode(InstanciasController::Editar($_GET["id"], $_GET["activa"], $_GET["descripcion"], $_GET["token"], $_GET["status"]));
                break;
            default :
                return;
        }
    }

    if (isset($_GET["action"])) {
        dispatcher();
    }

    $p = new JediComponentPage("Editar instancia");

    $p->requireParam("id", "GET", "Esta instancia no existe.", "InstanciasController::Detalles");

    $instancia = InstanciasController::Detalles($_GET["id"]);

    $p->partialRender();

?>

    <h2>Editar Instancia</h2>

    <table style = "width:100%;">
        <form name = "form1" action = "instancias.editar.php">
            <tr>
                <td>Token</td><td><input type = "text" name = "token" value = "<?php echo $instancia["instance_token"]; ?>" style = " width:100%; border-color: #1D2A5B; margin: 0; border: 1px solid #BDC7D8; font-size: 11px; margin: 0; padding: 3px; -webkit-appearance: none; -webkit-border-radius: 0;"/></td><td><input type = "button" value = "Generar Token Aleatorio" class="POS Boton" onClick = "generarAleatorio();"/></td>
            </tr>
            <tr>
                <td>Descripci&oacute;n</td><td colspan = "2"><textarea  rows="10" cols="40" name = "descripcion" style = " width:100%; border-color: #1D2A5B; margin: 0; border: 1px solid #BDC7D8; font-size: 11px; margin: 0; padding: 3px; -webkit-appearance: none; -webkit-border-radius: 0;"/><?php echo $instancia["descripcion"]; ?></textarea></td>
            </tr>
            <tr>
                <td>Activa</td><td colspan = "2"><input type="radio" name="activa" value="1" <?php echo $instancia["activa"] === "1" ? "checked" : "" ?> > s&iacute;<br/><br/><input type="radio" name="activa" value="0" <?php echo $instancia["activa"] === "0" ? "checked" : "" ?>>no</td>
            </tr>
            <tr>
                <td>Status</td>
                <td colspan = "2">
                    <select name = "status">
                        <option value="prueba" <?php echo $instancia["status"] == "prueba"? "selected=\"selected\"" : ""; ?>>Prueba</option>
                        <option value="cliente" <?php echo $instancia["status"] == "cliente"? "selected=\"selected\"" : ""; ?>>Cliente</option>
                        <option value="moroso" <?php echo $instancia["status"] == "moroso"? "selected=\"selected\"" : ""; ?>>Moroso</option>
                        <option value="prospecto" <?php echo $instancia["status"] == "prospecto"? "selected=\"selected\"" : ""; ?>>Prospecto</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan = "3"><input type = "submit" value = "Guardar" class="POS Boton OK"/><input type = "hidden" name = "action" value = "mod"/><input type = "hidden" name = "id" value = "<?php echo $_GET["id"];?>"/></td>
            </tr>
        </form>
    </table>

    <script>
        var generarAleatorio = function()
        {
            var date = new Date();

            var time0 = date.getTime().toString(12);
            var time1 = date.getTime().toString(20);
            var time2 = date.getTime().toString(16);
            var time3 = date.getTime().toString(32);

            document.form1['token'].value = time0.substring(time0.length - 4, time0.length) + time1.substring(time1.length - 4, time1.length) + time2.substring(time2.length - 4, time2.length)+ time3.substring(time3.length - 4, time3.length);
        }
    </script>

<?php
    //var_dump($response);
    if (isset($response) && $response->success === "false") {
?>
        <script>
            (function(){
                alert("<?php echo $response->reason;?>");
            })();
        </script>
<?php
    } elseif (isset($response) && $response->success === "true") {
?>
        <script>
            (function(){
                alert("Cambios realizados correctamente");
                location.href="instancias.ver.php?id=<?php echo $_GET['id'];?>";
            })();
        </script>
<?php
    }

    $p->render();