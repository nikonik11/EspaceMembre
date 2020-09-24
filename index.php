<?php
session_start();

ini_set('display_errors', 'On');
error_reporting(-1);

require('db.php');

    if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['passwordConfirm'])) {

        $pseudo          = htmlspecialchars($_POST['pseudo']);
        $email           = htmlspecialchars($_POST['email']);
        $password        = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];
    

        if($password != $passwordConfirm){
            header('location: ./?error=1&pass=1');
            exit();
        }

        $req = $bdd->prepare("SELECT count(*) AS numberEmail FROM user WHERE email = ?");
        $req->execute(array($email));

        while($email_verif = $req->fetch()){
            if($email_verif['numberEmail'] != 0){
                header('location: ./?error=1&email=1');
                exit();
            }
        }

        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $req = $bdd->prepare("INSERT INTO user (pseudo, email, password) VALUES (?, ?, ?)");
        $req->execute(array($pseudo, $email, $password));

        header('location: ./?success=1');
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Inscription</title>
</head>

<body>
    <section class="container">
        <div class="formUn">
            <?php if(!isset($_SESSION['connect'])){ ?>

            <h1>Bienvenue sur mon site</h1>
            <p>Si vous avez déja un compte, <a href="connexion.php">Connectez vous</a></p>
            <?php
                if(isset($_GET['error'])){
                    if(isset($_GET['pass'])){
                        echo '<p id="error"> Les mots de passe ne sont pas identiques </p>';
                    }
                    else if(isset($_GET['email'])){
                        echo '<p id="error"> Cette adresse Email est déja utilisé </p>';
                    }
                }
                elseif (isset($_GET['success'])){
                    echo '<p id="success"> Inscription réussi</p>';
                }
            ?>

            <form method="post" action="index.php">
                <table>
                    <tr>
                        <td>Pseudo</td>
                        <td><input type="text" name="pseudo" placeholder="Ex : Nicolas" required></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="email" name="email" placeholder="Ex : rouanet@orange.fr" required></td>
                    </tr>
                    <tr>
                        <td>Mot de passe</td>
                        <td><input type="password" name="password" placeholder="Votre Mot de passe" required></td>
                    </tr>
                    <tr>
                        <td>Confirmer Mot de passe</td>
                        <td><input type="password" name="passwordConfirm" placeholder="Confirmer Mot de passe" required>
                        </td>
                    </tr>
                </table>
                <button>Je m'inscris</button>
            </form>
            <?php } else { ?>

            <p>
                salut <?= $_SESSION['pseudo'] ?> </br>
                <a href="deco.php">Se déconnecter</a>
            </p>

            <?php } ?>
        <div class="form">
    </section>
</body>

</html>