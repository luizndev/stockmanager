<?php
include "connect.php";

$almoxarifado = "Equipamentos de Estética";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-notifycation2.css">
    <link rel="stylesheet" href="style-cadastro.css">
    <link rel="shortcut icon" href="images/icone.svg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <title>StockManager - Anhanguera</title>
</head>
<body>
<div id="suportButton" class="suport-link">
        <div class="mensagem-suport" style="display: none;">
            <span>Está com duvidas, chame os administradores</span>
        </div>
        <a  title="Equipe de Desenvolvimento/Suporte" href="sobrenos.html"><img src="images/suport.svg" alt=""></a>
    </div>
  <audio id="notifySound" src="sounds/notify.mp3"></audio>
    <div class="stock-onlogin" style="display: none;">
        <div class="stock-header">
            <div class="header-left">
                <img width="200px" id="clickLogotype" src="images/logotype.svg" alt="">
                <a href="index.html" style="color: white;">Inicio</a>
                <a href="retirada.php">Retirada</a>
                <a href="cadastro.php">Cadastro</a>
                <a href="monitoramento.php">Monitoramento</a>
            </div>
            <div class="header-right">
                <a href=""><img src="images/pesquisa.svg" alt=""></a>
                <a href=""><img src="images/notificação.svg" alt=""></a>
                <a id="logout"><img id="logout" src="images/logoff.svg" alt=""></a>
                <span id="username">Usuário</span>
                <img src="images/logo.png" alt="" id="myImage2">
            </div>
        </div>
        <div class="stock-container">
          <div class="grupo-pesquisa">
            <div class="pesquisa">
                <input type="text" id="searchInput" placeholder="Pesquisar Item">
                <button><img src="images/dashicons_search.svg" id="pesquisarButton" alt="">Pesquisar</button>
            </div>
            <div class="criar-novo-item">
                <a href="cadastro.php"><button><img src="images/create.svg" alt="">Criar um novo item</button></a>
            </div>
          </div>
          <div class="tabela-design">
              <h1><?php echo $almoxarifado; ?> - Lista de Itens</h1>
              <table id="tabelaItens">
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Unidades</th>
                    <th>Validade</th>
                    <th>Codigo</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
          </div>
        </div>
    </div>
    <div class="stock-notify" style="display: none;">
      <div class="notification">
        <div class="notification-header">
          <h3 class="notification-title">Nova Notificação</h3>
          <i class="fa fa-times notification-close" id="closeNotificação"><svg width="13" height="13" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 2L20.5 20.5M21 2L2.5 20.5" stroke="#1F1F1F" stroke-width="4" stroke-linecap="round"/>
            </svg>
            </i>
        </div>
        <div class="notification-container">
          <div class="notification-media">
            <img id="myImage3" src="images/default.png" alt="" class="notification-user-avatar">
            <i class="fa fa-thumbs-up notification-reaction"></i>
          </div>
          <div class="notification-content">
            <p class="notification-text">
            <strong>Olá tudo bem?</strong>, <strong>Temos</strong> alguns itens chegando perto da data de validade!<strong></strong>
            </p>
            <span class="notification-timer">A poucos segundos...</span>
          </div>
          <span class="notification-status"></span>
        </div>
      </div>
    </div>
</body>
  <script type="module" src="javascript.js"></script>
</html>

<?php
$sql = "SELECT * FROM tabela_itens WHERE almoxarifado = ?";
$stmt = mysqli_prepare($conexao, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $almoxarifado);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $validadeStatus = "";

        $data_validade = date("d/m/Y", strtotime($row['data_validade']));

        if ($row['data_validade'] == "0000-00-00" or $row['data_validade'] == "") {
            $validadeStatus = "Não possui validade";
            $mensagemtd = '<td>' . $validadeStatus . '</td>';
        } else {
            $data_validade_timestamp = strtotime($row['data_validade']);
            $data_atual_timestamp = strtotime(date("Y-m-d"));
            $diferenca_dias = ($data_validade_timestamp - $data_atual_timestamp) / (60 * 60 * 24);

            if ($diferenca_dias <= 60) {
                $validadeStatus = $data_validade;
                $mensagemtd = '<td class="table-validate">' . $validadeStatus . '</td>';
                haveAlertValidate();
            } else {
                $validadeStatus = $data_validade;
                $mensagemtd = '<td>' . $validadeStatus . '</td>';
            }
        }

        if ($row['quantidade'] > 0) {
            $html = "<tr>";
            $html .= "<td>" . $row['nome_item'] . "</td>";
            $html .= "<td>" . $row['quantidade'] . "</td>";
            $html .= $mensagemtd;
            $html .= '<td class="code-table">' . $row['codigo_item'] . "</td>";
            $html .= "</tr>";

            echo "<script>$('#tabelaItens tbody').append('$html');</script>";
        }
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Erro na preparação da declaração: " . mysqli_error($conexao);
}

mysqli_close($conexao);
?>


<script>
const searchInput = document.getElementById("searchInput");
const table = document.getElementById("tabelaItens");
const rows = table.getElementsByTagName("tr");

searchInput.addEventListener("keyup", function () {
  const query = searchInput.value.toLowerCase();

  for (let i = 1; i < rows.length; i++) {
    const row = rows[i];
    const itemCell = row.getElementsByTagName("td")[0];

    if (itemCell) {
      const itemName = itemCell.textContent.toLowerCase();
      if (itemName.includes(query)) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    }
  }
});

<?php
$verifyCondicional = 0;

function haveAlertValidate() {
  global $verifyCondicional;
  if ($verifyCondicional == 0) {
    $audioElement = '<audio id="notifySound"></audio>';
    echo $audioElement;
    $verifyCondicional = 1;
    if ($audioElement) {
      echo '<script>document.getElementById("notifySound").play();</script>';
    }
    echo "<script>
    $('.table-validate').css('color', 'red', '!important');
    $('.stock-notify').css('display','flex');

    </script>";
    
  }
}
?>



</script>
<style>
  .table-validate{
    color: #B95737;
    font-weight: 500;
    cursor: pointer;
  }
  .code-table{
    cursor: pointer !important;
  }
</style>
<script>
  var clodeNotify = document.getElementById('closeNotificação');     
  clodeNotify.addEventListener('click',function(){
    $('.stock-notify').css('display','none');
  })
  document.addEventListener('DOMContentLoaded', function() {
            const codeTable = document.querySelector('.code-table');

            codeTable.addEventListener('click', function() {
                // Seleciona o conteúdo da tabela
                const selectedText = codeTable.textContent;

                // Cria um elemento de área de texto temporário
                const tempTextArea = document.createElement('textarea');
                tempTextArea.value = selectedText;

                // Adiciona o elemento temporário à página
                document.body.appendChild(tempTextArea);

                // Seleciona o conteúdo do elemento de área de texto
                tempTextArea.select();
                tempTextArea.setSelectionRange(0, 99999); // Para dispositivos móveis

                // Copia o texto para a área de transferência
                document.execCommand('copy');

                // Remove o elemento temporário
                document.body.removeChild(tempTextArea);

                // Exibe um alerta com o conteúdo copiado
                alert('Conteúdo copiado: ' + selectedText);
            });
        });
</script>