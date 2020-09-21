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

                function drukuj_form() {
                    ?>
                    <div class="panel">

                        <form method="post">
                            Login:<br>
                            <input type="text" name="username" required><br><br>
                            Data urodzenia:<br>
                            <input type="date" name="bday" required><br><br>
                            Adres  email:<br>
                            <input type="email" name="mail" required><br><br>
                            Nowe hasło:<br>
                            <input type="password" name="psw" required><br><br>
                            Potwierdź nowe hasło:<br>
                            <input type="password" name="psw1" required><br><br>
							<br>
                            <input type="submit" name="zaloguj"><br>

                        </form>
                    </div>
                    <?php
                }

                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                if (isset($_SESSION["user"])) {
                    ?>
                    <span class="bigtitle"> Musisz wylogować się przez zmianą hasła!</span>
                    <div class="dottedline"></div>
                    <?php
                } else {
                    if (isset($_POST["zaloguj"])) {
                        $conn = new mysqli("localhost", "root", "", "stoliktu");
                        $conn->set_charset("utf8");
                        if ($conn->connect_error) {
                            die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                        }
                        if (!isset($_POST["username"]) || !isset($_POST["bday"]) || !isset($_POST["mail"]) || !isset($_POST["psw"]) || !isset($_POST["psw1"])) {
                            echo '<h2>Nie wszystkie pola formularza zostały wypełnione!</h2>';
                            drukuj_form();
                        } else {
                            if ($_POST["psw"] !== $_POST["psw1"]) {
                                echo '<h2>Wprowadzone hasła są różne!</h2>';
                            } else {
                                $sql = "update klienci set haslo = '" . hash('sha256', $_POST["psw"]) . "' "
                                        . "where login = '" . $_POST["username"] . "' "
                                        . "and email = '" . $_POST["mail"] . "' "
                                        . "and data_urodzenia = '" . $_POST["bday"] . "'";
                                if ($conn->query($sql) === TRUE) {
                                    if ($conn->affected_rows > 0) {
                                        echo "<h2>Hasło zostało zmienione. Proszę zalogować się przy pomocy nowego hasła </h2>";
                                        echo '<div class="dottedline"></div>';
                                    } else {
                                        echo "<h2>Wprowadzono niepoprawne dane. Hasło nie zostało zmienione! </h2>";
                                        echo '<div class="dottedline"></div>';
                                        drukuj_form();
                                    }
                                } else {
                                    echo "Error: " . $sql . "<br>" . $conn->error;
                                }
                            }
                        }
                        $conn->close();
                    } else {
                        ?>
						<br>
                        <span class="bigtitle">Zmiana hasła</span>
						<br><br>
                        <div class="dottedline"></div>
                        <?php
                        drukuj_form();
                    }
                }
                ?>
                <br/><br/>
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