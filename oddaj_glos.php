<?php 
session_start();
if(isset($_POST['ocena']))
{
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
	$sql1 = "insert into glosy values(NULL, ".$id.",".$_POST["ocena"].")";
	if ($conn->query($sql1) == TRUE) {
		header('Location: opinie.php');
	}
}else 
	echo "nie dziala";
?>