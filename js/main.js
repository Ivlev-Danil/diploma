var cart = {}; // корзина

function init(){ //чтение фала goods.json
  // $.getJSON("goods.json", goodsOut);
  $.post(
    "admin/core.php",{
      "action":"loadGoods"
    },
    goodsOut
  )
}

function goodsOut(data){//вывод товара на main
  data = JSON.parse(data);
  console.log(data);
  var out='';
  for (var key in data){
    out +=`<div class="product">`;
    out +=`<p class="product-name">${data[key].name}</p>`;
    out +=`<img src="img/${data[key].img}" alt="${data[key].name}" class="product-img">`;
    out +=`<div class="product-price">Цена: ${data[key].price} руб.</div>`;
    out +=`<a href="goods.html#${key}" class="product-link">Подробнее</a>`;
    out +=`<button class="product-button add-to-cart" data-id="${key}">Купить</button>`;
    out +=`</div>`;
  }
  $('.product-out').html(out);
  $('.add-to-cart') .on('click', addToCart);
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


