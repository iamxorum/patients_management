<?php
// Presupunând că aveți deja o conexiune la baza de date stabilită
$servername = "127.0.0.1";
$admin = "root";
$password = "";
$dbname = "medical_system";

$conn = new mysqli($servername, $admin, $password, $dbname);
if ($conn->connect_error) {
  die("Conexiune eșuată: " . $conn->connect_error);
}

// Verificăm dacă formularul este trimis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Interogăm baza de date pentru a verifica dacă utilizatorul există
  $query = "SELECT * FROM users WHERE username = '$username'";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    // Verificăm parola
    if ($password === $user['password']) {
      // Parola este corectă, redirecționăm către panoul de control
      echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="5;url=../Proiect/dashboard/dashboard.html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autentificare reușită</title>
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
    </style>
  </head>
  <body>
    <h2>Autentificare reușită!</h2>
    <p.Vei fi redirecționat către panoul de control în curând...</p>
  </body>
</html>';
header("refresh:5;url=../Proiect/dashboard/dashboard.html");
exit();
    }
  }

  // Credențiale invalide, afișăm un mesaj de eroare
  echo 'Nume de utilizator sau parolă incorectă';
}
?>
