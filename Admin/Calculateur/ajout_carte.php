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
    <link rel="stylesheet" href="ajout_carte.css">
    <title>Ajout de carte</title>
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

        <div class="titre">
            <h1>Ajouter une carte</h1>
        </div>

        <!-- formulaire bootstrap d'ajout de carte avec les champs "couleur de la carte", "valeur de la carte" et "point données par la carte -->
        <div class="container">
            <form action="ajout_carte.php" method="post">
                <div class="mb-3">
                    <label for="couleur" class="form-label">Couleur de la carte</label>
                    <input type="text" class="form-control" id="couleur" name="couleur" required>
                </div>
                <div class="mb-3">
                    <label for="valeurs" class="form-label">Valeur de la carte</label>
                    <input type="text" class="form-control" id="valeurs" name="valeurs" required>
                </div>
                <div class="mb-3">
                    <label for="point" class="form-label">Point données par la carte</label>
                    <input type="number" class="form-control" id="point" name="point" required>
                </div>
                <div class="mb-3">
                    <label for="chemin_img" class="form-label">Chemin de l'image</label>
                    <input type="text" class="form-control" id="chemin_img" name="chemin_img" required>
                    <br />
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </form>
        </div>

        <!-- script php pour ajouter le formulaire à la base de données dans la tables "cartes"-->
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $couleur = $_POST['couleur'];
                $valeur = $_POST['valeurs'];
                $point = $_POST['point'];
                $chemin_img = $_POST['chemin_img'];

                $stmt = $conn->prepare("INSERT INTO cartes (couleur, valeurs, point, chemin_img) VALUES (:couleur, :valeurs, :point, :chemin_img)");
                $stmt->execute(['couleur' => $couleur, 'valeurs' => $valeur, 'point' => $point, 'chemin_img' => $chemin_img]);
                header('Location: panel_admin.php');
            }

        ?>


</body> 
</html>