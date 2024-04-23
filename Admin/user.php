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
    <title>gestion - user</title>
    <link rel="stylesheet" href="user.css">
</head>
<body>
    <div class="titleForum">
        <h3>Gestion des utilisateurs</h3>
    </div>
    <br />

    <?php
        // Connexion à la base de données
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "balatro";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Pagination
        $perPage = 30;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;

        // Préparation de la requête pour obtenir les utilisateurs selon la page
        $stmt = $conn->prepare("SELECT id, pseudo, email FROM utilisateurs ORDER BY pseudo LIMIT :offset, :perPage");
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Affichage des utilisateurs
        foreach ($users as $user) {
            echo "<div class='user'>
                <a href='profil_admin.php?id=" . $user['id'] . "'><strong>" . htmlspecialchars($user['pseudo']) . "</strong></a> - " .
                htmlspecialchars($user['email']) . " " .
                "<a href='delete_user.php?id=" . $user['id'] . "'><img id='img_delete' src='../Assets/img/delete-16.png' alt='Supprimer'></a>
                </div>
                <hr>";
        }

        // Calcul du nombre total d'utilisateurs pour la pagination
        $totalStmt = $conn->prepare("SELECT COUNT(*) FROM utilisateurs");
        $totalStmt->execute();
        $total = $totalStmt->fetchColumn();
        $totalPages = ceil($total / $perPage);

        // Affichage des liens de pagination
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='user.php?page=$i'>$i</a> ";
        }
    ?>


</body>
</html>
