<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "balatro";
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Récupérer les cartes sélectionnées
$selected_cards = [];
if (isset($_SESSION['selected_cards'])) {
    foreach ($_SESSION['selected_cards'] as $card_id) {
        $stmt = $conn->prepare("SELECT * FROM cartes WHERE id = :id");
        $stmt->execute(['id' => $card_id]);
        $selected_cards[] = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Gérer la réception des cartes
if (isset($_POST['select_card'])) {
    if (!isset($_SESSION['selected_cards'])) {
        $_SESSION['selected_cards'] = [];
    }
    if (count($_SESSION['selected_cards']) < 5) {
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

// Fonction pour évaluer la main de poker
function evaluate_hand($cards) {
    $values = [];
    $suits = [];
    foreach ($cards as $card) {
        $values[] = $card['valeurs'];
        $suits[] = $card['couleur'];
    }

    $value_counts = array_count_values($values);
    $suit_counts = array_count_values($suits);

    // Convertir les valeurs en nombres pour faciliter les calculs de suite
    $value_map = [
        '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7,
        '8' => 8, '9' => 9, '10' => 10, 'J' => 11, 'Q' => 12, 'K' => 13, '1' => 1, 'A' => 14
    ];
    $numeric_values = array_map(function($value) use ($value_map) {
        return $value_map[$value];
    }, $values);
    sort($numeric_values);

    // Détection des combinaisons
    $is_flush_five = max($suit_counts) == 5 && count(array_unique($values)) == 1;
    $is_flush_house = in_array(3, $value_counts) && in_array(2, $value_counts) && max($suit_counts) == 5;
    $is_five_of_a_kind = max($value_counts) == 5 && count(array_unique($values)) == 1 && count(array_unique($suits)) > 1;
    $is_flush = max($suit_counts) == 5;
    $is_straight = ((max($numeric_values) - min($numeric_values) == 4) || (max($numeric_values) - min($numeric_values) == 12)) && count(array_unique($numeric_values)) == 5; // La différence peut être 4 ou 12 pour la suite avec As
    $is_royal = $is_straight && min($numeric_values) == 10 && $is_flush;

    if ($is_flush_five) return 'Flush Five';
    if ($is_flush_house) return 'Flush House';
    if ($is_five_of_a_kind) return 'Five of a Kind';
    if ($is_royal) return 'Quinte Flush Royale';
    if ($is_straight && $is_flush) return 'Quinte Flush';
    if (in_array(4, $value_counts)) return 'Carré';
    if (in_array(3, $value_counts) && in_array(2, $value_counts)) return 'Main Pleine';
    if ($is_flush) return 'Couleur';
    if ($is_straight) return 'Suite';
    if (in_array(3, $value_counts)) return 'Brelan';
    if (count(array_filter($value_counts, function($count) { return $count == 2; })) == 2) return 'Double Paire';
    if (in_array(2, $value_counts)) return 'Paire';

    // Carte haute
    return 'Carte Haute';
}

// Fonction pour calculer le score de la main
function calculer_points($combinaison, $cartes, $niveau) {

    // Connexion à la base de données
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "balatro";
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer dans la BDD les points associés à chaque combinaison
    $stmt = $conn->prepare("SELECT * FROM mains_poker WHERE nom = :combinaison");
    $stmt->execute(['combinaison' => $combinaison]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $jetons_base = $row['jetons'];
    $multi_base = $row['multiplicateur'];
    $ajout_jetons = $row['ajoutJetonsParNiveau'];
    $ajout_multi = $row['ajoutMultiParNiveau'];


    // Calculer le score de la combinaison
    $calcul_jetons = 0;
    $calcul_multi = $multi_base + (($niveau - 1) * $ajout_multi);
    switch ($combinaison) {
        case 'Paire':
            $calcul_jetons = (2 * $cartes[0]) + $jetons_base + (($niveau - 1) * $ajout_jetons);
            break;
        case 'Double Paire':
            $calcul_jetons = (2 * ($cartes[0] + $cartes[1])) + $jetons_base + (($niveau - 1) * $ajout_jetons);

            break;
        case 'Brelan':
            $calcul_jetons = (3 * $cartes[0]) + $jetons_base + (($niveau - 1) * $ajout_jetons);
            break;
        case 'Suite':
            $calcul_jetons = array_sum($cartes) + $jetons_base + (($niveau - 1) * $ajout_jetons);
            break;
        case 'Couleur':
            $calcul_jetons = array_sum($cartes) + $jetons_base + (($niveau - 1) * $ajout_jetons);
            break;
        case 'Main Pleine':
            $calcul_jetons = (3 * $cartes[0] + 2 * $cartes[1]) + $jetons_base + (($niveau - 1) * $ajout_jetons);
            break;
        case 'Carré':
            $calcul_jetons = 4 * $cartes[0] + $jetons_base + (($niveau - 1) * $ajout_jetons);
            break;
        case 'Flush House':
            $calcul_jetons = array_sum($cartes) + $jetons_base + (($niveau - 1) * $ajout_jetons);
            break;
        case 'Flush Five':
            $calcul_jetons = array_sum($cartes) + $jetons_base + (($niveau - 1) * $ajout_jetons);
            break;
        case 'Quinte Flush':
            $calcul_jetons = array_sum($cartes) + $jetons_base + (($niveau - 1) * $ajout_jetons);
            break;
        case 'Quinte Flush Royale':
            $calcul_jetons = array_sum($cartes) + $jetons_base + (($niveau - 1) * $ajout_jetons);
            break;
        case 'Five of a Kind':
            $calcul_jetons = 5 * $cartes[0] + $jetons_base + (($niveau - 1) * $ajout_jetons);
            break;
        default:
            $calcul_jetons = 0;
            break;
    }

    // Calculer le score total en ajoutant le niveau
    $score_total = $calcul_jetons * $calcul_multi;

    $liste_return = array($calcul_jetons, $calcul_multi, $score_total);

    return $liste_return;
}

// Détection de la main et calcul des points
if (isset($_POST['calculate_points'])) {
    $hand = evaluate_hand($selected_cards);
    $niveau = isset($_POST['niveau']) ? intval($_POST['niveau']) : 1;
    
    // Pour le calcul des points, nous devons passer les bonnes valeurs des cartes selon la combinaison détectée
    $values = array_map(function($card) {
        return intval($card['point']); // Suppose que 'point' est l'attribut contenant la valeur de la carte
    }, $selected_cards);

    if ($hand == 'Paire' || $hand == 'Double Paire' || $hand == 'Brelan' || $hand == 'Main Pleine' || $hand == 'Carré' || $hand == 'Five of a Kind') {
        $value_counts = array_count_values($values);
        $main_values = [];
        foreach ($value_counts as $value => $count) {
            if ($hand == 'Paire' && $count == 2) $main_values[] = $value;
            if ($hand == 'Double Paire' && $count == 2) $main_values[] = $value;
            if ($hand == 'Brelan' && $count == 3) $main_values[] = $value;
            if ($hand == 'Main Pleine' && ($count == 3 || $count == 2)) $main_values[] = $value;
            if ($hand == 'Carré' && $count == 4) $main_values[] = $value;
            if ($hand == 'Five of a Kind' && $count == 5) $main_values[] = $value;
        }
        $score = calculer_points($hand, $main_values, $niveau);
    } else {
        $score = calculer_points($hand, $values, $niveau);
    }

    $_SESSION['hand'] = $hand;

    $_SESSION['score'] = $score[2];
    $_SESSION['jetons'] = $score[0];
    $_SESSION['multi'] = $score[1];

    header("Location: calculateur.php");
    exit;
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
    <title>Calculateur</title>
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
    <h1>Calculateur</h1>
</div>

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

    <form action="calculateur.php" method="post">
        <button type="submit" name="reset" class="btn btn-primary">Effacer les cartes</button>
    </form>

    <div class="container">
        <?php
        if (!empty($_SESSION['error'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
        }
        ?>
    </div>

    <br />
    <br />

    <div class="container">
        <form action="calculateur.php" method="post">
            <div class="mb-3">
                <label for="niveau" class="form-label">Niveau de la main</label>
                <input type="number" class="form-control" id="niveau" name="niveau" min="1" value="1" required>
            </div>
            <button type="submit" name="calculate_points" class="btn btn-success">Calculer les points</button>
        </form>
    </div>
    <br />


    <?php
    if (isset($_SESSION['hand'])) {
        echo '<div class="alert alert-info" role="alert">Main détectée : ' . $_SESSION['hand'] . "</br>Calcul : " . $_SESSION['jetons'] . "x" . $_SESSION['multi'] . "</br>Score Final : " . $_SESSION['score'] . '</div>';
        unset($_SESSION['hand']);
    }
    ?>

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
                    echo "<td><form action='calculateur.php' method='post'><button type='submit' name='select_card' value='" . $row['id'] . "' class='btn btn-primary'>Sélectionner</button></form></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
