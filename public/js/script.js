$(function() {

    //FUNCTIONS 
    function refreshCartStats(info){
        let cTotalSum = 0;
        let cTotalGoods = 0;
        for(let i = 0; i < info.length;i++){
            cTotalSum +=Number(info[i].product_price)* info[i].product_quantity;
            cTotalGoods += Number(info[i].product_quantity);
        }
        
        $('.cart-bill-total-sum').text(cTotalSum+" грн.");
        $('.cart-bill-total-goods').text(cTotalGoods+" тов.");
    }

    function isEmptyCart(info){
        if(info.length === 0){
            $('.cart-pop-up-content').html("<div class='cart-pop-up-empty'>Ваша корзина пуста</div>");
            $('.checkout-items').html("<div class='checkout-cart-empty'>Ваша корзина пуста</div>");
            $('.cart-pop-up-checkout').hide();
        }
    }
    function addWeightUnit(info){
        for(let i =0;i<info.length;i++){
            if(info[i]['product_category_id'] ==7){
                info[i]['product_weight'] =info[i]['product_weight'] + " л";// если напиток, то вес измеряется в литрах
            }else{
                info[i]['product_weight'] =info[i]['product_weight'] + " г";// если не напиток, то вес измеряется в грамах
            }
        }
    }

    function listProductsInCart(info){
        $('.cart-pop-up-content').loadTemplate('../resources/templates/front/product_in_cart.php', info,{
            complete: function() {
                
                $('.cart-pop-up-card-delBtn').on('click', function() {
                    $(this).parent().hide(300,function(){
                         let whichItem = $(this).attr('id');
                        $.ajax({
                            url: "js/cart.php?delete="+whichItem
                        }).done(function(data){
                            let cartData = $.parseJSON(data);
                            addWeightUnit(cartData);
                            listProductsInCart(cartData);
                            listProducts(cartData);
                            isEmptyCart(cartData);
                            refreshCartStats($.parseJSON(data));
                        });//ajax loaded
                        
                        $(".card[data-id='"+whichItem+"']").find(".button-add-to-cart").show();
                        $(".card[data-id='"+whichItem+"']").find(".card-counter").hide();

                        $(this).remove();
                        
                    });
                });//delete product
            }//complete
        });//load template
        if(info.length === 0){
            $('.cart-pop-up-content').html("<div class='cart-pop-up-empty'>Ваша корзина пуста</div>");
            $('.cart-pop-up-checkout').hide();
        }else{
            $('.cart-pop-up-checkout').show();
        }
    }

    function listProducts(info){

        $('.checkout-items').loadTemplate('../resources/templates/front/my_order.php',
        info,{
            complete: function(){ 
                
                $('.checkout-delBtn').on('click', function() {
                    
                    $(this).parents(".checkout-item").hide(300,function(){
                         let whichItem = $(this).attr('id');
                        $.ajax({
                            url: "js/cart.php?delete="+whichItem
                        }).done(function(data){
                            let cartData = $.parseJSON(data);
                            addWeightUnit(cartData);
                            listProductsInCart(cartData);
                            listProducts(cartData);
                            isEmptyCart(cartData);
                            refreshCartStats($.parseJSON(data));
                        });//ajax loaded
                        
                        $(".card[data-id='"+whichItem+"']").find(".button-add-to-cart").show();
                        $(".card[data-id='"+whichItem+"']").find(".card-counter").hide();

                        $(this).remove();
                        
                    });
                });//delete product
            }
        });//load template
    }

    // READ DATA


    $.ajax({
        url: "js/cart.php"
    }).done(function(data){
        let cartData = $.parseJSON(data);
        addWeightUnit(cartData);
        listProductsInCart(cartData);
        listProducts(cartData);
        refreshCartStats(cartData);
        isEmptyCart(cartData);//Проверяется корзина на условие пустоты
    });//ajax loaded

 
    
    //EVENTS

    $('.button-add-to-cart').on('click',function(e){
        let link = e.target.attributes[0].value;
        e.preventDefault();
        let prdID = $(this).parents('.card').attr("data-id");
        let counter = $(this).next().find(".card-counter-amount");
        $.ajax({
            url: "js/"+link
        }).done(function(data){
            let cartData = $.parseJSON(data);
            
            $('.cart-pop-up-checkout').show();
            refreshCartStats(cartData);
            let whichItem = _.find(cartData, function(item){
                return item.product_id == prdID;
            });
            counter.text(whichItem.product_quantity);
            listProductsInCart(cartData);
            if(window.outerWidth>651){
                $('.cart-pop-up-wrapper').show();
            }
            
        });//ajax loaded
        $(this).hide();
        $(this).next().show();
    });
    $('.button-increase').on('click',function(e){
        let link = e.target.attributes[0].value;
        e.preventDefault();
        let prdID = $(this).parents('.card').attr('data-id');
        let counter = $(this).prev();
        $.ajax({
            url: "js/"+link
        }).done(function(data){
            let cartData = $.parseJSON(data);
            let whichItem = _.find(cartData, function(item){
                return item.product_id == prdID;
            });
            counter.text(whichItem.product_quantity);
            listProductsInCart(cartData);
            refreshCartStats(cartData);
        });//ajax loaded

    });
     $('.button-decrease').on('click',function(e){
        e.preventDefault();
        let link = e.target.attributes[0].value;
        let prdID = $(this).parents('.card').attr('data-id');
        let counter = $(this).parent();
        let addBtn = $(this).parent().prev();
        $.ajax({
            url: "js/"+link
        }).done(function(data){
            let cartData = $.parseJSON(data);
            let whichItem = _.find(cartData, function(item){
                return item.product_id == prdID;
            });
            if(whichItem === undefined){
                counter.hide();
                addBtn.show();
            }else{
                counter.find(".card-counter-amount").text(whichItem.product_quantity);
            }
            
            listProductsInCart(cartData);
            if(cartData.length === 0){
                $('.cart-pop-up-checkout').hide();
                $('.cart-pop-up-content').html("<div class='cart-pop-up-empty'>Ваша корзина пуста</div>");
            }
            refreshCartStats(cartData);
        });//ajax loaded
        
    }); 
    $('.cart').on('mouseenter', function(){
        $('.cart-pop-up-wrapper').show();
    });
    $('.cart').on('click', function(){
        
        $('.cart-pop-up-wrapper').show();
    }); 
    $('.cart').on('mouseleave', function(){
        $('.cart-pop-up-wrapper').hide();
    });
    $(".close-cart-pop-up").on('click',function(e){
        e.stopPropagation();
        $('.cart-pop-up-wrapper').hide();
    });

    //Filter Panel
    $('.sort-ingredients__ingredients').on('click',function(e){
        e.stopPropagation();
        $('.sort-ingredients__container').toggle();
    });

    $(".checkbox").change(function() {
        var cChecked = 0;
        for(i=0;i<$(".checkbox").length;i++){
            if($(".checkbox")[i].checked ===true){
                cChecked ++;
            }
        }
        console.log(cChecked);
        if(cChecked == 0){
            $('.sort-ingredients__ingredients').text ( "Ингредиенты ...");
        }else{
            $('.sort-ingredients__ingredients').text ( "Ингредиенты ("+cChecked+")");
        }
       
        var id = $(this).attr('data-ingredient_id');
        var href = $('.apply-ingredients-filter').attr('href');
        var ret;
        if(this.checked) {
            if($('.apply-ingredients-filter').attr('href')=="index.php"){
                $('.apply-ingredients-filter').attr('href',href+"?ingr_"+id+"=true") ;
            }else{
                $('.apply-ingredients-filter').attr('href',href+"&ingr_"+id+"=true") ;
            }
        }else{
             if(href.includes("?ingr_"+id+"=true")){
                ret = href.replace('?ingr_'+id+'=true','');
                ret = ret.replace('index.php&', 'index.php?');
             }else{
                ret = href.replace('&ingr_'+id+'=true','');
             }
            
            $('.apply-ingredients-filter').attr('href',ret);
        }
    });
    $(document).mouseup(function (e){ // событие клика по веб-документу
		var div = $(".sort-ingredients__container"); // тут указываем ID элемента
		if (!div.is(e.target) && div.has(e.target).length === 0 && e.target !== $('.sort-ingredients__ingredients')[0]) { // и не по его дочерним элементам
			div.hide(); // скрываем его
        }
        
	});
    // Wok picker
    /* let wokData;
    let totalSum = 0;
    let overlay = $(".wok-picker-overlay");
    $.ajax({
        url: "js/wok-data.json"
    }).done(function(data){
       wokData = data;
    });//ajax loaded


    $(".button-pick-wok").on('click',function(e){
        e.preventDefault();
        overlay.show();
    });
    $(".wok-picker-btn-close").on('click',function(){
        overlay.hide();
    });
    overlay.on('click',function(e){
        
        if(e.target == overlay[0] ){
            overlay.hide();
        }
        
    });
    $(".ingredients-item").on('click',function(e){
        let whichItem = $(this).children().data("id")-1;
        
        console.log(wokData);
        console.log(whichItem);
        $(this).find(".wok-checkbox").toggleClass("selected");

        if($(this).hasClass("basis")){
            for(let i=0;i<$(".basis-radiobutton").length;i++){
                if($(".basis-radiobutton")[i]!=$(this).find(".basis-radiobutton")){
                    $(".basis-radiobutton").eq(i).removeClass("selected"); 
                    console.log($(".basis-radiobutton").parents(".ingredients-label"));
                    wokData[$(".basis-radiobutton").parents(".ingredients-label").eq(i).data("id")-1].selected = false;
                }
            }
            $(this).find(".basis-radiobutton").toggleClass("selected");
        }
        if(wokData[whichItem-1].selected){
            wokData[whichItem-1].selected = false;
        }else{
            wokData[whichItem-1].selected = true; 
        }
        wokData[whichItem].selected = true;
        totalSum = 0;
        for(let i = 0; i < wokData.length; i++){
            if(wokData[i].selected == true){
                totalSum +=wokData[i].price;
            }
            
        }
        $(".wok-picker-total-price").text(totalSum);
    }); */
});