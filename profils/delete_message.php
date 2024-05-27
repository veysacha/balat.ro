<?php 
    session_start();

    //vérifier si la personne est connectée sinon le rediriger vers la page de connexion
    if (!isset($_SESSION['pseudo'])) {
        header('Location: ../SignIn/signin.php');
        exit();
    }

    //connecion à la base de données
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "balatro";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //récupération de l'id du message à supprimer
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        //préparation et exécution de la requête de suppression
        $stmt = $conn->prepare("DELETE FROM messages WHERE id = :id");
        $stmt->execute(['id' => $id]);

        //message de confirmation et redirection
        echo "<script>alert('Message supprimé');</script>";
        echo "<script>window.location.href = 'modifier_profil.php';</script>"; // Remplacez 'index.php' par la page sur laquelle vous souhaitez rediriger après la suppression
    } else {
        echo "Aucun ID fourni pour la suppression";
    }
?>
    