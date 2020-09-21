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
    <h2> Zarezerwuj Stolik</h2>    
         <?php
                function drukuj_form() {
                    ?>
                    <div id="panel">

                        <form method="post">
                            Data rezerwacji:<br>
                            <input type="date" name="datar" required><br><br>
                            <input type="submit" name="szukaj">
                        </form>

                    </div>  
                    <?php
                }
				function drukuj_form2() {
                    ?>
                    <div id="panel">
                        <form method="post">						
                            <input type="submit" name="rezerwuj">
                        </form>

                    </div>  
                    <?php
                }
				
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                if (isset($_SESSION["user"])) 
				{
                    if (isset($_POST["szukaj"])) 
					{
                        $conn = new mysqli("localhost", "root", "", "stoliktu");
						$conn->set_charset("utf8");
                        if ($conn->connect_error) 
						{
                            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                        }
						$datar = new DateTime($_POST["datar"]);
                        $dzisiaj = new DateTime(date("Y-m-d"));
                        if ($datar < $dzisiaj) {
                            echo '<h2>Data zwrotu nie może być wcześniej niż dzisiaj! Spróbuj jeszcze raz</h2>';
                            echo '<div class="dottedline"></div>';
                            drukuj_form();
                        }else if (isset($_POST["datar"])) 
						{
							$_SESSION["datarez"] = $_POST["datar"];
							$datarez = $_POST["datar"];
							$sql = "SELECT * FROM stoliki AS s WHERE NOT EXISTS(SELECT * FROM rezerwacje AS r WHERE s.id_stolika=r.id_stolika AND data_rezerwacji = '$datarez')";						
							$result = $conn->query($sql);
							if ($result->num_rows > 0) 
							{
								echo '<table class="tablica" align="center">
									<tr>
										<th>Tytuł</th><th>Rezerwuj</th>
									</tr>
								';
								
								while ($row = $result->fetch_assoc()) {
									echo '<tr>'
									. '<td>' . $row["tytul"] . '</td>'
									. '<td><form method="post" action="fun_rezerwuj.php"><button type="submit" value="' . $row["id_stolika"] . '" name="rezerwuj" ><strong>Rezerwuj</strong></button></form></td>'
									. '</tr>';
								}
								echo '</tbody></table>';
							}else{
								echo "Brak wolnych miejsc. Wybierz inny termin!";
							}
                        }  
						else 
						{
                           echo '<div class="dottedline"></div>';
                        }
                    } 
					else {
                        ?>
                        <div class="dottedline"></div>
                        <?php
                        drukuj_form();
                    }
					
					
					
                } else {
                    ?>
                    <span class="bigtitle">Musisz zalogować się przed składaniem zamówienia! </span>
                    <div class="dottedline"></div>
                    <?php
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