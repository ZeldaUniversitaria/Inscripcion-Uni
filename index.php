<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Registro e inscripción</title>
</head>
<body>
    <?php
    // Conexión a la base de datos (esto debe ir al inicio)
    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "uni";
 
    $conn = new mysqli($servername, $username, $password, $dbname);
 
    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }
 
    // === Agregar alumno ===
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregar_alumno'])) {
        $codigo = $_POST['codigo'];
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $edad = $_POST['edad'];
        $telefono = $_POST['telefono'];
 
        $sql = "INSERT INTO alumnos(Codigo, Nombre, Apellidos, Edad, Telefono)
                VALUES('$codigo', '$nombre', '$apellidos', '$edad', '$telefono')";
 
        if ($conn->query($sql) === TRUE) {
            echo "<p class='success'>El alumno fue agregado</p>";
        } else {
            echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }
 
    // === Obtener los alumnos ===
    $alumnos_query = "SELECT Codigo, Nombre, Apellidos FROM alumnos";
    $alumnos_result = $conn->query($alumnos_query);
 
    // === Obtener las carreras ===
    $carreras_query = "SELECT Codigo, Nombre FROM carreras";
    $carreras_result = $conn->query($carreras_query);
 
    // === Registrar inscripción ===
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar_inscripcion'])) {
        $codigoAlumno = $_POST['alumno'];
        $codigoCarrera = $_POST['carrera'];
        $fecha = date('Y-m-d');
 
        $sql = "INSERT INTO inscripciones (Fecha, CodigoAlumno, CodigoCarrera)
                VALUES ('$fecha', '$codigoAlumno', '$codigoCarrera')";
 
        if ($conn->query($sql) === TRUE) {
            echo "<p class='success'>Inscripción registrada correctamente.</p>";
        } else {
            echo "<p class='error'>Error: " . $sql . "<br>" . $conn->error . "</p>";
        }
    }
    ?>
 
    <!-- Formulario para agregar alumno -->
     <h1> Registrar Alumno </h1>
    <form action="" method="POST">
        <label for="codigo">Código: </label><br>
        <input type="text" id="codigo" name="codigo" required><br><br>
 
        <label for="nombre">Nombre: </label><br>
        <input type="text" id="nombre" name="nombre"><br><br>
 
        <label for="apellidos">Apellidos: </label><br>
        <input type="text" id="apellidos" name="apellidos"><br><br>
 
        <label for="edad">Edad: </label><br>
        <input type="number" id="edad" name="edad"><br><br>
 
        <label for="telefono">Teléfono: </label><br>
        <input type="tel" id="telefono" name="telefono"><br><br>
 
        <input type="submit" name="agregar_alumno" value="Agregar Alumno">
    </form>

    <form action="index.php" method="POST">
        <h1> Registrar Inscripcion </h1>
        <label for="alumno"> Selecciona alumno: </label> <br>
        <select name="alumno" id="alumno" required> 
        <option value=""> Seleccione un alumno </option>

        <?php
        while($alumno =$alumnos_result->fetch_assoc()){
            echo "<option value = '{$alumno['Codigo']}' > {$alumno['Nombre']} {$alumno['Apellidos']} (Codigo:{$alumno['Codigo']}) </option>";   
            }
        ?>
        </select><br><br>

        <label for="carrera">Selecciona Carrera: </label><br>
        <select name="carrera" id="carrera" required>
        
        <option value="">Seleccione una carrera</option>
        <?php
        
        while ($carrera = $carreras_result->fetch_assoc()) {
        echo "<option value='{$carrera['Codigo']}'>{$carrera['Nombre']} (Código: {$carrera['Codigo']})</option>"; 
        }
        ?>
        </select> <br><br>


        <input type="submit" name="registrar_inscripcion" value="Registrar Inscripción">
    </form>
</body>
</html>