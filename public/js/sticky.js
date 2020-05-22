$(document).ready(function(){
    let menu = document.querySelector(".menu"),
        nav = document.querySelector("nav"),
        cart = document.querySelector(".cart"),
        header = document.querySelector("header"),
        totalSum = document.querySelector(".cart-bill-total-sum"),
        cartIcon = document.querySelector(".cart-icon"),
        totalGoods = document.querySelector(".cart-bill-total-goods");

    window.addEventListener("scroll",function(){
        if(this.window.pageYOffset > 130 && this.window.outerWidth>651){
            nav.classList.add("sticky");
            nav.appendChild(cart);
        }else{
            nav.classList.remove("sticky");
            header.appendChild(cart);
        }
         if(this.window.pageYOffset > 161 && this.window.outerWidth<651){
            totalGoods.style.display = "none";
            
            cartIcon.childNodes[0].src = "uploads/sticky-cart.png";
            cart.classList.add("sticky-mobile");
            nav.classList.add("sticky");
            totalSum.classList.add("cart-bill-total-sum-mobile");
            document.body.appendChild(cart);
        }else{
            cart.classList.remove("sticky-mobile");
            totalSum.classList.remove("cart-bill-total-sum-mobile");
            cartIcon.childNodes[0].src = "uploads/cart.png";
            totalGoods.style.display ="";
        } 
    })
});