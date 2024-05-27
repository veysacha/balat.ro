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

<?php
    //récupère toute les informations de l'utilisateur avec le pseudo correspondant
    $stmt = $conn->prepare("SELECT * FROM utilisateurs WHERE pseudo = :pseudo");
    $stmt->execute(['pseudo' => $_GET['pseudo']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="profil_admin.css">
    <title>Profile - <?php echo htmlspecialchars($user['pseudo']); ?></title>
</head>
<body>

        <div class="menu-nav">
            <nav class="navbar navbar-expand-lg bg-body-tertiary bg-white">
                <div class="container-fluid">
                    <div class="back_button">
                        <a href="panel_admin.php"><img id="back" src="../Assets/img/back.png" alt="Retour"></a>
                    </div>
                    <img id="logo" src="../Assets/img/Logo_2_white.png" alt="logo" width="50" height="50">    
                    <div class="title_admin">
                        <h3>Panel Admin</h3>
                    </div>
                </div>
            </nav>
        </div>
        <!-- bouton delete user -->
        <div class="bouton">
            <a href="delete_user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger">Supprimer l'utilisateur</a>
        </div>

        <!-- pseudo de l'utilisateur -->
        <div class="titre">
            <h1>Profil de <?php echo $_GET['pseudo']; ?></h1>
        </div>

        <!-- récupération de la biographie de l'utilisateur si elle n'existe pas, afficher "aucune biographie" -->
        <?php
            $stmt = $conn->prepare("SELECT biographie FROM utilisateurs WHERE pseudo = :pseudo");
            $stmt->execute(['pseudo' => $_GET['pseudo']]);
            $bio = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($bio['biographie'] == NULL) {
                echo '<div class="container"><p>Aucune biographie</p></div>';
            } else {
                echo '<div class="container"><p>' . $bio['biographie'] . '</p></div>';
            }
        ?>
        
        <!-- récupération des messages de l'utilisateur et l'afficher dans un tableau -->
        <div class="messages">
            <h3>Messages de <?php echo $_GET['pseudo']; ?></h3>
            <table class="table">
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
                        $stmt->execute(['pseudo' => $_GET['pseudo']]);
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

        <!-- récupère les id de la mains qui sont séparé par des virgules, les séparé et afficher les cartes correspondantes si elles existent sinon afficher "pas de cartes préférées" -->
        <div class="cartes">
            <h3>Cartes préférées de <?php echo $_GET['pseudo']; ?></h3>
            <div class="container">
                <?php
                    $stmt = $conn->prepare("SELECT main_pref FROM utilisateurs WHERE pseudo = :pseudo");
                    $stmt->execute(['pseudo' => $_GET['pseudo']]);
                    $cartes = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($cartes['main_pref'] == NULL) {
                        echo '<p>Pas de cartes préférées</p>';
                    } else {
                        $cartes = explode(",", $cartes['main_pref']);
                        foreach ($cartes as $carte) {
                            $stmt = $conn->prepare("SELECT * FROM cartes WHERE id = :id");
                            $stmt->execute(['id' => $carte]);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            echo "<img src='../../" . $row['chemin_img'] . "' alt='image' width='50' height='70'>";
                        }
                    }
                ?>
            </div>
        </div>





</body>
</html>