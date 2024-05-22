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
    <title>Supprimé</title>
</head>
<body>
    <!-- récupère l'id de l'utilisateur puis le supprime avec une requête SQL et un texte de confirmation -->
    <?php
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "balatro";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Récupération de l'ID de l'utilisateur à supprimer
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Préparation et exécution de la requête de suppression
            $stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id = :id");
            $stmt->execute(['id' => $id]);

            // Message de confirmation et redirection
            echo "<script>alert('Utilisateur supprimé');</script>";
            echo "<script>window.location.href = 'user.php';</script>"; // Remplacez 'index.php' par la page sur laquelle vous souhaitez rediriger après la suppression
        } else {
            echo "Aucun ID fourni pour la suppression";
        }
    ?>

<p>utilisateur supprimé</p>

</body>
</html>