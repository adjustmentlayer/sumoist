<?php

//helper functions

function redirect($location){

    header("Location: $location");

}

function query($sql) {
    global $connection;
    return mysqli_query($connection, $sql);
}

function confirm($result){
    global $connection;

    if(!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function escape_string($string){
    global $connection;

    return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result){
    return mysqli_fetch_array($result);
}

// get products
function get_choosen_ingredients(){
    $ingredients = array();
    
    foreach($_GET as $name => $value){
        if($value ==true){
            if(substr($name,0,5)== "ingr_"){
                
                $length = strlen($name) - 5;
                $id = substr($name, 5, $length);
                $query = query("SELECT * FROM ingredients WHERE ingredient_id = " . escape_string($id)." ");
                confirm($query);

                while($row = fetch_array($query)){
                    $ingredients[] = $row;
                }  
            }
        }
    } 
    return $ingredients;
}
function get_products(){
    
    $ingredients = get_choosen_ingredients();
    $query = query("SELECT * FROM products ORDER BY product_category_id");
    confirm($query);
    
    while($row = fetch_array($query)){
        if($row['product_category_id'] ==7){
            $weight_unit = "л";
        }else{
            $weight_unit = "г";
        }
        $has_ingredients = true;
        foreach($ingredients as $name => $value){
            if (strripos(mb_strtolower($row['product_ingredients']), mb_strtolower($value['ingredient_name'])) === false) {
                $has_ingredients = false;
            }
        }
        if($has_ingredients && $row['visible']){
        if (isset($_SESSION['product_'.$row['product_id']]) ){
        $product =
        "<div class='card' data-id='{$row['product_id']}' >
            <div class='card-image'><img src='{$row['product_image']}' alt='{$row['product_title']}'></div>
            <div class='card-name'><span>{$row['product_title']}</span></div>
            <div class='card-ingredients'><span>{$row['product_ingredients']}</span></div>
            <div class='card-weight'><span>{$row['product_weight']}</span><span> {$weight_unit}</span></div>
            <div class='card-stats'>
                <a href='cart.php?add={$row['product_id']}' style='display:none' class='btn button-add-to-cart'>В корзину</a>
                <div style='' class='card-counter'>
                    <a href='cart.php?remove={$row['product_id']}' class='button-decrease'>-</a>
                    <div class='card-counter-amount'>{$_SESSION['product_'.$row['product_id']]}</div>
                    <a href='cart.php?add={$row['product_id']}' class='button-increase'>+</a>
                </div>
                <div class='card-price'><span>{$row['product_price']}</span><span> грн.</span></div>
            </div>
        </div>";
        
        }else{
            $product =
            "<div class='card' data-id='{$row['product_id']}' >
                <div class='card-image'><img src='{$row['product_image']}' alt='{$row['product_title']}'></div>
                <div class='card-name'><span>{$row['product_title']}</span></div>
                <div class='card-ingredients'><span>{$row['product_ingredients']}</span></div>
                <div class='card-weight'><span>{$row['product_weight']}</span><span> {$weight_unit}</span></div>
                <div class='card-stats'>
                    <a href='cart.php?add={$row['product_id']}' class='btn button-add-to-cart'>В корзину</a>
                    <div style='display:none' class='card-counter'>
                        <a href='cart.php?remove={$row['product_id']}' class='button-decrease'>-</a>
                        <div class='card-counter-amount'>0</div>
                        <a href='cart.php?add={$row['product_id']}' class='button-increase'>+</a>
                    </div>
                    <div class='card-price'><span>{$row['product_price']}</span><span> грн.</span></div>
                </div>
            </div>";
        }
        echo $product;

    }
}
    
}

function get_categories(){

    if(isset($_GET['cat_id'])){
        $cat_id = $_GET['cat_id'];
    }else{
        $cat_id = 0;
    }
    $query = query("SELECT * FROM categories");
    confirm($query);
    while($row = fetch_array($query)){

        if($cat_id===$row['cat_id']){
            $category_links = <<<DELIMETER
            <li ><a class='pill menu-active' href='index.php?cat_id={$row['cat_id']}' title='Роллы'>{$row['cat_title']}</a></li>
DELIMETER;
        }else{
            $category_links = <<<DELIMETER
            <li ><a class='pill' href='index.php?cat_id={$row['cat_id']}' title='Роллы'>{$row['cat_title']}</a></li>
DELIMETER;
        }
       echo $category_links;
    }
    if($cat_id === "delivery"){
        echo "<li ><a class='pill menu-active' href='delivery&payment.php?cat_id=delivery' title='Доставка и оплата'>Доставка и оплата</a></li>";
    }else{
        echo "<li ><a class='pill' href='delivery&payment.php?cat_id=delivery' title='Доставка и оплата'>Доставка и оплата</a></li>";
    }
}
function get_category_name(){

    if(isset($_GET['cat_id'])){
        $cat_id = $_GET['cat_id'];
    }else{
        $cat_id = 0;
    }
    $query = query("SELECT * FROM categories");
    confirm($query);
    while($row = fetch_array($query)){

        if($cat_id===$row['cat_id']){
            echo "<title>{$row['cat_title']} - заказать ".mb_strtolower($row['cat_title'])." на дом от Sumoist Одесса </title>
        <meta name='description' content='Наша фирменная японская кухня не оставит никого равнодушным. Доставить ".mb_strtolower($row['cat_title'])." бесплатно в городе Одесса. Готовим заказ до 15 мин.'>";
        }
    }
    if($cat_id==0){
        echo "<title>Sumoist - доставка китайской, японской еды в городе Одесса. Бесплатная доставка или самовывоз</title>
    <meta name='description' content='Наша фирменная японская кухня не оставит никого равнодушным. Бесплатная доставка китайской и японской еды в городе Одесса. Готовим заказ до 15 мин.'> ";
    }
}

function get_products_in_cat_page(){
    $ingredients = get_choosen_ingredients();
    $cat_id = escape_string($_GET['cat_id']);
    $query = query("SELECT * FROM products WHERE product_category_id = " . $cat_id." ");
    confirm($query);

    while($row = fetch_array($query)){
        if($row['product_category_id'] ==7){
            $weight_unit = "л";
        }else{
            $weight_unit = "г";
        }
        
        $has_ingredients = true;
        foreach($ingredients as $name => $value){
            if (strripos(mb_strtolower($row['product_ingredients']), mb_strtolower($value['ingredient_name'])) === false) {
                $has_ingredients = false;
            }
        }
        if($has_ingredients && $row['visible']){
        if (isset($_SESSION['product_'.$row['product_id']]) ){
            $product =
            "<div class='card' data-id='{$row['product_id']}' >
                <div class='card-image'><img src='{$row['product_image']}' alt='{$row['product_title']}'></div>
                <div class='card-name'><span>{$row['product_title']}</span></div>
                <div class='card-ingredients'><span>{$row['product_ingredients']}</span></div>
                <div class='card-weight'><span>{$row['product_weight']}</span><span> {$weight_unit}</span></div>
                <div class='card-stats'>
                    <a href='cart.php?add={$row['product_id']}' style='display:none' class='btn button-add-to-cart'>В корзину</a>
                    <div style='' class='card-counter'>
                        <a href='cart.php?remove={$row['product_id']}' class='button-decrease'>-</a>
                        <div class='card-counter-amount'>{$_SESSION['product_'.$row['product_id']]}</div>
                        <a href='cart.php?add={$row['product_id']}' class='button-increase'>+</a>
                    </div>
                    <div class='card-price'><span>{$row['product_price']}</span><span> грн.</span></div>
                </div>
            </div>";
            
            }else{
                $product =
                "<div class='card' data-id='{$row['product_id']}' >
                    <div class='card-image'><img src='{$row['product_image']}' alt='{$row['product_title']}'></div>
                    <div class='card-name'><span>{$row['product_title']}</span></div>
                    <div class='card-ingredients'><span>{$row['product_ingredients']}</span></div>
                    <div class='card-weight'><span>{$row['product_weight']}</span><span> {$weight_unit}</span></div>
                    <div class='card-stats'>
                        <a href='cart.php?add={$row['product_id']}' class='btn button-add-to-cart'>В корзину</a>
                        <div style='display:none' class='card-counter'>
                            <a href='cart.php?remove={$row['product_id']}' class='button-decrease'>-</a>
                            <div class='card-counter-amount'>0</div>
                            <a href='cart.php?add={$row['product_id']}' class='button-increase'>+</a>
                        </div>
                        <div class='card-price'><span>{$row['product_price']}</span><span> грн.</span></div>
                    </div>
                </div>";
        }
        echo $product;
        }

    } 
}
function get_ingredients(){
    
    $query = query("SELECT * FROM ingredients");
            confirm($query);
            while($row = fetch_array($query)){
                if(isset($_GET["ingr_".$row['ingredient_id']])){
                    echo "<div class='checkbox-container'>
                        <input type='checkbox' class='checkbox' id='ingredient_{$row['ingredient_id']}' data-ingredient_id='{$row['ingredient_id']}' checked/>
                        <label for='ingredient_{$row['ingredient_id']}'>{$row['ingredient_name']}</label>
                        </div>";
                }else{
                    echo "<div class='checkbox-container'>
                        <input type='checkbox' class='checkbox' id='ingredient_{$row['ingredient_id']}' data-ingredient_id='{$row['ingredient_id']}' />
                        <label for='ingredient_{$row['ingredient_id']}'>{$row['ingredient_name']}</label>
                        </div>";
                }
                
            };
}
function facility_closed(){
    $today = date("H:i:s"); 
    $split = date_parse_from_format('H:i:s', $today);  
    if(($split['hour'] >= 22 && $split['minute'] > 29) || $split['hour']<10 || $split['hour'] > 22 ){
        echo "<div class='closed'>Заказы принимаются с 10:00 до 22:30</div>";
    }
}
//poster

$token = "";




?>