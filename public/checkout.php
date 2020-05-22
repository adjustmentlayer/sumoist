<?php require_once("../resources/config.php"); ?>
<?php include "process.php"; ?>

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

    <title>Корзина</title>
    <meta name ="description" content="">
</head>
<?php facility_closed(); // Сообщение о том, что ресторан закрыт?> 
<?php include(TEMPLATE_FRONT . DS ."header.php") ?>
    
    <div class="checkout-container">
    
        <div class="checkout-title">Оформление заказа</div>
        
        <div class="checkout">
            <div class="checkout-form">
            
                <form method="post" action="checkout.php" >
                    <ul>
                        <li>
                            <input type="radio" class="radio" name="deliveryMethod" id="takeaway" value="takeaway"
                            <?php if(isset($deliveryMethod) && $deliveryMethod === "takeaway"){echo "checked";}elseif(!isset($deliveryMethod)){ echo "checked";}?>>
                            <label for="takeaway">Заказ на вынос
                            </label><input type="radio" class="radio" name="deliveryMethod"  id="delivery" value="delivery"
                            <?php if(isset($deliveryMethod) && $deliveryMethod === "delivery"){echo "checked";}?>>
                            <label for="delivery">Доставка</label>
                        </li>
                        <li>
                            <input name="name" placeholder="Имя" value="<?php if(isset($name)){echo $name;}?>" >
                            <?php if (isset($err_name)){echo $err_name;}?>
                        </li>
                        <li>
                            <input name="email" placeholder="Эл. почта" value="<?php if(isset($email)){echo $email;}?>"  >
                            <?php if (isset($err_email)){echo $err_email;}?>
                        </li>
                        <li>
                            <input name="tel" placeholder="Телефон в формате +380yyxxxxxxx" 
                            value="<?php if(isset($phone)){echo $phone;}?>" >
                            <?php if (isset($err_phone)){echo $err_phone;}?>
                        </li>
                        <li>
                            <input name="address" placeholder="Адрес доставки" value="<?php if(isset($address)){echo $address;}?>">
                            <?php if (isset($err_delivery)){echo $err_delivery;}?>
                        </li>
                        <li>
                            <input name="comment" placeholder="Комментарий к заказу"  value="<?php if(isset($comment)){echo $comment;}?>">
                        </li>
                        <li>
                            <input type="radio" class="radio" name="paymentMethod" id="cash" value="cash" 
                            <?php if(isset($paymentMethod) && $paymentMethod === "cash"){echo "checked";}elseif(!isset($paymentMethod)){ echo "checked";}?>>
                            <label for="cash">Наличные
                            </label><input type="radio" class="radio" name="paymentMethod" id="card" value="card"
                            <?php if(isset($paymentMethod) && $paymentMethod === "card"){echo "checked";}?>>
                            <label for="card">Картой</label>
                        </li>
                        <li>
                            <input name="change" placeholder="Приготовить сдачу с"  value="<?php if(isset($change)){echo $change;}?>" >
                        </li>
                        <li>
                            <button class="btn submit" name="action" value="submit">Оформить</button>
                            <div class="cart-bill-total-sum big-bill center"></div>
                         </li>
                         <li><?php if (isset($msg)){echo $msg;}?></li>
                    </ul>
                    
                </form>
            </div>
            <div class="checkout-items">
            
            </div>
        </div>
    </div>

<?php include(TEMPLATE_FRONT . DS ."footer.php") ?>


</body>
</html>