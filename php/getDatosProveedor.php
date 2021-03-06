<?php
// Conectar al servicio XE (es deicr, la base de datos) en la máquina "localhost"
header('Content-type: text/html; charset=UTF-8');
header('Content-Type: application/json');
include(
    "config/conexion_bd.inc.php"
);
if($conn){
    $params = explode(",",$argv[1]);
    $idEstablecimiento=$params[0];

    //Query de insercion de registro
    $query="SELECT A.NOMBRE_COMERCIAL, A.TELEFONO_FIJO, A.DIRECCION, A.DESCRIPCION, A.URL_IMAGEN, B.NOMBRE AS CIUDAD FROM AC_ESTABLECIMIENTO A, AC_P_CIUDAD B WHERE  A.CIUDAD = B.CODIGO AND A.ID=$idEstablecimiento";

    $resultado= oci_parse($conn, $query);
    oci_execute($resultado);
    $cerrar=oci_close($conn);
    while($row = oci_fetch_assoc($resultado))
    {
        $rows[] = $row;
    }
    $datos = array('status' => true, 'datos' => $rows);
    echo json_encode($datos);
}
else{
    $res = array('status' => false, 'message' => 'Connection error');
    echo json_encode($res);
}
?>
