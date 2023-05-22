<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Preiați datele din formular
  $username = $_POST["username"];
  $password = $_POST["password"];
  $confirmPassword = $_POST["confirm_password"];
  $firstName = $_POST["first_name"];
  $lastName = $_POST["last_name"];
  $address = $_POST["address"];
  $email = $_POST["email"];
  $cellPhone = $_POST["cell_phone"];

  // Realizați validarea de bază
  $errors = array();

  // Verificați dacă numele de utilizator este gol
  if (empty($username)) {
    $errors[] = "Numele de utilizator este obligatoriu.";
  }

  // Verificați dacă parola este goală
  if (empty($password)) {
    $errors[] = "Parola este obligatorie.";
  }

  // Verificați dacă parola și confirmarea parolei se potrivesc
  if ($password !== $confirmPassword) {
    $errors[] = "Parolele nu coincid.";
  }

  // Verificați dacă prenumele este gol
  if (empty($firstName)) {
    $errors[] = "Prenumele este obligatoriu.";
  }

  // Verificați dacă numele de familie este gol
  if (empty($lastName)) {
    $errors[] = "Numele de familie este obligatoriu.";
  }

  // Verificați dacă adresa este goală
  if (empty($address)) {
    $errors[] = "Adresa este obligatorie.";
  }

  // Verificați dacă adresa de email este goală
  if (empty($email)) {
    $errors[] = "Adresa de email este obligatorie.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Formatul adresei de email este invalid.";
  }

  // Verificați dacă numărul de telefon mobil este gol
  if (empty($cellPhone)) {
    $errors[] = "Numărul de telefon mobil este obligatoriu.";
  }

  // Dacă nu există erori, continuați cu înregistrarea
  if (empty($errors)) {
    // Realizați alte operații de procesare, cum ar fi stocarea datelor într-o bază de date
    // Puteți personaliza această parte în funcție de cerințele specifice

    // Exemplu: Stocați datele într-o tabelă de bază de date
    $dbHost = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "medical_system";

    // Creați o conexiune la baza de date
    $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

    // Verificați dacă conexiunea a fost realizată cu succes
    if (!$conn) {
      die("Conexiune eșuată: " . mysqli_connect_error());
    }

    // Pregătiți și executați interogarea de inserare
    $query = "INSERT INTO users (username, password, first_name, last_name, address, email, phone) VALUES ('$username', '$password', '$firstName', '$lastName', '$address', '$email', '$cellPhone')";

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
          <a href="index.html" class="button">Accesați pagina principală</a>
        </body>
      </html>';
      // Puteți redirecționa utilizatorul către o altă pagină după înregistrarea reușită
      // De exemplu: header("Location: welcome.php");
      // Asigurați-vă că ieșiți din script după redirecționare
      exit;
    } else {
      echo "Eroare: " . $query . "<br>" . mysqli_error($conn);
    }

    // Închideți conexiunea la baza de date
    mysqli_close($conn);
  }
}
?>