<!-- Faut trouver un moyen pour que ça se fasse une fois par jour -->

<?php
try {
    // Connexion à la base de données
    $db = new PDO('mysql:host=localhost;dbname=sae401-2', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Sélectionner trois défis aléatoires de la table defiquotidien
    $requete_defis = $db->query("SELECT ID_Defi FROM defiquotidien ORDER BY RAND() LIMIT 3");
    $defis = $requete_defis->fetchAll(PDO::FETCH_COLUMN);

    // Sélectionner tous les utilisateurs
    $requete_utilisateurs = $db->query("SELECT ID_Utilisateur FROM utilisateurs");
    $utilisateurs = $requete_utilisateurs->fetchAll(PDO::FETCH_COLUMN);

    // Insérer les défis sélectionnés pour chaque utilisateur
    foreach ($utilisateurs as $utilisateur) {
        foreach ($defis as $defi) {
            // Vérifier si le défi n'est pas déjà présent pour cet utilisateur aujourd'hui
            $date_aujourd_hui = date("Y-m-d");
            $requete_verif = $db->prepare("SELECT * FROM utilisateursdefiquotidien WHERE ID_Utilisateur = :utilisateur AND ID_Defi = :defi AND dateObtention = :date_aujourd_hui");
            $requete_verif->bindParam(':utilisateur', $utilisateur);
            $requete_verif->bindParam(':defi', $defi);
            $requete_verif->bindParam(':date_aujourd_hui', $date_aujourd_hui);
            $requete_verif->execute();
            $resultat_verif = $requete_verif->fetch(PDO::FETCH_ASSOC);
            if (!$resultat_verif) {
                // Insertion du défi pour cet utilisateur aujourd'hui
                $requete_insert = $db->prepare("INSERT INTO utilisateursdefiquotidien (ID_Utilisateur, ID_Defi, dateObtention) VALUES (:utilisateur, :defi, :date_aujourd_hui)");
                $requete_insert->bindParam(':utilisateur', $utilisateur);
                $requete_insert->bindParam(':defi', $defi);
                $requete_insert->bindParam(':date_aujourd_hui', $date_aujourd_hui);
                $requete_insert->execute();
            }
        }
    }

    echo "Les défis ont été ajoutés avec succès.";
} catch (PDOException $erreur) {
    // En cas d'erreur de connexion à la base de données
    die("Erreur de connexion à la base de données : " . $erreur->getMessage());
}
?>
