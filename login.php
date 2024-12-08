<?php
// Activer les rapports d'erreur pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Vérifiez si la méthode est POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : null;
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : null;

    // Vérifier que les champs ne sont pas vides
    if (empty($username) || empty($password)) {
        echo "Veuillez remplir tous les champs.";
        exit();
    }

    // Informations de connexion à la base de données
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "auth";

    // Créer la connexion
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Vérifier si la connexion a échoué
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    // Préparer et exécuter la requête SQL
    $query = $conn->prepare("SELECT * FROM login WHERE username = ? AND password = ?");
    if ($query === false) {
        die("Erreur lors de la préparation de la requête : " . $conn->error);
    }

    $query->bind_param("ss", $username, $password);
    $query->execute();
    $result = $query->get_result();

    // Vérifier les résultats
    if ($result && $result->num_rows == 1) {
        header("Location: https://bimam21.github.io/Po-me_Fr/Declaration.html);
        exit();
        exit();
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect.";
    }

    // Fermer la connexion et la requête
    $query->close();
    $conn->close();
} else {
    // Si la méthode n'est pas POST
    echo "Cette page ne peut être accédée que via un formulaire.";
    exit();
}
?>
