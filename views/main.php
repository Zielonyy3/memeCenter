<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meme Center</title>
    <link rel="stylesheet" href="<?= ROOT_PATH ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT_PATH ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
          integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <header>
        <!-- Fixed navbar -->
        <?php require('header.php') ?>
        <div class="row mb-1"></div>
        <main role="main" class="flex-shrink-0">
            <div class="container">
                <?php require($view) ?>
            </div>
        </main>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')</script>
        <script src="/docs/4.5/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
                crossorigin="anonymous"></script>
</body>
<script src="<?= ROOT_PATH ?>/assets/js/bootstrap.min.js"></script>


</body>
</html>