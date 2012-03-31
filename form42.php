<?
include_once("/var/seguridad/mysql.inc.php");

$table       = "tabla2";
$asignaturas = array("matematicas", "lengua", "historia", "tecnologia");

/* Nuestro formulario va a constar de 3 desplegables 'select' (uno para    */
/* los datos del alumno, otro para la asignatura y otro para la nota) y    */
/* de dos botones (guardar calificaciones en base de datos y generar pdf). */
/* El formulario en sí es una tabla html con 3 celdas (columnas).          */

echo "<html>";
echo "<head>";
echo "<title>Formulario Ejercicio 42</title>";
echo "</head>";
echo "<body>";
echo "<p>";
echo "<form name='formulario' method='POST' action='script42.php'>";
echo "<table align='center' border='1' bgcolor='#F0FFFF'>";
echo "<tr>";   /* Primera fila (encabezado) de la tabla html */
echo "<th>Alumno</th>";
echo "<th>Materia</th>";
echo "<th>Calificación</th>";
echo "</tr>";

echo "</tr>"; /* Segunda fila de la tabla en la que irán los desplegables */ 
echo "<td>";

/* Presentamos primero un desplegable con los nombres */
/* de todos los alumnos que están en la base de datos */
echo "<select name='alumno'>";
echo "<option value=''>Seleccionar alumno<option>";

/* Conectamos con el servidor y comprobamos la conexión */
$link = mysql_connect($mysql_host, $mysql_user, $mysql_passwd)
        or die("Error en la conexión: ".mysql_error());

mysql_select_db ($mysql_db, $link); 

$query = "SELECT * FROM ".$table;
$result = mysql_query($query, $link);
while($fila = mysql_fetch_array($result, MYSQL_ASSOC)) {
   /* Importante: notar que como 'value' del option pasamos el campo 'dni' */
   $option  = "<option value='".$fila['dni']."'>";
   $option .= $fila['apellido1']." ";
   $option .= $fila['apellido2'].", ";
   $option .= $fila['nombre']."</option>"; 
   echo $option;
}

echo "</select>";
echo "</td>";

echo "<td>";

/* Presentamos otro desplegable para las asignaturas */
echo "<select name='materia'>";
echo "<option value=''>Seleccionar materia<option>";
foreach($asignaturas as $value) {
   switch($value) {
      case 'matematicas':
         $asignatura = "Matemáticas";
         break;
      case 'lengua':
         $asignatura = "Lengua";
         break;
      case 'historia':
         $asignatura = "Historia";
         break;
      case 'tecnologia':
         $asignatura = "Tecnología";
         break;
   }
      
   echo "<option value='".$value."'>".$asignatura."</option>";
}
echo "</select>";
echo "</td>";

echo "<td align='center'>";

/* Presentamos otro desplegable para las notas (de 1 a 10); */
echo "<select name='nota'>";
echo "<option value=''>--</option>";
for($i=1; $i<11; $i++) {
   echo "<option value='".$i."'>".$i."</option>";
}
echo "</select>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td colspan='3' align='center' style='height:40; background-color:#FFF'>";
/* Dos opciones: mandar notas o generar pdf */
echo "<input type='submit' name='solicitud' value='Guardar Calificación'/>";
echo "<input type='submit' name='solicitud' value='Generar PDF'/>";
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</form>";
echo "</p>";
echo "</body>";
echo "</html>";

mysql_free_result($result);
mysql_close($link);
?>
