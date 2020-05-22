<?php require_once("../resources/config.php"); ?>
<?php
    if(($_SERVER['REQUEST_METHOD'] == 'POST') && (!empty($_POST['action']))):
        if(isset($_POST['name'])) { $name = escape_string($_POST['name']); }
        if(isset($_POST['email'])) {$email = escape_string($_POST['email']);}
        if(isset($_POST['tel'])) { $phone = escape_string($_POST['tel']); }
        if(isset($_POST['address'])) { $address = escape_string($_POST['address']); }
        if(isset($_POST['deliveryMethod'])) { $deliveryMethod = escape_string($_POST['deliveryMethod']); }
        if(isset($_POST['paymentMethod'])) { $paymentMethod = escape_string($_POST['paymentMethod']); }
        if(isset($_POST['change'])) { $change = escape_string($_POST['change']); }
        if(isset($_POST['comment'])) { $comment = escape_string($_POST['comment']); }
        $today = date("H:i:s"); 
        $split = date_parse_from_format('H:i:s', $today);  
        $formerrors = false;

        if(($split['hour'] >= 22 && $split['minute'] > 29) || $split['hour']<10 || $split['hour'] > 22 ){
            $formerrors = true;
        }

        if(!preg_match("/^\+380\d{3}\d{2}\d{2}\d{2}$/", $phone)){
            $err_phone = "<div class='form-error'>Введите номер телефона в формате +380yyxxxxxxx</div>";
            $formerrors = true;
        } 
         if($phone === ""){
            $err_phone = "<div class='form-error'>Заполните поле телефон</div>";
            $formerrors = true;
        } 
        if($deliveryMethod == "delivery"){
            if($address === "" ){
                $err_delivery = "<div class='form-error'>Введите свой адрес</div>";
                $formerrors = true;
            }
        }
       
        if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email)) {
            $email = "";
        } 
        $quantity = 0;
        foreach($_SESSION as $session_name => $value){
            
            if($value > 0){
                if(substr($session_name,0,8)== "product_"){
                    $quantity += $value;
                }
            }
            
        }
        if($quantity === 0){
            $formerrors = true;
        }
         if(!($formerrors)):
            
            if($deliveryMethod =="takeaway"){
                $comment .= " || Способ доставки: На вынос";
            }else{
                $comment .= " || Способ доставки: Доставка";
            }
            if($paymentMethod =="cash"){
                $comment .= " || Способ Оплаты: Наличными";
            }else{
                $comment .= " || Способ Оплаты: Картой";
            }
            $comment .= " || Приготовить сдачу с: ".$change;

            $products = [];
            foreach($_SESSION as $session_name => $value){
                if($value > 0){
                    if(substr($session_name,0,8)== "product_"){
                        
                        $length = strlen($session_name) - 8;
                        $id = substr($session_name, 8, $length);
                        $query = query("SELECT * FROM products WHERE product_id = " . escape_string($id)." ");
                        confirm($query);
        
                        while($row = fetch_array($query)){
                            $row["product_quantity"] = $_SESSION["product_" . escape_string($id).""];
                            $products[] = [
                                'product_id' =>(int)$row["product_id"],
                                'count' => (int)$row["product_quantity"]
                            ];
                        }
                        
                    }
                }
            } 
            function sendRequest($url, $type = 'get', $params = [], $json = false)
            {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

                if ($type == 'post' || $type == 'put') {
                    curl_setopt($ch, CURLOPT_POST, true);

                    if ($json) {
                        $params = json_encode($params);

                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($params)
                        ]);

                        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                    } else {
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
                    }
                }

                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Poster (http://joinposter.com)');

                $data = curl_exec($ch);
                curl_close($ch);

                return $data;
            }
            global $token;
            $url = 'https://joinposter.com/api/incomingOrders.createIncomingOrder'
            . '?token='.$token;

            $incoming_order = [
                'spot_id'   => 1,
                'first_name' => $name,
                'email' => $email,
                'comment' => $comment,
                'address' => $address,
                'phone'     => $phone,
                'products'  => $products,
            ];

            /* $data = sendRequest($url, 'post', $incoming_order);//Отправка заказа на терминал постера 
            $data = json_decode($data,true);
            $msg = var_dump($data);

             if($data["error"]==0):
                redirect("thank_you.php");
                session_destroy();
            else:
                $msg = "Ошибка оформления";
            endif;  */

        endif;//check for form errors
    endif;//form submitted
?>
