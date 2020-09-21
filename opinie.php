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
    <h2>Ocena klientów</h2>
	<?php
    function drukuj_form() {
    ?>
    <form method="post" action="oddaj_glos.php">
		<input type="radio" name="ocena" value="1">1<br>
		<input type="radio" name="ocena" value="2">2<br>
		<input type="radio" name="ocena" value="3">3<br>
		<input type="radio" name="ocena" value="4">4<br>
		<input type="radio" name="ocena" value="5">5<br><br>
		<input type="submit" name="glos" value="zagłosuj">
	</form>
	<?php
	}
			if (isset($_SESSION["user"])) 
			{
                $conn = new mysqli("localhost", "root", "", "stoliktu");
                $conn->set_charset("utf8");
                if ($conn->connect_error) {
                    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                }
				$sql = "select id_klienta from klienci where login = '" . $_SESSION["user"] . "'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
					while ($row = $result->fetch_assoc()) {
						$id = $row["id_klienta"];
                    }
					
					$sql1 = "select * from glosy where id_klienta = '" . $id  . "'";
					$rezultat=$conn->query($sql1);
					$ilosc_u = $rezultat->num_rows;
					if ($ilosc_u > 0)
					{
                        try
						{
							$conn = new mysqli("localhost", "root", "", "stoliktu");
							if ($conn->connect_error) {
								die("Błąd połączenia z bazą danych: " . $conn->connect_error);
							}
							else
							{
								$sql="SELECT * FROM glosy WHERE ocena ='1'";
								$rezultat=$conn->query($sql);
								$ilosc = $rezultat->num_rows;
								echo 'Ocenę 1 wystawiło '.$ilosc.' osób<br><br>';
								
								$sql="SELECT * FROM glosy WHERE ocena ='2'";
								$rezultat=$conn->query($sql);
								$ilosc = $rezultat->num_rows;
								echo 'Ocenę 2 wystawiło '.$ilosc.' osób<br><br>';
								
								$sql="SELECT * FROM glosy WHERE ocena ='3'";
								$rezultat=$conn->query($sql);
								$ilosc = $rezultat->num_rows;
								echo 'Ocenę 3 wystawiło '.$ilosc.' osób<br><br>';
								
								$sql="SELECT * FROM glosy WHERE ocena ='4'";
								$rezultat=$conn->query($sql);
								$ilosc = $rezultat->num_rows;
								echo 'Ocenę 4 wystawiło '.$ilosc.' osób<br><br>';
								
								$sql="SELECT * FROM glosy WHERE ocena ='5'";
								$rezultat=$conn->query($sql);
								$ilosc = $rezultat->num_rows;
								echo 'Ocenę 5 wystawiło '.$ilosc.' osób<br><br>';
							}
							$conn->close();
						}
						catch(Exception $e)
						{
							echo '<span style="color:red">Error!</span>';
							echo '<br />Info:'.$e;
						}
                    }else{
						drukuj_form();
					}
                }
            }
			else
			{
				try
				{
					$conn = new mysqli("localhost", "root", "", "stoliktu");
					if ($conn->connect_error) {
						die("Błąd połączenia z bazą danych: " . $conn->connect_error);
					}
					else
					{
						$sql="SELECT * FROM glosy WHERE ocena ='1'";
						$rezultat=$conn->query($sql);
						$ilosc = $rezultat->num_rows;
						echo 'Ocenę 1 wystawiło '.$ilosc.' osób<br><br>';
						
						$sql="SELECT * FROM glosy WHERE ocena ='2'";
						$rezultat=$conn->query($sql);
						$ilosc = $rezultat->num_rows;
						echo 'Ocenę 2 wystawiło '.$ilosc.' osób<br><br>';
						
						$sql="SELECT * FROM glosy WHERE ocena ='3'";
						$rezultat=$conn->query($sql);
						$ilosc = $rezultat->num_rows;
						echo 'Ocenę 3 wystawiło '.$ilosc.' osób<br><br>';
						
						$sql="SELECT * FROM glosy WHERE ocena ='4'";
						$rezultat=$conn->query($sql);
						$ilosc = $rezultat->num_rows;
						echo 'Ocenę 4 wystawiło '.$ilosc.' osób<br><br>';
						
						$sql="SELECT * FROM glosy WHERE ocena ='5'";
						$rezultat=$conn->query($sql);
						$ilosc = $rezultat->num_rows;
						echo 'Ocenę 5 wystawiło '.$ilosc.' osób<br><br>';
					}
					$conn->close();
				}
				catch(Exception $e)
				{
					echo '<span style="color:red">Error!</span>';
					echo '<br />Info:'.$e;
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