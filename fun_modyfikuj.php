<?php 

session_start();
if(isset($_SESSION["modyfikuj"]))
{
	$datar = $_SESSION["datarez"];
	$ids = $_POST["rezerwuj"];
	$idr = $_SESSION["modyfikuj"];
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
	$sql1 = "UPDATE rezerwacje SET data_rezerwacji = '$datar', id_klienta = '$id', id_stolika='$ids' WHERE id_rezerwacji = '$idr'";
	if ($conn->query($sql1) == TRUE) {
		unset($_SESSION["datarez"]);
		unset($_SESSION["modyfikuj"]);
		header('Location: moje_rezerwacje.php');
	}
}else 
	echo "nie dziala";
?>