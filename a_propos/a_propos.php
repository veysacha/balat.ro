<?php
    session_start();
    // si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
    if (!isset($_SESSION['pseudo'])) {
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
    <link rel="stylesheet" href="a_propos.css">
    <title>A Propos</title>
</head>
<body>

        <div class="menu-nav">
            <nav class="navbar navbar-expand-lg bg-body-tertiary bg-white">
                <div class="container-fluid">
                    <div class="back_button">
                        <a href="../forum/forum.php"><img id="back" src="../Assets/img/back.png" alt="Retour"></a>
                    </div>
                    <img id="logo" src="../Assets/img/Logo_2_white.png" alt="logo" width="50" height="50">
                </div>
            </nav>
        </div>

        <div class="titre">
            <h1>A Propos</h1>
        </div>

        <div class="message">
            <p class="mess">
            Bienvenue sur notre site dédié au jeu captivant "Balatro", un univers où stratégie et chance se rencontrent dans un roguelike deckbuilder inspiré des mains de poker. Développé avec passion par LocalThunk et magnifiquement publié par Playstack, "Balatro" offre une expérience de jeu immersive qui nous a inspirés à créer cette plateforme.
            <br />
            <br />
            Notre mission est d'enrichir votre expérience de jeu en vous fournissant des outils innovants et une communauté vivante. Au cœur de notre site se trouve un forum dynamique, conçu pour être le lieu de rendez-vous privilégié des joueurs de "Balatro". 
            Que vous cherchiez à partager des stratégies, à poser des questions ou simplement à connecter avec d'autres passionnés, notre forum est l'endroit idéal pour échanger et s'entraider.
            <br />
            <br />
            Nous sommes également fiers de vous présenter notre calculateur de points unique en son genre. Cet outil est le fruit de notre travail sur l'algorithmie, conçu spécifiquement pour tester diverses combinaisons de jeu et optimiser vos stratégies. 
            Grâce à ce système, vous pouvez expérimenter avec différentes approches et affiner votre manière de jouer pour devenir un maître de "Balatro".
            <br />
            <br />
            Pour soutenir la croissance de notre communauté et la richesse de nos échanges, nous avons mis en place une base de données robuste. 
            Cette infrastructure nous permet de gérer efficacement les utilisateurs, leurs messages, leurs profils, ainsi que les différentes mécaniques du jeu.
            <br />
            <br />
            Notre objectif est de vous offrir une expérience utilisateur fluide et engageante, où chaque membre peut contribuer et bénéficier de la sagesse collective.
            <br />
            <br />
            Nous sommes une équipe de passionnés, engagés à enrichir votre expérience de "Balatro". Que vous soyez un joueur aguerri ou un nouveau venu curieux, notre site est fait pour vous. 
            <br />
            <br />
            Rejoignez-nous dans cette aventure et découvrez tout ce que "Balatro" et notre communauté ont à offrir.
            </p>
        </div>

</body>
</html>