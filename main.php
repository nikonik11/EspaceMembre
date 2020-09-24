<?php
session_start();
if(!isset($_SESSION['connect'])){
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <section class="container">
        <div class="log">
            <h1>Bienvenue <?= $_SESSION['pseudo'] ?></h1>
            <a href="deco.php">Se déconnecter</a>
        </div>
    </section>
</body>
</html>