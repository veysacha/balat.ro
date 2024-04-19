<?php
session_start(); // Démarrer la session au début
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>SignIn - Balatro</title>
</head>
<body>
    <div class="header">
        <img src="../Assets/img/logo_1_white.png" alt="Balatro">
    </div>
    <div class="glass">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="glass-content">
                        <h1>Connexion</h1>
                        <form action="signin.php" method="post">
                            <div class="mb-3">
                                <label for="pseudo" class="form-label">Pseudo</label>
                                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Connexion</button>
                        </form>
                        <p>Pas de compte ? <a href="../SignUp/signup.php">S'inscrire</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST['pseudo']) && !empty($_POST['password'])) {
                $servername = "localhost";
                $dbUsername = "root";
                $dbPassword = "";
                $dbname = "balatro";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $pseudo = htmlspecialchars(strip_tags($_POST['pseudo']));
                    $stmt = $conn->prepare("SELECT mot_de_passe FROM utilisateurs WHERE pseudo = :pseudo");
                    $stmt->execute(['pseudo' => $pseudo]);

                    if ($stmt->rowCount() > 0) {
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);
                        $hashed_password = $user['mot_de_passe'];

                        if (password_verify($_POST['password'], $hashed_password)) {
                            // Stocker le pseudo de l'utilisateur dans la session
                            $_SESSION['pseudo'] = $pseudo;
                            echo "<div class='alert alert-success' role='alert'>Connexion réussie</div>";
                            // si l'utilisateur à 1 dans le champs admin, il est redirigé vers la page admin.php sinon il est redirigé vers la page forum.php
                            $stmt = $conn->prepare("SELECT admin FROM utilisateurs WHERE pseudo = :pseudo");
                            $stmt->execute(['pseudo' => $pseudo]);
                            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($admin['admin'] == 1) {
                                header("Location: ../Admin/panel_admin.php");
                            } else {
                                header("Location: ../Forum/forum.php");
                            }
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>Pseudo ou mot de passe incorrect</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Pseudo ou mot de passe incorrect</div>";
                    }
                } catch (PDOException $e) {
                    echo "Erreur : " . $e->getMessage();
                }
                $conn = null;
            } else {
                echo "<div class='alert alert-danger' role='alert'>Veuillez remplir tous les champs</div>";
            }
        }
    ?>
</body>
</html>
