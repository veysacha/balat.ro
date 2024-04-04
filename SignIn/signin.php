<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>SignIn - Balatro</title>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <img src="../Assets/img/logo_1_white.png" alt="Balatro">
    </div>
    <!-- glass -->
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


        <!-- php -->
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Vérifiez si les champs ne sont pas vides
                if (!empty($_POST['pseudo']) && !empty($_POST['password'])) {
                    // Effectuer la connexion à la base de données
                    $servername = "localhost";
                    $dbUsername = "root";
                    $dbPassword = ""; // Assurez-vous que c'est le mot de passe de votre base de données, pas celui de l'utilisateur
                    $dbname = "balatro";

                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        // Sanitisation des entrées
                        $pseudo = htmlspecialchars(strip_tags($_POST['pseudo']));
                        // Préparation de la requête pour récupérer le mot de passe hashé de l'utilisateur
                        $stmt = $conn->prepare("SELECT mot_de_passe FROM utilisateurs WHERE pseudo = :pseudo");
                        $stmt->execute(['pseudo' => $pseudo]);
                        if ($stmt->rowCount() > 0) {
                            $user = $stmt->fetch(PDO::FETCH_ASSOC);
                            $hashed_password = $user['mot_de_passe'];
                            if (password_verify($_POST['password'], $hashed_password)) {
                                echo "<div class='alert alert-success' role='alert'>Connexion réussie</div>";
                            } else {
                                echo "<div class='alert alert-danger' role='alert'>Pseudo ou mot de passe incorrect</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>Pseudo ou mot de passe incorrect</div>";
                        }
                    } catch (PDOException $e) {
                        echo "Erreur : " . $e->getMessage();
                    }
                    // Fermeture de la connexion à la base de données
                    $conn = null;
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Veuillez remplir tous les champs</div>";
                }
            }
        ?>
</body>
</html>