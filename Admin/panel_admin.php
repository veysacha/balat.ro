<?php
    session_start();
    //verifier si le champs admin de l'utilisateur retourne 0 rediriger vers signin.php sinon continuer
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "balatro";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT admin FROM utilisateurs WHERE pseudo = :pseudo");
    $stmt->execute(['pseudo' => $_SESSION['pseudo']]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($admin['admin'] == 0) {
        header('Location: ../SignIn/signin.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel_admin</title>
</head>
<body>

    <!-- menu navigation -->
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
                                <a class="nav-link" href="#">Déconnexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">à Propos</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

</body>
</html>