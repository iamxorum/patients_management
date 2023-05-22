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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $age = $_POST['age'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $cellPhone = $_POST['cell_phone'];
    $diagnosis = $_POST['diagnosis'];

    // Pregătește și execută interogarea de inserare în baza de date
    $query = "INSERT INTO patient (first_name, last_name, age, address, email, phone, diagnosis) VALUES ('$firstName', '$lastName', '$age', '$address', '$email', '$cellPhone', '$diagnosis')";

    if (mysqli_query($conn, $query)) {
      echo '<!DOCTYPE html>
        <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Înregistrare reușită</title>
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
          <h2>Înregistrare reușită!</h2>
          <a href="../dashboard.html" class="button">Mergi la panoul de control</a>
        </body>
      </html>';
      // Puteți redirecționa utilizatorul către o altă pagină după înregistrarea reușită
      // De exemplu: header("Location: welcome.php");
      // Asigurați-vă că ieșiți din script după redirecționare
      exit;
    } else {
      echo "Eroare: " . $query . "<br>" . mysqli_error($conn);
    }

    // Închide conexiunea cu baza de date
    mysqli_close($conn);
}
?>
