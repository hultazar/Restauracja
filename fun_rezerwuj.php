<?php 

session_start();
if(isset($_POST['rezerwuj']))
{
	$datar = $_SESSION["datarez"];
	$idr = $_POST["rezerwuj"];
	$conn = new mysqli("localhost", "root", "", "stoliktu");
    $conn->set_charset("utf8");
	$sql = "select id_klienta from klienci where login = '" . $_SESSION["user"] . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
			$id = $row["id_klienta"];
        }
	}
    if ($conn->connect_error) {
        die("Błąd połączenia z bazą danych: " . $conn->connect_error);
    }
	echo 'cozachuj';
	$sql1 = "INSERT INTO rezerwacje VALUES (NULL,'$datar','$id','$idr','0')";
	if ($conn->query($sql1) == TRUE) {
		unset($_SESSION["datarez"]);
		header('Location: moje_rezerwacje.php');
	}
}else 
	echo "nie dziala";
?>