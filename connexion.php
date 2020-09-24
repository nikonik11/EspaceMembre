<?php

session_start();

ini_set('display_errors', 'On');
error_reporting(-1);

require('db.php');

    if(!empty($_POST['email']) && !empty($_POST['password'])){
        
        $email    = htmlspecialchars($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $req = $bdd->prepare("SELECT * FROM user WHERE email = ?");
        $req->execute(array($email));
        $user = $req->fetch();

        $isPasswordCorrect = password_verify($_POST['password'], $user['password']);
        
        if($isPasswordCorrect == 1){
            session_start();
            $_SESSION['connect'] = 1;
            $_SESSION['pseudo'] = $user['pseudo'];
            header('location: main.php');
        }
        else {
            header('location: ?error=1&badpass=1');
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Connexion</title>
</head>
<body>
    <section class="container">
        <div class="formUn">
        <?php if(!isset($_SESSION['connect'])){ ?>
            <h1>Bienvenue sur mon site</h1>
            <p>Connectez-vous, Si vous n'etes pas inscris ,<a href="index.php"> Inscrivez vous </a></p>

            <?php

            if(isset($_GET['error'])){
                if(isset($_GET['badpass'])){
                    echo '<p id="error"> Vos identifiants ne sont pas bon</p>';
                }
            }
            ?>

            <form method="post" action="connexion.php">
                <table>
                    <tr>
                        <td>Email</td>
                        <td><input type="email" name="email" placeholder="Ex : rouanet@orange.fr" required></td>
                    </tr>
                    <tr>
                        <td>Mot de passe</td>
                        <td><input type="password" name="password" placeholder="Votre Mot de passe" required></td>
                    </tr>
                </table>
                <div id="button">
                    <button>Connexion</button>
                </div>
            </form>
        </div>
    </section>
    <?php } else { ?>

    <p>
        salut <?= $_SESSION['pseudo'] ?> </br>
        <a href="deco.php">Se déconnecter</a>
    </p>

<?php } ?>
</body>
</html>