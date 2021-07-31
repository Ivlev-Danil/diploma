var cart = {}; // корзина

function showMiniCart(){ // вывод мини корзины
  var out="";
  var count=0;
  for (var key in cart){
    count = count + cart[key];
  }
  out +=count;
  $('.mini-cart').html(out);
}

function  loadMiniCart() { // загрузка корзины
  if (localStorage.getItem('cart')){ // проверка есть ли корзина
    cart = JSON.parse(localStorage.getItem('cart'));
    showMiniCart();
  }
}

function sendEmail(){
  var ename = $('#ename').val();
  var ephone = $('#ephone').val();
  var email = $('#email').val();
  if (ename!="" && ephone!="" && email!=""){
      $.post(
        "core/call.php",
        {
          "ename" : ename,
          "ephone" : ephone,
          "email" : email,
          "cart" : cart,
        },
        function(data){
          if (data == 1){
            alert('Запрос отправлен');
          }
          else{
            alert('Повторите');
          }
        }
      )
  }
  else{
    alert('Заполните поля');
  }
}

$(document).ready(function(){
  loadMiniCart();
  $('.order-field-send').on('click', sendEmail); // отправка письма
});
