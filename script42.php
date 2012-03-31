<?
include_once("/var/seguridad/mysql.inc.php");

$table  = "tabla1";

echo "<html>";
echo "<head>";
echo "<title>Script Ejercicio 42</title>";
echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>";
echo "</head>";
echo "<body>";

/* Si se ha pulsado el botón 'Generar PDF' llamamos a otro  */
/* script 'pdf42.php' que se encargará de crear el pdf. */
if($_POST['solicitud'] == 'Generar PDF') {
   echo "Ha solicitado generar un PDF con las calificaciones<br/>";
   include("pdf42.php");
   exit(0);
}

/* Llegaremos aquí sólo si se ha pulsado el botón 'Guardar Calificación.' */

/* Comprobar que no vengan campos vacíos del formulario */
if(!$_POST['alumno'] || !$_POST['materia'] || !$_POST['nota']) {
   echo "Complete todos los datos del formulario<br/>";
   echo "<a href='form42.php'>Volver al formulario</a>";
   exit(0);
}

echo "dni alumno: ".$_POST['alumno']."<br/>";
echo "materia: ".$_POST['materia']."<br/>";
echo "nota: ".$_POST['nota']."<br/>";

/* Conectamos con el servidor y comprobamos la conexión */
$link = mysql_connect($mysql_host, $mysql_user, $mysql_passwd)
        or die("Error en la conexión: ".mysql_error());

mysql_select_db ($mysql_db, $link);

$query  = "UPDATE ".$_POST['materia']." SET nota=".$_POST['nota'];
$query .= " WHERE (dni='".$_POST['alumno']."')";

mysql_query($query, $link)
   or die("Error UPDATE: ".mysql_error());

echo "Nota guardada en la base de datos (tabla ".$_POST['materia'].")<br/>";
echo "<a href='notas.php'>Volver al formulario</a>";

echo "</body>";
echo "</html>";
mysql_close($link);
?>
