<body style="overflow-y:scroll;">
   <header>
       <div class="social">
           <div class="social-links">
               <div class="social-links-icon"><img src="uploads/phone.png" alt="Телефон"></div>
               <div><p>067 373 26 70</p></div>
           </div>
           <div class="social-links">
               <div class="social-links-icon"><img src="uploads/phone.png" alt="Телефон"></div>
               <div><p>099 177 63 03</p></div>
           </div>
           <div class="social-links">
               <div class="social-links-icon"><img src="uploads/instagram.png" alt="Инстаграм"></div>
               <div><a target="_blank" href="https://instagram.com/sumoist_od?igshid=secs7dt5clai">@sumoist_od</a></div>
           </div>
       </div>
       <div class="logo-working-hours">
            <div class="logo"><a href="index.php"><img src="uploads/logosumoist.png" alt="Логотип"></a></div>
            <div class="working-hours"><span class="text-secondary">Время работы:</span> 10:00-23:00</div>
       </div>
       <div class="cart">
           <div class="cart-icon"><img src="uploads/cart.png" alt="Корзина"></div>
           <div class="cart-bill">
               <div class="cart-bill-total-sum"></div>
               <div class="cart-bill-total-goods"></div>
           </div>
           <div style="display:none" class="cart-pop-up-wrapper">
                <div class="cart-pop-up-inner">
                    <div class="cart-pop-up">
                        <div class="cart-pop-up-title">
                            <p>Корзина</p>
                            <div class="close-cart-pop-up"><img src="uploads/close-btn-white.png" alt="Закрыть"></div>
                        </div>
                        <div class="cart-pop-up-content">
                            <div class="cart-pop-up-empty">Ваша корзина пуста</div>
                        </div>
                        <div style="display:none" class="cart-pop-up-checkout">
                            <button class="btn"><a href="checkout.php">Оформить</a></button>
                        </div>
                    </div>
                </div>
            </div>
       </div>
   </header> 
   <nav>
   <?php include(TEMPLATE_FRONT . DS ."top_nav.php") ?>
    </nav>