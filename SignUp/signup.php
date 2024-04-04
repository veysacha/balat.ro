<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signup.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>SignUp - Balatro</title>
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
                        <h1>S'inscrire</h1>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST">
                            <div class="mb-3">
                                <label for="pseudo" class="form-label">Pseudo</label>
                                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" action="POST" class="btn btn-primary">S'inscrire</button>
                        </form>
                        <p>Déjà inscris ? <a href="../SignUp/signup.php">Se connecter</a></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- php -->
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Vérifiez si les champs ne sont pas vides
                if (!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password'])) {
                    // Effectuer la connexion à la base de données
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "balatro";

                    try {
                        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        // Sanitisation des entrées
                        $pseudo = htmlspecialchars(strip_tags($_POST['pseudo']));
                        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                        $password = htmlspecialchars(strip_tags($_POST['password']));
                        // Hashage du mot de passe
                        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                        // Préparation de la requête avec les placeholders
                        $sql = "INSERT INTO utilisateurs (pseudo, email, mot_de_passe) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        // Exécution de la requête avec les valeurs
                        $stmt->execute([$pseudo, $email, $hashed_password]);
                        echo "Nouvelle utilisateur créé avec succès";
                    } catch (PDOException $e) {
                        echo "Erreur: " . $e->getMessage();
                    }
                } else {
                    // Message d'erreur si tous les champs ne sont pas remplis
                    echo "Tous les champs doivent être remplis.";
                }
            }
?>

</body>
</html>