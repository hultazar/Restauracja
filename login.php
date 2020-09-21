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
	<h2> Logowanie</h2>
	<br>
            <?php
                function drukuj_form() {
                    ?>
                    <div class="panel">
                        <form method="post">
                            <br><br>Login:<br>
                            <input type="text" name="username" required><br>
							<br>
                            Hasło:<br>
                            <input type="password" name="psw" required><br><br>

                            <input type="submit" name="zaloguj">
							<br><br>
							<a href="pomoc.php">Zapomniałem hasła</a>

                        </form>
                        <?php
                    }

                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    if (isset($_SESSION["user"]) || isset($_SESSION["admin"])) {
                        ?>
                        <div class="dottedline"></div>
                        <div id="panel">
                           <?php echo 'Jesteś zalogowany jako '.$_SESSION["user"] .'!' ?>
                        </div>
                        <?php
                    } else {
                        if (isset($_POST["zaloguj"])) {
                            $conn = new mysqli("localhost", "root", "", "stoliktu");
                            $conn->set_charset("utf8");
                            if ($conn->connect_error) {
                                die("Błąd połączenia z bazą danych: " . $conn->connect_error);
                            }
                            if (!isset($_POST["username"]) || !isset($_POST["psw"])) 
							{
                                echo '<h2>Nie wszystkie pola formularza zostały wypełnione!</h2>';
                                echo '<div class="dottedline"></div>';
                                drukuj_form();
                            } 
							else 
							{
                                $sql = "select * from klienci where login = '" . $_POST["username"] . "' and haslo = '" . hash('sha256', $_POST["psw"]) . "'";
                                $result = $conn->query($sql);
                                if ($result->num_rows > 0) 
								{
                                    $_SESSION["user"] = $_POST["username"];
                                    echo '<h2>Zalogowano użytkownika ' . $_POST["username"] . '</h2>';
									header('Location: index.php');
                                } 
								else 
								{
									$sql = "select * from administratorzy where login = '" . $_POST["username"] . "' and haslo = '" . hash('sha256', $_POST["psw"]) . "'";
									$result = $conn->query($sql);
									if ($result->num_rows > 0) 
									{
										$_SESSION["admin"] = $_POST["username"];
										echo '<h2>Zalogowano administratora ' . $_POST["username"] . '</h2>';
										header('Location: index.php');
									}else{
										echo '<h2>Podano złe dane! Spróbuj ponownie.</h2>';
									}
                                }
                            }
                            $conn->close();
                        } else {
                            ?>
                            <span class="bigtitle"> Zalogować się możesz tylko po wcześniejszej rejestracji. </span>
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