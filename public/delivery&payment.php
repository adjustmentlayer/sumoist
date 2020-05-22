<?php require_once("../resources/config.php"); ?>

<html lang="ru">
<head>
    <?php include(TEMPLATE_FRONT . DS ."gtag.php") ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">

    <!-- OwlCarousel plagin CSS -->
    <link rel="stylesheet" href="js/lib/owl/owl.carousel.min.css">
    <link rel="stylesheet" href="js/lib/owl/owl.theme.default.min.css">

    <title>Доставка и оплата</title>
    <meta name="description" content="Доставка и оплата">
</head>

<?php include(TEMPLATE_FRONT . DS ."header.php") ?>

<div class="content-delivery">
    <div class="delivery-image"><img src="uploads/delivery-image.png" alt="Сумоист на мопеде"></div>
    <div class="delivery-info">
        <div class="delivery-info-headline"><p>БЕСПЛАТНАЯ ДОСТАВКА</p></div>
        <div class="delivery-info-locations"><p>7 небо (30 минут) <br>Лен. поселок (1 час) <br>Авангард (1 час)</p></div>
    </div>
</div>

<?php include(TEMPLATE_FRONT . DS ."footer.php") ?>

</body>
</html>