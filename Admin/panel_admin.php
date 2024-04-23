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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="panel_admin.css">
    <title>Panel_admin</title>
</head>
<body>

    <!-- menu navigation -->
    <div class="menu-nav">
            <nav class="navbar navbar-expand-lg bg-body-tertiary bg-white">
                <div class="container-fluid">
                    <img src="../Assets/img/Logo_2_white.png" alt="logo" width="50" height="50">    
                    <div class="title_admin">
                        <h3>Panel Admin</h3>
                    </div>
                </div>
            </nav>
        </div>

        <!-- titre Gestion du forum -->
        <div class="titleForum">
            <h3>Gestion du forum</h3>
        </div>

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

                $stmt = $conn->prepare("SELECT id, auteur, message, heure FROM messages ORDER BY heure DESC");
                $stmt->execute();

                $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($messages as $message) {
                    echo "<div class='message'><strong>" . htmlspecialchars($message['auteur']) . "</strong>: " .
                    htmlspecialchars($message['message']) . "<br>" .
                    "<small>Posté le: " . $message['heure'] . "</small> " .
                    "<a href='delete.php?id=" . $message['id'] . "'><img id='img_delete' src='../Assets/img/delete-16.png' alt='Supprimer'></a></div>";
                }
            ?>

            </div>


            <form action="panel_admin.php" method="post">
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>

    <?php
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "balatro";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_POST['message'])) {
            $stmt = $conn->prepare("INSERT INTO messages (auteur, message, heure) VALUES (:auteur, :message, :heure)");
            $stmt->execute(['auteur' => $_SESSION['pseudo'], 'message' => $_POST['message'], 'heure' => date('Y-m-d H:i:s')]);
            header('Location: panel_admin.php');
            exit();
        }
    ?>

    <div class="titleForum">
        <h3>Gestion des utilisateurs</h3>
    </div>

    <div class="container">
        <div class="users-container">
            <?php
                // Préparation de la requête pour obtenir les 10 premiers utilisateurs
                $stmt = $conn->prepare("SELECT id, pseudo, email FROM utilisateurs ORDER BY pseudo LIMIT 10");
                $stmt->execute();

                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($users as $user) {
                    echo "<div class='user'>
                        <a href='profil_admin.php?id=" . $user['id'] . "'><strong>" . htmlspecialchars($user['pseudo']) . "</strong></a> - " .
                        htmlspecialchars($user['email']) . " " .
                        "<a href='delete_user.php?id=" . $user['id'] . "'><img id='img_delete' src='../Assets/img/delete-16.png' alt='Supprimer'></a>
                        </div>
                        <hr>";
                }
            ?>
            <!-- Bouton pour afficher tous les utilisateurs -->
            <a href="user.php" class="btn btn-primary">Voir tous les utilisateurs</a>
        </div>
    </div>

    <div class="titleForum">
        <h3>Gestion du calculateur</h3>
    </div>

    <!-- bouton pour rediriger vers la page de gestion du calculateur -->
    <div class="bouton">
        <a href="../Calculateur/calculateur.php" class="btn btn-primary">Gestion du calculateur</a>
    </div>


</body>
</html>