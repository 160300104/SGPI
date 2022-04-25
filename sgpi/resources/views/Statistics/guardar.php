<?php
require 'database/seeders/con_db.php';

$latitud = $_POST('latitud');
$longitud = $_POST('longitud');

$insertar = "INSERT INTO coords VALUES ('$latitud','$longitud')";

$query = mysqli_query($conex, $insertar);

if($query){
    echo 'Insertado correctamente';
}else{
    echo 'Insertado incorrectamente';
}

?>