var cart = {}; // корзина

function init(){ //чтение фала goods.json
  // $.getJSON("goods.json", goodsOut);
  var hash = window.location.hash.substring(1);
  console.log(hash);
  $.post(
    "admin/core.php",{
      "action" : "loadSingleGood",
      "id" : hash
    },
    goodsOut
  )
}

function goodsOut(data){//вывод товара на main
  if (data!=0){
    data = JSON.parse(data);
    console.log(data);
    var out='';
    for (var key in data){
      out +=`<div class="single-product">`;
      out +=`<p class="single-product-name">${data[key].name}</p>`;
      out +=`<img src="img/${data[key].img}" alt="${data[key].name}" class="single-product-img">`;
      out +=`<p class="single-product-discription">${data[key].discription}</p>`;
      out +=`<p class="single-product-PFC">${data[key].PFC}</p>`;
      out +=`<div class="single-product-price"> Цена: ${data[key].price} руб.</div>`;
      out +=`<button class="single-product-button add-to-cart" data-id="${key}">Купить</button>`;
      out +=`</div>`;
    }
    $('.single-product-out').html(out);
    $('.add-to-cart') .on('click', addToCart);
  }
  else{
    $('.goods-out').html('Такого товара не существует');
  }
}

function addToCart(){// добавление в карзину
  var id = $(this).attr('data-id');
  //console.log(id);
  if (cart[id] == undefined){
    cart[id] = 1; //добавление в корзину
  }
  else{
    cart[id]++ //увел на 1
  }
  showMiniCart();
  saveMiniCart();
}

function saveMiniCart(){ // сохраняем корзину
  localStorage.setItem('cart', JSON.stringify(cart)); //корзина в строку
}

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

$(document).ready(function(){
  init();
  loadMiniCart();
});
