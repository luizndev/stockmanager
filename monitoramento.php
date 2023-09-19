
<?php
    include "connect.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-cadastro.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="/website/css/uicons-solid-rounded.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/icone.svg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<script>
    $(document).ready(function () {
        // Calcular a soma da coluna "quantidade" da tabela "log_retirada" usando PHP
        <?php
            $sql = "SELECT SUM(quantidade) as quantidade FROM log_retirada";
            $result = mysqli_query($conexao, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalRetiradas = $row['quantidade'];
        ?>

        // Calcular o total da coluna "quantidade" da tabela "tabelaItens" usando PHP
        <?php
            $sql = "SELECT SUM(quantidade) as quantidade FROM tabela_itens";
            $result = mysqli_query($conexao, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalItens = $row['quantidade'];
        ?>

        // Exibir os valores em um alert usando JavaScript
        var totalRetiradasJS = <?php echo $totalRetiradas; ?>;
        var totalItensJS = <?php echo $totalItens; ?>;
        var retiradaItens = totalRetiradasJS;
        var itensRestantes = totalItensJS;
        $('#retiradas').css('width', retiradaItens)
        $('#itensRestantes').css('width', itensRestantes) 
        document.getElementById('itens-ativos').innerHTML = itensRestantes + " itens";
        document.getElementById('itens-inativos').innerHTML = retiradaItens + " itens";
        document.getElementById('title-itensRestantes').innerHTML = itensRestantes;
        document.getElementById('itensRetirada').innerHTML = retiradaItens;
    });
</script>

    <div class="stock-onlogin" style="display: block;">
        <div class="stock-header">
            <div class="header-left">
                <img width="200px" id="clickLogotype" src="images/logotype.svg" alt="">
                <a href="index.html" >Inicio</a>
                <a href="retirada.php">Retirada</a>
                <a href="cadastro.php" >Cadastro</a>
                <a href="monitoramento.php" style="color: white;">Monitoramento</a>
            </div>
            <div class="header-right">
                <a href=""><img src="images/notificação.svg" alt=""></a>
                <a id="logout"><img id="logout" src="images/logoff.svg" alt=""></a>
                <span id="username">Usuário</span>
                <img src="images/logo.png" alt="" id="myImage2">
            </div>
        </div>
        <div class="stock-container" id="cadastro-show-container">
            <h1>Monitoramento - Stock Manager</h1>
            <div class="show-container">
                <div class="show-container-group-one">
                    <div class="group-two-status">
                        <h1>Total de Retiradas <span class="material-symbols-outlined">info</span></h1>
                        <div class="two-status-primary">
                            <h1 id="itensRetirada">546</h1>
                            <span>Retiradas</span>
                        </div>
                        <div class="two-status-bar">
                            <div id="retiradas" class="two-status-display"></div>
                        </div>
                    </div>
                </div>
                <div class="show-container-group-two" style="margin-top: 50px;">
                    <div class="group-two-status">
                        <h1>Total de Itens <span class="material-symbols-outlined">info</span></h1>
                        <div class="two-status-primary">
                            <h1 id="title-itensRestantes"></h1>
                            <span>Itens Restantes</span>
                        </div>
                        <div class="two-status-bar">
                            <div id="itensRestantes" class="two-status-display"></div>
                        </div>
                    </div>
                    <div class="group-two-status-bottom">
                        <div class="group-ativos">
                            <h2 id="title-group">Itens Ativos</h2>
                            <span id="itens-ativos">546 itens</span>
                        </div>
                        <div class="group-inativos">
                            <h2 id="title-group2">Itens Inativos</h2>
                            <span id="itens-inativos">394 itens</span>
                        </div>
                    </div>
                </div>
                <div class="grupo-pesquisa" style="width: 54.72725rem;border-radius: 220px !important; margin-bottom: -30px;">
                    <div class="pesquisa">
                        <input type="text" id="searchInput" placeholder="Pesquisar Item">
                        <button><img src="images/dashicons_search.svg" id="pesquisarButton" alt="">Pesquisar</button>
                    </div>
                </div>
                <div class="show-container-group-history"><div class="tabela-design">
                    <h1>Historico de Retiradas</h1>
                    <table id="tabelaItens" style="width: 53.72725rem;">
                        <thead>
                      <tr>
                          <th>Colaborador(a)</th>
                          <th>Responsavel</th>
                          <th>Item</th>
                          <th>Quantidade</th>
                          <th>Data</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div></div>
        </div>
    </div>
    <div class="footer-stock">
        <img src="images/footerLogoo.png" width="100px" alt="">
        <span>
            Equipe de desenvolvimento por : Luis Eduardo Andrade & Matheus Pereira
        </span>
    </div>
</div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
<script type="module" src="javascript.js"></script>
</html>
<style>
    .progress-container {
        position: relative;
        width: 150px;
        height: 150px;
    }
    
    .progress-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 24px;
    }
    
    .progress {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #e0e0e0;
        position: relative;
    }
    
    .progress-circle {
        position: absolute;
        width: 100%;
        height: 100%;
    border-radius: 50%;
    clip: rect(0, 50%, 100%, 0);
    background-color: #3498db;
}
</style>
<script>
var retiradaItens = 506;
var itensRestantes = 100;
$('#retiradas').css('width', retiradaItens)
$('#itensRestantes').css('width', itensRestantes) 
document.getElementById('itens-ativos').innerHTML = itensRestantes + " itens";
document.getElementById('itens-inativos').innerHTML = retiradaItens + " itens";
document.getElementById('title-itensRestantes').innerHTML = itensRestantes;
</script>


<?php
$sql = "SELECT * FROM log_retirada";
$stmt = mysqli_prepare($conexao, $sql);

if ($stmt) {
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $html = "<tr>";
        $html .= "<td>" . $row['solicitante'] . "</td>";
        $html .= "<td>" . $row['responsavel'] . "</td>";
        $html .= '<td>' . $row['nome_item'] . '</td>';
        $html .= '<td>' . $row['quantidade'] . "</td>";
        $html .= '<td>' . $row['data'] . "</td>";
        $html .= "</tr>";
        echo "<script>$('#tabelaItens tbody').append('$html');</script>";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Erro na preparação da declaração: " . mysqli_error($conexao);
}

mysqli_close($conexao);
?>
<script>
        var input = document.getElementById('searchInput');
        var tabela = document.getElementById('tabelaItens');
        var linhas = tabela.getElementsByTagName('tr');

        input.addEventListener('input', function () {
            var filtro = input.value.toLowerCase();

            for (var i = 1; i < linhas.length; i++) { // Começa em 1 para ignorar a linha de cabeçalho
                var colaborador = linhas[i].getElementsByTagName('td')[0].textContent.toLowerCase();
                if (colaborador.includes(filtro)) {
                    linhas[i].style.display = ''; // Mostra a linha se o colaborador for encontrado
                } else {
                    linhas[i].style.display = 'none'; // Oculta a linha se o colaborador não for encontrado
                }
            }
        });
    </script>