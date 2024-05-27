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
    <link rel="stylesheet" href="gestion_calculateur.css">
    <title>Gestion du calculateur</title>
</head>
<body>

        <div class="menu-nav">
            <nav class="navbar navbar-expand-lg bg-body-tertiary bg-white">
                <div class="container-fluid">
                    <div class="back_button">
                        <a href="../panel_admin.php"><img id="back" src="../../Assets/img/back.png" alt="Retour"></a>
                    </div>
                    <img id="logo" src="../../Assets/img/Logo_2_white.png" alt="logo" width="50" height="50">    
                    <div class="title_admin">
                        <h3>Panel Admin</h3>
                    </div>
                </div>
            </nav>
        </div>

        <div class="bouton">
            <a href="ajout_carte.php" class="btn btn-primary">Ajouter une carte</a>
        </div>

        <!-- affiche les différentes cartes dans un tableau grâce au chemin des img depuis la base de données de la tables cartes qu'on a rentrée depuis ajout_carte.php -->
        <div class="container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Couleur</th>
                        <th scope="col">Valeur</th>
                        <th scope="col">Points</th>
                        <th scope="col">Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $stmt = $conn->prepare("SELECT * FROM cartes");
                        $stmt->execute();
                        $cartes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($cartes as $carte) {
                            echo "<tr>
                                <td>" . htmlspecialchars($carte['couleur']) . "</td>
                                <td>" . htmlspecialchars($carte['valeurs']) . "</td>
                                <td>" . htmlspecialchars($carte['point']) . "</td>
                                <td><img src='../../" . htmlspecialchars($carte['chemin_img']) . "' alt='carte' width='50' height='70'></td>
                                <td><a href='delete_carte.php?id=" . $carte['id'] . "' class='btn btn-danger'>Supprimer</a></td>
                            </tr>";
                        }
                    ?>
                </tbody>
            </table>

</body>
</html>