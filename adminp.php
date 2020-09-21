<!DOCTYPE HTML>
<?php session_start();?>
<html lang="pl">    

<head >
	<meta charset="utf-8"/>
	<title>Stolik-Tu</title>    
	<meta name="description" content="Witam cie na mojej stronie. Wybierz interesujący cię stolik i zarezerwuj już Dziś !" />
	<meta name="keywords" content="rezerwacja stolika, stolik, restauracja"/>
	<meta http-equiv="default-style" content="IE=edge , chrome=1"/>
	<link rel="stylesheet" href="style.css" type="text/css" /> 
</head>

<body>
<div class="wrapper">
	<header class="header"><img src="img/logo.png" alt="logo"></header>
    <nav>
		<ul class="menu_glowne"> 
			<li><a href="index.php">Główna</a></li>
			
			<?php
					if((isset($_SESSION['user'])) && ($_SESSION['user']==true))
					{
						echo 	'<li><a href="wyloguj.php">Wyloguj</a></li>
								<li><a href="moje_rezerwacje.php">Moje rezerwacje</a></li>
								<li><a href="rezerwacja.php">Zarezerwuj</a></li>';
					}
					else if((isset($_SESSION['admin'])) && ($_SESSION['admin']==true))
					{
						echo 	'<li><a href="wyloguj.php">Wyloguj</a></li>
								<li><a href="admin.php">Zamówienia</a></li>
								<li><a href="usun_usera.php">Użytkownicy</a></li>';
					}
					else
					{
						echo 	'<li><a href="rejestracja.php">Rejestracja</a></li>
								<li><a href="login.php">Zaloguj</a></li>';
					}
			?>
			<li><a href="oferta.php">Oferta</a></li>
			<li><a href="opinie.php">Opinie Klientów</a></li>
		</ul> 
    </nav>
	
	<article class="main">
    <?php
                    if (isset($_SESSION["user"])) {
                        ?>
                        <span class="bigtitle"> Błąd dostępu </span>
                        <div class="dottedline"></div>
                        <div id="panel">
                            Jesteś zalogowany jako użytkownik! Brak uprawnień.
                        </div>
                        <?php
                    } else if (isset($_SESSION["admin"])) {
                        if (isset($_POST["usun"])) {
                            $conn = new mysqli("localhost", "root", "", "stoliktu");
                            $conn->set_charset("utf8");
                            if ($conn->connect_error) {
                                die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                            }
                            $sql = "delete from rezerwacje where id_rezerwacji = " . $_POST["usun"];
                            if ($conn->query($sql) == TRUE) {
                                $conn->close();
                                header("Refresh:0");
                            }
                        }else if (isset($_POST["potwierdz"])) {
                            $conn = new mysqli("localhost", "root", "", "stoliktu");
                            $conn->set_charset("utf8");
                            if ($conn->connect_error) {
                                die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                            }
                            $sqlU = "UPDATE rezerwacje SET czy_potwierdzona=true WHERE id_rezerwacji = " . $_POST["potwierdz"];
                            if ($conn->query($sqlU) == TRUE) {
                                $conn->close();
                                header("Refresh:0");
                            }
                        }
                        echo '<h2>Statystyka zamówień:</h2>';
					
						$dzisiaj =date("Y-m-d");
                        echo '<div class="dottedline"></div>';
                        $conn = new mysqli("localhost", "root", "", "stoliktu");
                        $conn->set_charset("utf8");
                        if ($conn->connect_error) {
                            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                        }
							$sql = "select login, email, id_rezerwacji, czy_potwierdzona, "
                                . "data_rezerwacji, "
                                . "tytul "
                                . "from rezerwacje "
                                . "natural join stoliki "
                                . "natural join klienci WHERE data_rezerwacji > '$dzisiaj' AND czy_potwierdzona = 'false' order by data_rezerwacji ASC";
                        $result1 = $conn->query($sql);
                        if ($result1->num_rows > 0) {
                            echo '<table class="tablica" align="center">'
                            . '<tr><th>Login</th><th>Email</th><th>Data</th><th>Tytuł</th><th>Potwierdź</th><th>Usuń</th></tr><tbody>';
                            while ($row = $result1->fetch_assoc()) {
								if($row["czy_potwierdzona"] == false)
								{
									echo '<tr>'
									. '<td>' . $row["login"] . '</td>'
											. '<td>' . $row["email"] . '</td>'
									. '<td>' . $row["data_rezerwacji"] . '</td>'
									. '<td>' . $row["tytul"] . '</td>'
									. '<td><form method="post"><button type="submit" value="' . $row["id_rezerwacji"] . '" name="potwierdz" ><strong>Potwierdź</strong></button></form></td>'
									. '<td><form method="post"><button type="submit" value="' . $row["id_rezerwacji"] . '" name="usun" ><strong>Usuń</strong></button></form></td>'
									. '</tr>';
								}else{
									echo '<tr>'
									. '<td>' . $row["login"] . '</td>'
											. '<td>' . $row["email"] . '</td>'
									. '<td>' . $row["data_rezerwacji"] . '</td>'
									. '<td>' . $row["tytul"] . '</td>'
									. '<td> </td>'
									. '<td><form method="post"><button type="submit" value="' . $row["id_rezerwacji"] . '" name="usun" ><strong>Usuń</strong></button></form></td>'
									. '</tr>';
								}
                            }
                            echo '</tbody></table>';
                        } else {
                            echo "<h3>Na razie nie ma zamówień</h3>";
                        }
                    } else {
                        if (isset($_POST["zaloguj"])) {
                            $conn = new mysqli("localhost", "root", "", "stoliktu");
                            $conn->set_charset("utf8");
                            if ($conn->connect_error) {
                                die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                            }
                            if (!isset($_POST["username"]) || !isset($_POST["psw"])) {
                                echo '<h2>Nie wszystkie pola formularza zostały wypełnione!</h2>';
                                    drukuj_form();
                            } else {
                                $sql = "select * from administratorzy where login = '" . $_POST["username"] . "' and haslo = '" . hash('sha256', $_POST["psw"]) . "'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) {
                                    $_SESSION["admin"] = $_POST["username"];
                                    echo '<h2>Zalogowano administratora: ' . $_POST["username"] . '</h2>';
                                    echo '<div class="dottedline"></div>';
                                    header("Refresh:0");
                                } else {
                                    echo '<h2>Błąd logowania. Spróbuj jeszcze raz</h2>';
                                    echo '<div class="dottedline"></div>';
                                    drukuj_form();
                                }
                            }
                            $conn->close();
                        } else {
                            ?>
							
                            <span class="bigtitle"> Logowanie administratora </span>
                            <div class="dottedline"></div>

                            <?php
                            drukuj_form();
                        }
                    }
                    ?>
	</article>
	
	<article class="spolecznosc">
		<a href="https://www.youtube.com/" class="spolecznosc-item"><img src="img/youtube.png" alt="youtube"></a>
		<a href="https://www.facebook.com/" class="spolecznosc-item"><img src="img/facebook.png" alt="facebook"></a>
		<a href="https://twitter.com/?lang=pl" class="spolecznosc-item"><img src="img/twitter.png" alt="twitter"></a>
		<a href="https://plus.google.com/" class="spolecznosc-item"><img src="img/google.png" alt="google"></i></a>
		<a href="https://plus.google.com/" class="spolecznosc-item"><img src="img/kontakt.png" alt="kontakt"><br/></a>
	</article>        
	<footer class="footer">Made by Sawicki Damian & Zimnowodzki Igor. Wszelkie prawa zastrzeżone &copy;</footer>
</div>
</body>
</html>