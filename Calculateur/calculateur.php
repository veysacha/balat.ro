<?php
    session_start();

    // Initialisation de la session pour les cartes
    if (!isset($_SESSION['selected_cards'])) {
        $_SESSION['selected_cards'] = [];
    }
    if (!isset($_SESSION['error'])) {
        $_SESSION['error'] = '';
    }
    
    // Gérer la réception des cartes
    if (isset($_POST['select_card'])) {
        if (in_array($_POST['select_card'], $_SESSION['selected_cards'])) {
            $_SESSION['error'] = "Cette carte a déjà été sélectionnée!";
        } elseif (count($_SESSION['selected_cards']) < 5) {
            $_SESSION['selected_cards'][] = $_POST['select_card'];
            $_SESSION['error'] = '';
            header("Location: calculateur.php"); // Redirection pour éviter le clonage par refresh
            exit; // Ne pas oublier d'ajouter exit après header pour stopper le script
        }
    }
    
    // Gestion du bouton de réinitialisation
    if (isset($_POST['reset'])) {
        $_SESSION['selected_cards'] = [];
        $_SESSION['error'] = '';
        header("Location: calculateur.php"); // Redirection pour réinitialiser proprement
        exit; // Arrêter le script après la redirection
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="calculateur.css">
    <title>Forum</title>
</head>
<body>
<div class="menu-nav">
            <nav class="navbar navbar-expand-lg bg-body-tertiary bg-white">
                <div class="container-fluid">
                    <div class="back_button">
                        <a href="forum.php"><img id="back" src="../Assets/img/back.png" alt="Retour"></a>
                    </div>
                    <img id="logo" src="../Assets/img/Logo_2_white.png" alt="logo" width="50" height="50">
                </div>
            </nav>
        </div>

        <!-- connexion à la base de données -->
        <?php
            $servername = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbname = "balatro";
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        ?>

        <div class="titre">
            <h1>Calculateur</h1>
        </div>

        <!-- niveau de la main -->
        <div class="container">
            <form action="calculateur.php" method="post">
                <div class="mb-3">
                    <label for="niveau" class="form-label">Niveau de la main</label>
                    <input type="number" class="form-control" id="niveau" name="niveau" min="0" required>
                </div>
            </form>
        </div>

        <!-- crée un tableau à 5 cases pour les cartes séléctionnées, chaque carte est affichée avec son image, si la case 1 est prise on affiche sur la carte 2 et ça jusqu'a 5 cartes grâce au bouton séléctionné de la liste en bas -->
        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Carte 1</th>
                        <th scope="col">Carte 2</th>
                        <th scope="col">Carte 3</th>
                        <th scope="col">Carte 4</th>
                        <th scope="col">Carte 5</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            for ($i = 0; $i < 5; $i++) {
                                echo "<td>";
                                if (isset($_SESSION['selected_cards'][$i])) {
                                    $stmt = $conn->prepare("SELECT * FROM cartes WHERE id = :id");
                                    $stmt->execute(['id' => $_SESSION['selected_cards'][$i]]);
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    echo "<img src='../../" . $row['chemin_img'] . "' alt='image' width='50' height='70'>";
                                }
                                echo "</td>";
                            }
                        ?>
                    </tr>
                </tbody>
            </table>

            <!-- bouton pour effacer les cartes séléctionnées du tableau -->
            <?php
                if (isset($_POST['reset'])) {
                    $_SESSION['selected_cards'] = [];
                    #refresh la page pour enlever les cartes
                    header("Refresh:0");
                }
            ?>
            <form action="calculateur.php" method="post">
                <button type="submit" name="reset" class="btn btn-primary">Effacer les cartes</button>
            </form>

            <!-- message d'erreur -->
            <div class="container">
                <?php
                if (!empty($_SESSION['error'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                }
                ?>
            </div>

            <br />
            <br />

            <!-- bouton vert centrer pour calculer les points -->
            <div class="container">
                <button type="submit" class="btn btn-success">Calculer les points</button>
            </div>



        <!-- affichage des cartes avec un bouton à coter pour les séléctionner puis les poster en php pour les afficher au dessus -->
        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Couleur</th>
                        <th scope="col">Valeur</th>
                        <th scope="col">Points</th>
                        <th scope="col">Image</th>
                        <th scope="col">Sélectionner</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stmt = $conn->prepare("SELECT * FROM cartes");
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['couleur'] . "</td>";
                            echo "<td>" . $row['valeurs'] . "</td>";
                            echo "<td>" . $row['point'] . "</td>";
                            echo "<td><img src='../../" . $row['chemin_img'] . "' alt='image' width='50' height='70'></td>";
                            #on envoie l'id de la carte séléctionnée, et on l'envoie en post pour l'afficher au dessus
                            echo "<td><form action='calculateur.php' method='post'><button type='submit' name='select_card' value='" . $row['id'] . "' class='btn btn-primary'>Sélectionner</button></form></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>


</body>
</html>