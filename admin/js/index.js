document.getElementById('check').onclick = function(){
  let login = document.getElementById('login').value;
  let password = document.getElementById('password').value;

  if (login == 'admin' && password == 'admin'){
    window.location.href = 'admin.html';
  }

  else{
    alert('неправильный логин или пароль');
  }
}
