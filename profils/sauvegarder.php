<?php 
    session_start();

    //vérifier si la personne est connectée sinon le rediriger vers la page de connexion
    if (!isset($_SESSION['pseudo'])) {
        header('Location: ../SignIn/signin.php');
        exit();
    }

    //connexion à la base de données
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "balatro";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //récupération des informations de modifier_profil.php comme le pseudo, la biographie et les cartes séléctionnées pour les sauvegarder dans la base de données grâce à un try catch sinon affiche l'erreur php
    if (isset($_POST['save'])) {
        $pseudo = $_SESSION['pseudo'];
        $bio = $_POST['bio'];
        $cards = implode(',', $_SESSION['selected_cards']);

        try {
            $stmt = $conn->prepare("UPDATE utilisateurs SET bio = :bio, cards = :cards WHERE pseudo = :pseudo");
            $stmt->execute(['bio' => $bio, 'cards' => $cards, 'pseudo' => $pseudo]);
            echo "<script>alert('Profil sauvegardé');</script>";
            echo "<script>window.location.href = 'modifier_profil.php';</script>";
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }

?>