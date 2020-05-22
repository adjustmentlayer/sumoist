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

    <title>Спасибо за заказ!</title>
</head>

<?php include(TEMPLATE_FRONT . DS ."header.php") ?>

<div class="thank-you-content">
    <div class="thanks">Благодарим Вас за заказ!</div>
    <div class="check-mark"><img src="uploads/check-mark.png" alt="Галочка"></div>
    <div class="order-success-notification">"Ваш заказ успешно принят и отправлен в работу!"</div>
    <div class="process-explanation"><p>В ближайшее время Вам перезвонит менеджер для подтверждения заказа. Затем заказ будет подготовлен и отправлен на указанный Вами адрес.</p></div>
</div>

<?php include(TEMPLATE_FRONT . DS ."footer.php") ?>

</body>
</html>