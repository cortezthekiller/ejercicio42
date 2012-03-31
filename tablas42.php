<?
include("/var/seguridad/mysql.inc.php");

$tables      = array("tabla1", "tabla2");
$asignaturas = array("matematicas", "lengua", "historia", "tecnologia");

echo "<html>";
echo "<head>";
echo "<title>Tablas Ejercicio 42</title>";
echo "</head>";
echo "<body>";

/* Conectamos con el servidor y comprobamos la conexión */
$link = mysql_connect($mysql_host, $mysql_user, $mysql_passwd)
        or die("Error en la conexión: ".mysql_error());

mysql_select_db ($mysql_db, $link); 

/* Creamos tabla2 con los mismos campos que tabla1 y DNI como primary key */
$query  = "CREATE TABLE IF NOT EXISTS ".$tables[1];
$query .= "( ";
$query .= "dni VARCHAR(10), ";
$query .= "nombre VARCHAR(20), ";
$query .= "apellido1 VARCHAR(20), ";
$query .= "apellido2 VARCHAR(20), ";
$query .= "fecha_nac DATE, ";
$query .= "repetidor ENUM('si', 'no'), ";
$query .= "PRIMARY KEY(dni)";
$query .= ")";

mysql_query($query, $link) or die("Error CREATE $tables[1] ".mysql_error());
echo "Se ha creado correctamente la tabla ".$tables[1]."<br/>";

/* Una vez creada tabla2, procedemos a copiar los registros de tabla1 */
$result = mysql_query("SELECT * FROM $tables[0]", $link);
while($fila = mysql_fetch_array($result)) {
   $query  = "INSERT IGNORE ".$tables[1]; 
   $query .= " (dni, nombre, apellido1, apellido2, fecha_nac, repetidor)";
   $query .= " VALUES ('".$fila['dni']."', '".$fila['nombre'];
   $query .= "', '".$fila['apellido1']."', '".$fila['apellido2'];
   $query .= "', '".$fila['fecha_nac']."', '".$fila['repetidor']."')";

   mysql_query($query, $link) 
      or die("Error INSERT ".$tables[1].": ".mysql_error());
}

/* Crear tablas para las notas de los alumnos (DNI) en cada asignatura */
for($i=0; $i < count($asignaturas); $i++) {
   $query  = "CREATE TABLE IF NOT EXISTS ".$asignaturas[$i];
   $query .= "( ";
   $query .= "dni VARCHAR(10) NOT NULL, ";
   $query .= "nota TINYINT NOT NULL, ";
   $query .= "PRIMARY KEY(DNI) ";
   $query .= ")";

   mysql_query($query, $link) 
      or die("Error CREATE $asignaturas[$i] ".mysql_error());

   echo "Tabla ".$asignaturas[$i]." creada con éxito </br>";
}

/* Una vez creadas las nuevas tablas, vamos a pasar el dni desde tabla2 */
$result = mysql_query("SELECT * FROM $tables[1]", $link);
while($fila = mysql_fetch_array($result)) {
   for($i=0; $i < count($asignaturas); $i++) {
      $query  = "INSERT IGNORE ".$asignaturas[$i]; 
      $query .= " (dni) VALUES ('".$fila['dni']."')";

      mysql_query($query, $link) 
      or die("Error INSERT $asignaturas[$i]".mysql_error());
   }
}

echo "</body>";
echo "</html>";

mysql_free_result($result);
mysql_close($link);
?>
