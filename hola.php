<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Alumnos</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
        }
        h1 {
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin: 0 auto;
            max-width: 500px;
        }
        label, input {
            display: block;
            margin: 10px;
        }
        input[type="text"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: left;
        }
        input[type="number"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #0074d9;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 40%;
            border-collapse: collapse;
            border: 1px solid #ccc;
            margin: 20px auto;
            border-radius: 5px;
        }
        table th, table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
            border-radius: 5px;
        }
        table th {
            background-color: #0074d9;
            color: #fff;
            
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        table tr:nth-child(odd) {
            background-color: #fff;
        }



        
    </style>
</head>
<body>
    <div id="titulos"><h1>Gestión de Alumnos</h1></div>

    <?php
    // Conexión a la base de datos (Ajusta los valores según tu configuración)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "misdatos";

    $conn = new mysqli($servername, $username, $password, $database);

    // Verifica si la conexión se realizó con éxito
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }

    // Insertar datos en la base de datos
    if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['edad'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $edad = $_POST['edad'];

        $sql = "INSERT INTO usuarios (nombre, apellido, edad) VALUES ('$nombre', '$apellido', $edad)";

        if ($conn->query($sql) === TRUE) {
            echo "Datos ingresados con éxito.";
        } else {
            echo "Error al ingresar datos: " . $conn->error;
        }
    }


    ?>

    <!-- Formulario para ingresar datos -->
    <form method="post">
        <label for="nombre">NOBMRES:</label>
        <input type="text" name="nombre" id="nombre" required><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" required><br>

        <label for="edad">Edad:</label>
        <input type="number" name="edad" id="edad" required><br>

        <input type="submit" value="Ingresar datos">
    </form>

    <!-- Botón para mostrar alumnos -->
    <form method="post">
        <input type="submit" name="mostrar" value="Mostrar Alumnos">
    </form>


    <?php
        // Mostrar todos los alumnos en una tabla
        if (isset($_POST['mostrar'])) {
            echo "<h2 id='titulos'>Alumnos Registrados</h2>";
            echo "<table border='2'>";
            echo "<tr><th>Nombre</th><th>Apellido</th><th>Edad</th><th>Borrar</th></tr>";
    
            $sql = "SELECT * FROM usuarios";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['nombre'] . "</td>";
                    echo "<td>" . $row['apellido'] . "</td>";
                    echo "<td>" . $row['edad'] . "</td>";
                    echo '<td id="Borrado"><form method="post" action=""><input type="hidden" name="nombre" value="' . $row['nombre'] . '"><input type="hidden" name="apellido" value="' . $row['apellido'] . '"><input type="submit" name="borrar" value="Borrar"></form></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay alumnos registrados.</td></tr>";
            }
    
            echo "</table>";
        }
    

        if (isset($_POST['borrar'])) {
            $alumno_nombre = $_POST['nombre'];
            $alumno_apellido = $_POST['apellido'];
            $sql = "DELETE FROM usuarios WHERE nombre = '$alumno_nombre' AND apellido = '$alumno_apellido'";
            if ($conn->query($sql) === TRUE) {
                echo "Alumno $alumno_nombre $alumno_apellido ha sido eliminado.";
                
            } else {
                echo "Error al eliminar el alumno: " . $conn->error;
            }
        }
        

        $conn->close();
        ?>

        
</body>
</html>
