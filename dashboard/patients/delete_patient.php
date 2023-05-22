<?php
$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "medical_system";

// Crează o conexiune cu baza de date
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Verifică dacă conexiunea a fost realizată cu succes
if (!$conn) {
  die("Conexiune eșuată: " . mysqli_connect_error());
}

// Verifică dacă formularul a fost trimis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preia datele din formular
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // Pregătește și execută interogarea SQL pentru ștergerea pacientului
    $query = "DELETE FROM patient WHERE first_name = ? AND last_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $first_name, $last_name);
    $stmt->execute();

    // Verifică dacă ștergerea a fost realizată cu succes
    if ($stmt->affected_rows > 0) {
        // Pacientul a fost șters cu succes
        echo '<!DOCTYPE html>
        <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Șterge Pacient</title>
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
          <h2>Pacientul a fost șters cu succes!</h2>
          <a href="../dashboard.html" class="button">Mergi la Panoul de Control</a>
        </body>
      </html>';
    } else {
        // Nu a fost găsit niciun pacient potrivit
        echo '<!DOCTYPE html>
        <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Șterge Pacient</title>
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
          <h2>Pacientul nu a fost găsit!</h2>
          <a href="../dashboard.html" class="button">Mergi la Panoul de Control</a>
        </body>
      </html>';
    }

    // Închide declarația și conexiunea cu baza de date
    $stmt->close();
    $conn->close();
}
?>
