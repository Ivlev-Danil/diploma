var cart = {};
function  loadMiniCart() { // загрузка корзины
  if (localStorage.getItem('cart')){ // проверка есть ли корзина
    cart = JSON.parse(localStorage.getItem('cart'));
    showCart();
  }
  else{
    $('.main-cart').html('Корзина пуста');
  }
}

function showCart(){
  if (!isEmpty(cart)){
    $('.main-cart').html('Корзина пуста');
  }
  else{
    $.getJSON('goods.json', function(data){
      var count = 0;
      var goods = data;
      var out = '';
      for (var id in cart){ //вывод товаров в корзине
        out +=`<div class="main-cart-product">`
        out +=`<button data-id="${id}" class="main-cart-product-del"></button>`;
        out +=`<img src="img/${goods[id].img}" alt="${goods[id].name}" class="main-cart-product-img">`;
        out +=`<p class="main-cart-product-name">${goods[id].name}</p>`;
        out +=`<button data-id="${id}" class="main-cart-product-minus">-</button>`;
        out +=`<div class="main-cart-product-count">${cart[id]}</div>`;
        out +=`<button data-id="${id}" class="main-cart-product-plus">+</button>`;
        out +=`<div class="main-cart-product-price">`;
        out +=cart[id]*goods[id].price;
        out +=`</div>`
        out +=`</div>`
        count = count + cart[id]*goods[id].price;
      }
      $('.main-cart-count').html(count);
      $('.main-cart').html(out);
      $('.main-cart-product-del').on('click', delGoods);
      $('.main-cart-product-plus').on('click', plusGoods);
      $('.main-cart-product-minus').on('click', minusGoods);
    });
  }
}

function delGoods(){// удаление товара
  var id = $(this).attr('data-id');
  delete cart[id];
  saveMiniCart();
  showCart();
}

function plusGoods(){// увеличение товара
  var id = $(this).attr('data-id');
  cart[id]++;
  saveMiniCart();
  showCart();
}

function minusGoods(){// уменьшение товара
  var id = $(this).attr('data-id');
  if (cart[id]==1){
    delete cart[id];
  }
  else{
    cart[id]--;
  }
  saveMiniCart();
  showCart();
}

function saveMiniCart(){ // сохраняем корзину
  localStorage.setItem('cart', JSON.stringify(cart)); //корзина в строку
}

function isEmpty(object){// проверка корзины на пустоту
  for(var key in object)
  if (object.hasOwnProperty(key)) return true;
  return false;
}

function sendEmail(){
  var ename = $('#ename').val();
  var ephone = $('#ephone').val();
  var email = $('#email').val();
  if (ename!="" && ephone!="" && email!=""){
    if (isEmpty(cart)){
      $.post(
        "core/mail.php",
        {
          "ename" : ename,
          "ephone" : ephone,
          "email" : email,
          "cart" : cart,
        },
        function(data){
          if (data == 1){
            alert('Заказ отправлен');
            cart = {};
            saveMiniCart();
            showCart();
            location.reload();

            console.log(cart);
          }
          else{
            alert('Повторите');
          }
        }
      )
    }
    else{
      alert('Корзина пуста')
    }
  }
  else{
    alert('Заполните поля');
  }
}

$(document).ready(function(){
  loadMiniCart();
  $('.order-field-send').on('click', sendEmail); // отправка письма
});
