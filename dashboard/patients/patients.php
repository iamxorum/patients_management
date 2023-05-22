<?php
// Conectarea la baza de date
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "medical_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Conexiunea a eșuat: " . $conn->connect_error);
}

// Recuperarea informațiilor despre pacienți din baza de date
$sql = "SELECT * FROM patient";
$result = $conn->query($sql);

// Generarea conținutului fișierului XML
$xml = '<?xml version="1.0" encoding="UTF-8"?>';
$xml .= '<patients>';

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $xml .= '<patient>';
    $xml .= '<id>' . $row['id'] . '</id>';
    $xml .= '<first_name>' . $row['first_name'] . '</first_name>';
    $xml .= '<last_name>' . $row['last_name'] . '</last_name>';
    $xml .= '<age>' . $row['age'] . '</age>';
    $xml .= '<address>' . $row['address'] . '</address>';
    $xml .= '<email>' . $row['email'] . '</email>';
    $xml .= '<cell_phone>' . $row['phone'] . '</cell_phone>';
    $xml .= '<diagnosis>' . $row['diagnosis'] . '</diagnosis>';
    $xml .= '</patient>';
  }
}

$xml .= '</patients>';

// Salvarea conținutului XML într-un fișier
$file = 'patients.xml';
file_put_contents($file, $xml);

// Închiderea conexiunii la baza de date
$conn->close();

// Redirecționarea către fișierul patients.xml
header('Location: patients.html');
exit();
?>

