<?php
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "medical_system";

// Creează o conexiune la baza de date
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Verifică dacă conexiunea a fost realizată cu succes
if (!$conn) {
  die("Conexiunea a eșuat: " . mysqli_connect_error());
}

// Verifică dacă formularul a fost trimis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preia datele din formular
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $cell_phone = $_POST['cell_phone'];
    $diagnosis = $_POST['diagnosis'];

    // Verifică dacă ID-ul există în baza de date a pacienților
    $query = "SELECT * FROM patient WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // ID-ul există, actualizează datele pacientului
        $updateQuery = "UPDATE patient SET ";
        $updateParams = array();

        // Verifică fiecare câmp și adaugă-l în interogarea de actualizare dacă nu este gol
        if (!empty($first_name)) {
            $updateQuery .= "first_name = ?, ";
            $updateParams[] = $first_name;
        }

        if (!empty($last_name)) {
            $updateQuery .= "last_name = ?, ";
            $updateParams[] = $last_name;
        }

        if (!empty($age)) {
            $updateQuery .= "age = ?, ";
            $updateParams[] = $age;
        }

        if (!empty($address)) {
            $updateQuery .= "address = ?, ";
            $updateParams[] = $address;
        }

        if (!empty($email)) {
            $updateQuery .= "email = ?, ";
            $updateParams[] = $email;
        }

        if (!empty($cell_phone)) {
            $updateQuery .= "phone = ?, ";
            $updateParams[] = $cell_phone;
        }

        if (!empty($diagnosis)) {
            $updateQuery .= "diagnosis = ?, ";
            $updateParams[] = $diagnosis;
        }

        // Elimină virgula și spațiul de la sfârșitul interogării
        $updateQuery = rtrim($updateQuery, ", ");

        $updateQuery .= " WHERE id = ?";
        $updateParams[] = $id;

        $updateStmt = $conn->prepare($updateQuery);

        // Leagă parametrii dinamic
        $updateStmt->bind_param(str_repeat("s", count($updateParams)), ...$updateParams);

        $updateStmt->execute();

        // Verifică dacă actualizarea a avut succes
        if ($updateStmt->affected_rows > 0) {
            // Datele pacientului au fost actualizate cu succes
            echo '<!DOCTYPE html>
        <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Editare pacient</title>
          <style>
            body {
              background-color: #f6f9fc;
              font-family: Arial, sans-serif;
              text-align: center;
              padding-top: 100px;
            }
      
            h2 {
              color: #333;
              margin-bottom: 30px;
            }
      
            .button {
              display: inline-block;
              background-color: #4CAF50;
              color: #fff;
              text-decoration: none;
              padding: 10px 20px;
              border-radius: 4px;
              transition: background-color 0.3s ease;
            }
      
            .button:hover {
              background-color: #45a049;
            }
          </style>
        </head>
        <body>
          <h2>Pacientul a fost editat cu succes!</h2>
          <a href="../dashboard.html" class="button">Mergi la panoul de control</a>
        </body>
      </html>';
        } else {
            // Nu s-a reușit actualizarea datelor pacientului
            echo "Nu s-a reușit actualizarea datelor pacientului!";
        }

        $updateStmt->close();
    } else {
        // ID-ul nu există în baza de date a pacienților
        echo '<!DOCTYPE html>
        <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Editare pacient</title>
          <style>
            body {
              background-color: #f6f9fc;
              font-family: Arial, sans-serif;
              text-align: center;
              padding-top: 100px;
            }
      
            h2 {
              color: #333;
              margin-bottom: 30px;
            }
      
            .button {
              display: inline-block;
              background-color: #4CAF50;
              color: #fff;
              text-decoration: none;
              padding: 10px 20px;
              border-radius: 4px;
              transition: background-color 0.3s ease;
            }
      
            .button:hover {
              background-color: #45a049;
            }
          </style>
        </head>
        <body>
          <h2>Pacientul cu ID-ul furnizat nu există!</h2>
          <a href="../dashboard.html" class="button">Mergi la panoul de control</a>
        </body>
      </html>';
    }

    $stmt->close();
    $conn->close();
}
?>
