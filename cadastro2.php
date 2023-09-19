<?php
include "connect.php";

$insertStmt = null; // Inicialize $insertStmt com null

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeItem = $_POST["nome_item"];
    $quantidade = $_POST["quantidade"];
    $dataValidade = $_POST["data_validade"];
    $almoxarifado = $_POST["almoxarifado"];
    $codigoItem = $_POST["codigo_item"];

    // Verificar se algum campo (exceto data_validade) está vazio
    if (empty($nomeItem) || empty($quantidade) || empty($almoxarifado) || empty($codigoItem)) {
        echo "Erro: Preencha todos os campos, exceto a Data de Validade.";
    } else {
        $checkSql = "SELECT * FROM tabela_itens WHERE nome_item = ? AND data_validade = ?";
        $checkStmt = mysqli_prepare($conexao, $checkSql);

        if ($checkStmt) {
            mysqli_stmt_bind_param($checkStmt, "ss", $nomeItem, $dataValidade);

            mysqli_stmt_execute($checkStmt);

            $result = mysqli_stmt_get_result($checkStmt);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $codigoItem = $row['codigo_item'];
                echo "Erro: Este item já está cadastrado.";
            } else {
                $insertSql = "INSERT INTO tabela_itens (nome_item, quantidade, data_validade, almoxarifado, codigo_item) VALUES (?, ?, ?, ?, ?)";
                $insertStmt = mysqli_prepare($conexao, $insertSql);

                if ($insertStmt) {
                    mysqli_stmt_bind_param($insertStmt, "sssss", $nomeItem, $quantidade, $dataValidade, $almoxarifado, $codigoItem);

                    if (mysqli_stmt_execute($insertStmt)) {
                        $html = "
                        <script>var playaudio = 1; var displayNotify = 1;</script>
                        <div id='notifications'>
                            <div id='sucesso'>
                                <span class='material-symbols-outlined'>done_all</span>Item Cadastrado com Sucesso!
                            </div>
                        </div>
                        ";

                        echo $html;
                    } else {
                        echo "Erro ao inserir o item: " . mysqli_error($conexao);
                    }
                    mysqli_stmt_close($insertStmt);
                } else {
                    echo "Erro na preparação da declaração de inserção: " . mysqli_error($conexao);
                }
            }

            mysqli_stmt_close($checkStmt);
        } else {
            echo "Erro na preparação da declaração de verificação: " . mysqli_error($conexao);
        }
    }

    mysqli_close($conexao);
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-cadastro.css">
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
    <audio id="notifySoundSucess" src="sounds/sucess.mp3"></audio>
    <div class="stock-onlogin" style="display: none;">
        <div class="stock-header">
            <div class="header-left">
                <img width="200px" id="clickLogotype" src="images/logotype.svg" alt="">
                <a href="index.html" >Inicio</a>
                <a href="retirada.php" >Retirada</a>
                <a href="cadastro.php" style="color: white;">Cadastro</a>
                <a href="monitoramento.php">Monitoramento</a>
            </div>
            <div class="header-right">
                <a href=""><img src="images/pesquisa.svg" alt=""></a
                <a href=""><img src="images/notificação.svg" alt=""></a>
                <a id="logout"><img id="logout" src="images/logoff.svg" alt=""></a>
                <span id="username">Usuário</span>
                <img src="images/logo.png" alt="" id="myImage2">
            </div>
        </div>
        <div class="stock-container" id="cadastro-show-container">
            <h1>Cadastro de Item - Stock Manager</h1>
            <h2>Preencha esse campos para cadastrar algum item ao banco<br>
                de dados do Stock Manager - Anhanguera</h2>

                <form method="POST" class="cadastro-form">
                    <label for="nome_item">Nome do Item</label>
                    <input type="text" name="nome_item" placeholder="Digite o nome do item">
                
                    <label for="quantidade">Quantidade</label>
                    <input type="text" name="quantidade" placeholder="Digite a quantidade">
                
                    <label for="data_validade">Data de Validade</label>
                    <input type="date" name="data_validade">
                
                    <label for="almoxarifado">Qual almoxarifado?</label>
                    <select name="almoxarifado" id="whatAlmoxarifado">
                        <option value="">Escolha o Almoxarifado</option>
                       <option value='Almoxarifado TI'>Almoxarifado TI</option>
                       <option value='Almoxarifado TI 2'>Almoxarifado TI 2</option>
                        <option value='Clínica de Fisioterapia/Psicologia'>Clínica de Fisioterapia/Psicologia</option>
                        <option value='Clínica de Odontologia'>Clínica de Odontologia</option>
                        <option value='Material de Consumo'>Material de Consumo</option>
                        <option value='EPI'>EPI</option>
                        <option value='Equipamentos de Estética'>Equipamentos de Estética</option>
                        <option value='Geral de Equipamentos e Mobília'>Geral de Equipamentos e Mobília</option>
                        <option value='Limpeza'>Limpeza</option>
                        <option value='Nutrição'>Nutrição</option>
                        <option value='Papelaria'>Papelaria</option>
                        <option value='Produtos de Estética'>Produtos de Estética</option>
                        <option value='Produtos Esportivos'>Produtos Esportivos</option>
                        <option value='Produtos Gerais'>Produtos Gerais</option>
                        <option value='Reagentes'>Reagentes</option>
                    </select>
                
                    <label for="codigo_item">Código do Item</label>
                    <input type="text" id="generateCodigo"  name="codigo_item" placeholder="Digite o código do item">
                
                    <div class="groupButton">
                        <button id="salvar" type="submit">SALVAR</button>
                        <button id="limpar" type="reset">LIMPAR</button>
                    </div>
                </form>
        </div>
        <div class="footer-stock">
            <img src="images/footerLogoo.png" width="100px" alt="">
            <span>
                Equipe de desenvolvimento por : Luis Eduardo Andrade & Matheus Pereira
            </span>
        </div>
    </div>
    <!-- <div class="stock-notify"><div class="notify-container"><div class="notify-top"><img src="images/check.png"><h1>Item cadrastado com sucesso!</h1></div><div id="notify-bottom" class="notify-bottom">Fechar</div></div></div> -->
</body>
<script type="module" src="javascript.js"></script>
</html>
<script>
    function gerarCodigo() {
      // Gere um número aleatório entre 1 e 999 para a parte do meio do código
      const numeroAleatorio = Math.floor(Math.random() * 999) + 1;

      // Gere uma letra aleatória para a parte final do código
      const letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      const letraAleatoria = letras.charAt(Math.floor(Math.random() * letras.length));

      // Crie o código completo
      const codigo = `SM-${numeroAleatorio.toString().padStart(3, '0')}${letraAleatoria}`;

      // Exiba o código no elemento com o ID "generateCodigo"
      document.getElementById("generateCodigo").value = codigo;
      console.log(codigo)
    }

    // Chame a função para gerar um código quando a página carregar
    gerarCodigo();
</script>
<style type="text/css">
    #notificacaofinish{
        color: white;
    }
    .stock-notify{
        width: 100%;
        height: 142vh;
        position: absolute;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.75);
    }
    .notify-top{
    width: calc(487.349px - 23px);
    height: 124.505px;
    flex-shrink: 0;
    border-radius: 4.537px;
    border: 0.711px solid #5B5B5B;
    background: #1E1E1E;

    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 20px;
    padding-left: 25px
    }

    .notify-container{
        margin-top: 40px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .notify-top img{
        width: 76px
    }

    .notify-top h1{
    display: flex;
    height: 29.17px;
    flex-direction: column;
    justify-content: center;
    flex-shrink: 0;
    color: #FFF;
    font-family: Sora;
    font-size: 18.498px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
    }

    .notify-bottom{
    margin-top: 10px;
    cursor: pointer;
    display: flex;
    width: 487.349px;
    height: 39.13px;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #FFF;
    text-align: center;
    font-family: Sora;
    font-size: 15.652px;
    font-style: normal;
    font-weight: 600;
    line-height: normal; 
    border-radius: 4.537px;
    border: 0.711px solid #5B5B5B;
    background: #B93737;
    }
</style>
<script type="text/javascript">
    var playaudio;
    setInterval(function() {
        if (playaudio == 1){
        playaudio = 0;
        document.getElementById("notifySoundSucess").play();
    }},100)
    var closeNotify = document.getElementById('notify-bottom');
    closeNotify.addEventListener('click', function(){
        $('.stock-notify').css('display', 'none');
    });
    setInterval(function(){
        if (displayNotify == 1){
            displayNotify = 0;
            $('#notifications').css('display', 'none');
        }
    },2000)
</script>
