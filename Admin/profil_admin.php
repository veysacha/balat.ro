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

<?php
    //récupère toute les informations de l'utilisateur avec l'id correspondant
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="profil_admin.css">
    <title>Profile - <?php echo htmlspecialchars($user['pseudo']); ?></title>
</head>
<body>

        <div class="menu-nav">
            <nav class="navbar navbar-expand-lg bg-body-tertiary bg-white">
                <div class="container-fluid">
                    <div class="back_button">
                        <a href="panel_admin.php"><img id="back" src="../Assets/img/back.png" alt="Retour"></a>
                    </div>
                    <img id="logo" src="../Assets/img/Logo_2_white.png" alt="logo" width="50" height="50">    
                    <div class="title_admin">
                        <h3>Panel Admin</h3>
                    </div>
                </div>
            </nav>
        </div>
        <div class="bouton_supp">
            <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger">Supprimer l'utilisateur</a>
        </div>

        <div class="nom_profil">
            <h1 class="pseudo"><?php echo htmlspecialchars($user['pseudo']); ?></h1>
        </div>
        <div class="biographie">
            <h3 class="titre-bio">Bio</h3>
            <div class="container"
                <p class="bio"><?php if ($user['biographie'] == "") { echo "Pas de biographie"; } else { echo htmlspecialchars($user['biographie']); } ?></p>
            </div>
        </div>
        <div class="message_envoye">
            <!-- si dans la tables messages, il y a un ou des messages ou le nom de l'auteur correspond au nom du profil, on affiche, sinon on affiche "pas de message posté"-->
            <h3 class="titre-message">Messages postés</h3>
            <div class="container">
                <?php
                    $stmt = $conn->prepare("SELECT id, auteur, message, heure FROM messages WHERE auteur = :auteur ORDER BY heure DESC");
                    $stmt->execute(['auteur' => $user['pseudo']]);
                    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if ($messages) {
                        foreach ($messages as $message) {
                            echo '<div class="message">';
                            echo '<p class="auteur">Auteur: ' . htmlspecialchars($message['auteur']) . '</p>';
                            echo '<p class="message">' . htmlspecialchars($message['message']) . '</p>';
                            echo '<p class="heure">Posté le: ' . htmlspecialchars($message['heure']) . '</p>';
                            echo '______________________________';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class="no_message">Pas de message posté</p>';
                    }
                ?>
        </div>
        
    
</body>
</html>