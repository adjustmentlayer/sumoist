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
    <?php get_category_name() ?>
    
</head>

<?php facility_closed(); // Сообщение о том, что ресторан закрыт?> 

<?php include(TEMPLATE_FRONT . DS ."header.php") ?>

    <div style="width:100%" class="owl-carousel">
        <!-- Carousel -->
        <?php include(TEMPLATE_FRONT . DS ."slider.php") ?>
    </div>
    <div class="filter-panel">
        <div class="sort-ingredients">
        <?php
            $param_sequence ="";
            $count = 0;
            $c_param = 0;
            foreach($_GET as $name => $value){
                if($c_param==0){
                    $param_sequence .= "?".$name."=".$value;
                }else{
                    $param_sequence .= "&".$name."=".$value;
                }
                if(strpos($name, "cat_id") === false){
                    $count++;
                }
                $c_param ++;
            }
        ?>
            <div class="sort-ingredients__ingredients btn">Ингредиенты<?php if($count == 0){echo " ...";}else{echo " ({$count})";} ?></div>
            <div style="display:none" class="sort-ingredients__container">
                <div class="sort-ingredients__ingredient-tags">
                    <?php
                        get_ingredients();
                    ?> 
                </div>
                <div class="btn-container">
                    <a href="index.php<?php echo "{$param_sequence}"; ?>" class="btn apply-ingredients-filter">Применить</a>
                    <a href="index.php<?php if(isset($_GET['cat_id'])){echo "?cat_id=".$_GET['cat_id'];}?>" class="btn reset-ingredients-filter">Сбросить</a>
                </div>
            </div>
        </div>
    </div>
    <div class="cards-container">
        <div class="cards">
            
             <?php if(isset($_GET['cat_id'])){
                  get_products_in_cat_page(); 
            }else{
                 get_products(); 
            } ?> 
            
        </div>
    </div>
    
    
<?php include(TEMPLATE_FRONT . DS ."footer.php") ?>
<script type="text/javascript" src="js/sticky.js"></script>
<!-- Scripts for slider -->
<script src="js/lib/owl/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/slider.js"></script>

</body>
</html>