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
                        <a href="../forum/forum.php"><img id="back" src="../Assets/img/back.png" alt="Retour"></a>
                    </div>
                    <img id="logo" src="../Assets/img/Logo_2_white.png" alt="logo" width="50" height="50">
                </div>
            </nav>
        </div>

        <!-- bouton pour modifier le profil -->
        <div class="bouton_modif">
            <a href="modifier_profil.php" class="btn btn-primary">Modifier mon profil</a>
        </div>

        <div class="titre">
            <h1>Profil de <?php echo $_SESSION['pseudo']; ?></h1>
        </div>

        <!-- récupération de la biographie de l'utilisateur si elle n'existe pas, afficher "aucune biographie" -->
        <?php
            $stmt = $conn->prepare("SELECT biographie FROM utilisateurs WHERE pseudo = :pseudo");
            $stmt->execute(['pseudo' => $_SESSION['pseudo']]);
            $bio = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($bio['biographie'] == NULL) {
                echo '<div class="container"><p>Aucune biographie</p></div>';
            } else {
                echo '<div class="container"><p>' . $bio['biographie'] . '</p></div>';
            }
        ?>

        <!-- récuperation des messages de l'utilisateur et l'afficher dans un tableau -->
        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Auteur</th>
                        <th scope="col">Message</th>
                        <th scope="col">Heure</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stmt = $conn->prepare("SELECT auteur, message, heure FROM messages WHERE auteur = :pseudo ORDER BY heure DESC");
                        $stmt->execute(['pseudo' => $_SESSION['pseudo']]);
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<tr>';
                            echo '<td>' . $row['auteur'] . '</td>';
                            echo '<td>' . $row['message'] . '</td>';
                            echo '<td>' . $row['heure'] . '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- récupère les id de la mains qui sont séparé par des virgules, les séparé et afficher les cartes correspondantes -->
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
                            $stmt = $conn->prepare("SELECT main_pref FROM utilisateurs WHERE pseudo = :pseudo");
                            $stmt->execute(['pseudo' => $_SESSION['pseudo']]);
                            $main = $stmt->fetch(PDO::FETCH_ASSOC);
                            $cartes = explode(',', $main['main_pref']);
                            foreach ($cartes as $carte) {
                                $stmt = $conn->prepare("SELECT chemin_img FROM cartes WHERE id = :id");
                                $stmt->execute(['id' => $carte]);
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                echo '<td><img src="../../' . $row['chemin_img'] . '" alt="image" width="50" height="70"></td>';
                            }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
        




</body>
</html>