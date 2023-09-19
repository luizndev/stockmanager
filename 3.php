<?php
include "connect.php"; // Certifique-se de incluir o arquivo de conexão adequado

// Inicialize a variável $itens
$itens = array();

// Verifique se um almoxarifado foi selecionado
if (isset($_POST["almoxarifado"])) {
    $almoxarifadoSelecionado = $_POST["almoxarifado"];

    // Buscar a lista de itens na tabela tabela_itens filtrando pelo almoxarifado selecionado
    $sqlListaItens = "SELECT codigo_item, nome_item FROM tabela_itens WHERE almoxarifado = ?";
    $stmt = mysqli_prepare($conexao, $sqlListaItens);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $almoxarifadoSelecionado);

        if (mysqli_stmt_execute($stmt)) {
            $resultado = mysqli_stmt_get_result($stmt);

            while ($linha = mysqli_fetch_assoc($resultado)) {
                // Agora você tem acesso tanto ao código_item quanto ao nome_item
                $codigoItem = $linha["codigo_item"];
                $nomeItem = $linha["nome_item"];

                // Adicione os valores ao array $itens
                $itens = array("codigo_item" => $codigoItem, "nome_item" => $nomeItem);
            }
        } else {
            echo "Erro ao executar consulta: " . mysqli_error($conexao);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Erro na preparação da declaração: " . mysqli_error($conexao);
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos do formulário foram definidos
    if (isset($_POST["nome_item"], $_POST["quantidade"], $_POST["responsavel"], $_POST["solicitante"], $_POST["data"], $_POST["codigo_item"])) {
        $nomeItem = $_POST["nome_item"];
        $quantidade = $_POST["quantidade"];
        $responsavel = $_POST["responsavel"];
        $solicitante = $_POST["solicitante"];
        $data = $_POST["data"];
        $codigoItem = $_POST["codigo_item"];

        // Inserir registro na tabela de retirada
        $sql = "INSERT INTO log_retirada (nome_item, quantidade, responsavel, solicitante, data, codigo_item) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexao, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sissss", $nomeItem, $quantidade, $responsavel, $solicitante, $data, $codigoItem);

            if (mysqli_stmt_execute($stmt)) {
                echo "Retirada registrada com sucesso!";
            } else {
                echo "Erro ao registrar retirada: " . mysqli_error($conexao);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Erro na preparação da declaração: " . mysqli_error($conexao);
        }

        // Atualizar a quantidade na tabela de itens (subtrair a quantidade retirada)
        $sqlUpdate = "UPDATE tabela_itens SET quantidade = quantidade - ? WHERE codigo_item = ?";
        $stmtUpdate = mysqli_prepare($conexao, $sqlUpdate);

        if ($stmtUpdate) {
            mysqli_stmt_bind_param($stmtUpdate, "is", $quantidade, $codigoItem);

            if (mysqli_stmt_execute($stmtUpdate)) {
                echo "Quantidade atualizada com sucesso!";
            } else {
                echo "Erro ao atualizar quantidade: " . mysqli_error($conexao);
            }

            mysqli_stmt_close($stmtUpdate);
        } else {
            echo "Erro na preparação da declaração de atualização: " . mysqli_error($conexao);
        }
    } else {
        echo "Campos do formulário não definidos corretamente.";
    }
}


mysqli_close($conexao);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-cadastro.css">
    <link rel="shortcut icon" href="images/icone.svg" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <title>StockManager - Anhanguera</title>
</head>
<body>
    <div class="stock-onlogin" style="display: block;">
        <div class="stock-header">
            <div class="header-left">
                <img width="200px" id="clickLogotype" src="images/logotype.svg" alt="">
                <a href="index.html" >Inicio</a>
                <a href="retirada.php" style="color: white;">Retirada</a>
                <a href="cadastro.php" >Cadastro</a>
                <a href="monitoramento.php">Monitoramento</a>
            </div>
            <div class="header-right">
                <a href=""><img src="images/notificação.svg" alt=""></a>
                <a id="logout"><img id="logout" src="images/logoff.svg" alt=""></a>
                <span id="username">Usuário</span>
                <img src="images/logo.png" alt="" id="myImage2">
            </div>
        </div>
        <div class="stock-container" id="cadastro-show-container">
            <h1>Retirada de Item - Stock Manager</h1>
            <h2>Preencha esse campos para retirada de algum item do banco<br>
            de dados do Stock Manager - Anhanguera</h2>
            
            <form action="" method="post" class="cadastro-form">
                <label for="almoxarifado">Almoxarifado</label>
                <select name="almoxarifado" id="almoxarifado">
                    <option value="">Selecione o Almoxarifado</option>
                        <option value='Almoxarifado TI'>Almoxarifado TI</option>
                        <option value='Almoxarifado TI 2'>Almoxarifado TI 2</option>
                        <option value='Clínica de Fisioterapia/Psicologia'>Clínica de Fisioterapia/Psicologia</option>
                        <option value='Clínica de Odontologia'>Clínica de Odontologia</option>
                        <option value='Consumo'>Consumo</option>
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
                <label for="">Nome do Item</label>
                <select list="itens" name="nome_item" id="nome_item">
                    <option value="">Seleciona o Item</option>
                    <?php foreach ($itens as $item) { ?>
                        <option value="<?php echo $item["nome_item"]; ?>" data-codigo="<?php echo $item["codigo_item"]; ?>"><?php echo $item["nome_item"]; ?></option>
                    <?php } ?>
                </select>
                <label for="">Código do Item</label>
                <input type="text" name="codigo_item"  readonly id="generateCodigo" placeholder="Digite sua resposta" readonly>
                <label for="">Quantidade</label>
                <input type="text" name="quantidade" placeholder="Digite sua resposta">

                <label for="">Qual e o responsável?</label>
                <input type="text" id="responsavelRetirada" readonly name="responsavel" placeholder="Digite sua resposta">

                <label for="">Quem e o solicitante?</label>
                <input type="text" name="solicitante" placeholder="Digite sua resposta">

                <label for="">Data</label>
                <input type="text" name="data" placeholder="Digite sua resposta" value="16/08/2023" readonly>




                <div class="groupButton">
                    <button id="salvar" type="submit">RETIRAR</button>
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
</body>
<datalist id="listItens">
    <option value="Valor">valor</option>
</datalist>
<script type="module" src="javascript.js"></script>
</html>
<script>
window.addEventListener('DOMContentLoaded', function() {
  const dataInput = document.querySelector('input[name="data"]');
  
  // Obtenha a data atual
  const dataAtual = new Date();
  
  // Formate a data no formato dd/mm/aaaa
  const dia = String(dataAtual.getDate()).padStart(2, '0');
  const mes = String(dataAtual.getMonth() + 1).padStart(2, '0'); // +1 porque os meses começam em 0
  const ano = dataAtual.getFullYear();
  
  // Combine os valores para criar a data no formato desejado
  const dataFormatada = `${dia}/${mes}/${ano}`;
  
  // Preencha o campo de data com a data formatada
  dataInput.value = dataFormatada;
});

</script>