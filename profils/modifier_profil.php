<?php
    session_start();
    // si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
    if (!isset($_SESSION['pseudo'])) {
        header('Location: ../SignIn/signin.php');
        exit();
    }

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
            header("Location: modifier_profil.php"); // Redirection pour éviter le clonage par refresh
            exit; // Ne pas oublier d'ajouter exit après header pour stopper le script
        }
    }
    
    // Gestion du bouton de réinitialisation
    if (isset($_POST['reset'])) {
        $_SESSION['selected_cards'] = [];
        $_SESSION['error'] = '';
        header("Location: modifier_profil.php"); // Redirection pour réinitialiser proprement
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
    <link rel="stylesheet" href="profils.css">
    <title>Profil de <?php echo $_SESSION['pseudo']; ?></title>
</head>
<body>

    <!-- connexion à la base de données -->
    <?php
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "balatro";
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    ?>

        <div class="menu-nav">
            <nav class="navbar navbar-expand-lg bg-body-tertiary bg-white">
                <div class="container-fluid">
                    <div class="back_button">
                        <a href="profils.php"><img id="back" src="../Assets/img/back.png" alt="Retour"></a>
                    </div>
                    <img id="logo" src="../Assets/img/Logo_2_white.png" alt="logo" width="50" height="50">
                </div>
            </nav>
        </div>


        <br />
    <!-- pseudo du compte dans un formulaire pour pouvoir le modifier -->
    <div class="container">
    <form action="modifier_profil.php" method="post">
        <div class="mb-3">
            <label for="pseudo" class="form-label">Pseudo</label>
            <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?php echo $_SESSION['pseudo']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="biographie" class="form-label">Biographie</label>
            <textarea class="form-control" id="biographie" name="biographie" rows="3"></textarea>
        </div>
        <button type="submit" name="action" value="update_profile" class="btn btn-primary">Modifier</button>
    </form>
    </div>

    <?php 
        //enregistrement des modifications du profil dans la base de données
        if (isset($_POST['action']) && $_POST['action'] == 'update_profile') {
            $stmt = $conn->prepare("UPDATE utilisateurs SET pseudo = :pseudo, biographie = :biographie WHERE pseudo = :old_pseudo");
            $stmt->execute(['pseudo' => $_POST['pseudo'], 'biographie' => $_POST['biographie'], 'old_pseudo' => $_SESSION['pseudo']]);
            $_SESSION['pseudo'] = $_POST['pseudo'];
            header("Location: modifier_profil.php");
            exit;
        }
    ?>

    <!-- tableau des messages de l'utilisateur et un bouton pour les supprimer -->
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Message</th>
                    <th scope="col">Date</th>
                    <th scope="col">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $stmt = $conn->prepare("SELECT id, message, heure FROM messages WHERE auteur = :pseudo ORDER BY heure DESC");
                    $stmt->execute(['pseudo' => $_SESSION['pseudo']]);
                    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($messages as $message) {
                        echo "<tr><td>" . htmlspecialchars($message['message']) . "</td>" .
                        "<td>" . $message['heure'] . "</td>" .
                        "<td><a href='delete_message.php?id=" . $message['id'] . "'><img src='../Assets/img/delete-16.png' alt='Supprimer'></a></td></tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <br />
    <br />

    <!-- titre main preferer -->
    <div class="container">
        <h3>Main préférée</h3>
    </div>
    <br />

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
            <form action="modifier_profil.php" method="post">
                <button type="submit" name="reset" class="btn btn-primary">Effacer les cartes</button>
            </form>

            <?php 
                //enregistrement du chemin des cartes séléctionnées dans la base de données
                if (isset($_POST['save'])) {
                    $stmt = $conn->prepare("UPDATE utilisateurs SET main_pref = :main_pref WHERE pseudo = :pseudo");
                    $stmt->execute(['main_pref' => implode(',', $_SESSION['selected_cards']), 'pseudo' => $_SESSION['pseudo']]);
                    header("Location: modifier_profil.php");
                    exit;
                }
            ?>

            <!-- bouton pour enregistrer les cartes séléctionnées dans la base de données -->
            <form action="modifier_profil.php" method="post">
                <button type="submit" name="save" class="btn btn-success">Enregistrer</button>
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
                            echo "<td><form action='modifier_profil.php' method='post'><button type='submit' name='select_card' value='" . $row['id'] . "' class='btn btn-primary'>Sélectionner</button></form></td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>


</body>
</html>