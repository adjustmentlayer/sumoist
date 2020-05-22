<?php require_once("../../resources/config.php"); ?>
<?php
if(isset($_GET['add'])) {
    if(isset($_SESSION['product_' . $_GET['add']])) {
    $_SESSION['product_' . $_GET['add']] += 1;
    }else{
        $_SESSION['product_' . $_GET['add']] = '1';
    }
}
if(isset($_GET['remove'])){

   $_SESSION['product_' . $_GET['remove']]--;
   if($_SESSION['product_' . $_GET['remove']] < 1){
    $_SESSION['product_' . $_GET['remove']] = null;
   }else{

   }
}
if(isset($_GET['delete'])){
   $_SESSION['product_' . $_GET['delete']] = null;
}
$myArray = array();
foreach($_SESSION as $name => $value){
        if($value > 0){
            if(substr($name,0,8)== "product_"){
                
                $length = strlen($name) - 8;
                $id = substr($name, 8, $length);
                $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id)." ");
                confirm($query);

                while($row = fetch_array($query)){
                    $row["product_quantity"] = $_SESSION["product_" . escape_string($id).""];
                    $myArray[] = $row;
                } 
            }
        }
} 
$json = json_encode($myArray);
echo $json;
?>