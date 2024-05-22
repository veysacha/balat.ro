<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="forum.css">
    <title>Forum</title>
</head>
<body>
    <!-- menu-nav -->
    <div class="menu-nav">
        <nav class="navbar navbar-expand-lg bg-body-tertiary bg-white">
            <div class="container-fluid">
                <img src="../Assets/img/Logo_2_white.png" alt="logo" width="50" height="50">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Forum</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Mon Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Calculateur</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../Deconnexion.php">Déconnexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../a_propos/a_propos.php">à Propos</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- bonjour user php -->
    <div class="bonjour">
        <h3>Bonjour <?php echo $_SESSION['pseudo']; ?></h3>
    </div>
    <br />
    <div class="titleGeneral">
        <h3>Général</h3>
    </div>
    <!-- forum -->
    <div class="forum">
        <div class="container">
            <div class="messages-container">
                <?php
                    $servername = "localhost";
                    $dbUsername = "root";
                    $dbPassword = "";
                    $dbname = "balatro";
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    $stmt = $conn->prepare("SELECT auteur, message, heure FROM messages ORDER BY heure DESC");
                    $stmt->execute();

                    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($messages as $message) {
                    echo "<div class='message'><strong>" . htmlspecialchars($message['auteur']) . "</strong>: " .
                    htmlspecialchars($message['message']) . "<br>" .
                    "<small>Posté le: " . $message['heure'] . "</small></div>";
                    }
                ?>
            </div>



            <form action="forum.php" method="post">
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>


    <!-- connexion bdd -->
    <?php
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "balatro";

        #recuperation de l'utilisateur qui vient de se connecter
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        ?>

    <?php 
        if (!isset($_SESSION['pseudo'])) {
            // Redirige l'utilisateur non connecté
            header('Location: signin.php');
            exit();
        }
        
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['message'])) {
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "balatro";
        
            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
                $stmt = $conn->prepare("INSERT INTO messages (auteur, message) VALUES (:auteur, :message)");
                $stmt->execute([
                    'auteur' => $_SESSION['pseudo'],
                    'message' => strip_tags($_POST['message'])
                ]);
                header("Location: forum.php");
                exit();
            } catch(PDOException $e) {
                echo "Erreur: " . $e->getMessage();
            }
            $conn = null;
        }
        ?>


</body>
</html>