<?php
header('Content-type: text/html; charset=UTF-8');
header('Content-Type: application/json');
include(
    "config/conexion_bd.inc.php"
);
if($conn){

    $params = explode(",",$argv[1]);

    $id=$params[0];
    $contrasena= $params[1];

    //Query de insercion de registro
    $cambioPass="UPDATE AC_USUARIO_VEHICULO SET CONTRASENA='${contrasena}' WHERE ID='${id}'";

    $resultado= oci_parse($conn, $cambioPass);

    oci_execute($resultado);

    if($resultado){

        $passNueva = "SELECT CONTRASENA FROM AC_USUARIO_VEHICULO WHERE ID='${id}'";

        $pass= oci_parse($conn, $passNueva);

        $resul= @oci_execute($pass);

        $aux= oci_fetch_array($pass, OCI_ASSOC);

        if ($aux['CONTRASENA'] === $contrasena) {    
            $res = array('status' => true, 'message' => 'Update complete');
        }else{
            $res = array('status' => false, 'message' => 'Update failed3');
        }

    }else{
        $res = array('status' => false, 'message' => 'Update failed2');
    }

    echo json_encode($res);

}
else{
    $res = array('status' => false, 'message' => 'Connection error');
    echo json_encode($res);
}
?>