import credentials from './config.js';
var namePessoa;
document.addEventListener('DOMContentLoaded', function() {
  const loginButton = document.getElementById('login-button');
  const logoutButton = document.getElementById('logout');
  const usernameElement = document.getElementById('username');

  loginButton.addEventListener('click', function() {
    const email = document.getElementById('email').value;
    const senha = document.getElementById('senha').value;

    var user = credentials.find(cred => cred.email === email && cred.password === senha);

    if (user) {
      localStorage.setItem('loggedInUser', JSON.stringify(user));
      usernameElement.textContent = user.name;
      usernameElement.value = user.name;
      document.getElementById('stock-login').style.display = 'none';
      document.querySelector('.stock-onlogin').style.display = 'block';
      location.href = "index.html"; // Redireciona para index.html após o login
    } else {
      alert('Credenciais inválidas');
    }
  });

  logoutButton.addEventListener('click', function() {
    localStorage.removeItem('loggedInUser');
    document.getElementById('stock-login').style.display = 'block';
    document.querySelector('.stock-onlogin').style.display = 'none';
    location.href = "index.html"; // Redireciona para index2.php após o logout
  });
});

const loggedInUser = JSON.parse(localStorage.getItem('loggedInUser'));

if (loggedInUser) {
  const usernameElement = document.getElementById('username');
  usernameElement.textContent = loggedInUser.name;

  const imageElement = document.getElementById('myImage2');
  imageElement.src = loggedInUser.photoURL;
  $('#stock-login').css('display', 'none');
  $('.stock-onlogin').css('display', 'block');
}

const currentPage = window.location.pathname.split('/').pop();

if (currentPage === "monitoramento.php") {
  if (loggedInUser && loggedInUser.name === "Elikais Souza" || loggedInUser && loggedInUser.name === "Mauro Araújo" || loggedInUser && loggedInUser.name === "Matheus Pereira") {
    console.log("Esse usuario tem permissão para acessar essa pagina!")
  } else {
    alert("Você não tem permissão para acessar esta página!");
    location.href = "index.html";
  }
}

var usernameEscrever = document.getElementById('username').textContent;
document.getElementById('responsavelRetirada').value = usernameEscrever;


var suportButton = document.getElementById('suportButton');
suportButton.addEventListener('mouseover', function(event) {
  // Seu código aqui
  $('.mensagem-suport').css('display', 'block');
});

suportButton.addEventListener('mouseout', function(event) {
  // Seu código aqui
  $('.mensagem-suport').css('display', 'none');
});

