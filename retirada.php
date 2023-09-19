<?php
include "connect.php"; // Certifique-se de incluir o arquivo de conexão adequado

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
                echo "<div class='stock-notify'><div class='notify-container'><div class='notify-top'><img src='images/check-gif.gif'><h1>Quantidade atualizada com sucesso!</h1></div><div id='notify-bottom' class='notify-bottom'>Fechar</div></div></div><script>var playaudio = 1;</script";
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

// Buscar a lista de itens na tabela tabela_itens para o datalist
$sqlListaItens = "SELECT codigo_item, nome_item, almoxarifado, quantidade FROM tabela_itens";
$resultado = mysqli_query($conexao, $sqlListaItens);

if ($resultado) {
    $itens = array();
    while ($linha = mysqli_fetch_assoc($resultado)) {
        // Agora você tem acesso tanto ao código_item quanto ao nome_item
        $codigoItem = $linha["codigo_item"];
        $nomeItem = $linha["nome_item"];
        $almoxarifadoItem = $linha["almoxarifado"];
        $quantidade = $linha["quantidade"];

        // Adicione os valores ao array $itens (ou faça o que desejar com eles)
        $itens[] = array("codigo_item" => $codigoItem, "nome_item" => $nomeItem,  "almoxarifado" => $almoxarifadoItem ,  "quantidade" => $quantidade);
    }
} else {
    echo "Erro ao buscar lista de itens: " . mysqli_error($conexao);
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
<div id="suportButton" class="suport-link">
        <div class="mensagem-suport" style="display: none;">
            <span>Está com duvidas, chame os administradores</span>
        </div>
        <a  title="Equipe de Desenvolvimento/Suporte" href="sobrenos.html"><img src="images/suport.svg" alt=""></a>
    </div>
    <audio id="notifySoundSucess" src="sounds/sucess.mp3"></audio>
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
                <span id="username"></span>
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
                <label for="">Nome do Item</label>
               <select list="itens" name="nome_item" id="nome_item">
                    <option value="">Selecione algum Item</option>
                    <?php foreach ($itens as $item) {
                        if ($item['quantidade'] > 0) {
                    ?>
                        <option value="<?php echo $item["nome_item"]; ?>" data-codigo="<?php echo $item["codigo_item"]; ?>" data-almoxarifado="<?php echo $item["almoxarifado"]; ?>">
                            <?php echo $item["nome_item"]; ?> (<?php echo $item["codigo_item"]; ?>)
                        </option>
                    <?php
                        }
                    }
                    ?>
                </select>


                <label for="">Código do Item</label>
                <input type="text" name="codigo_item"  readonly id="generateCodigo" placeholder="Digite sua resposta">
                <label for="">Quantidade</label>
                <input type="text" name="quantidade" placeholder="Digite sua resposta">

                <label for="">Qual e o responsável?</label>
                <!-- readonly -->
                <input type="text" id="responsavelRetirada" readonly name="responsavel" placeholder="Digite sua resposta">

                <label for="">Quem e o solicitante?</label>
                <input type="text" name="solicitante" placeholder="Digite sua resposta">

                <label for="">Data</label>
                <input type="text" name="data" readonly placeholder="Digite sua resposta" value="16/08/2023">




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
    function gerarCodigo() {
      // Gere um número aleatório entre 1 e 999 para a parte do meio do código
      const numeroAleatorio = Math.floor(Math.random() * 999) + 1;

      // Gere uma letra aleatória para a parte final do código
      const letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      const letraAleatoria = letras.charAt(Math.floor(Math.random() * letras.length));

      // Crie o código completo
      const codigo = `SM-${numeroAleatorio.toString().padStart(3, '0')}${letraAleatoria}`;

      // Exiba o código no elemento com o ID "generateCodigo"
      document.getElementById("generateCodigo").textContent = codigo;
    }

    // Chame a função para gerar um código quando a página carregar
    gerarCodigo();

    // Adicione um ouvinte de evento para quando um item for selecionado no <select>
    document.getElementById("nome_item").addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];
        const codigo = selectedOption.getAttribute("data-codigo");

        // Preencha o campo de código com o código do item selecionado
        document.getElementById("generateCodigo").value = codigo;
    });
</script>
<script>
    // Referência aos elementos do DOM
    const almoxarifadoSelect = document.getElementById('almoxarifado');
    const nomeItemSelect = document.getElementById('nome_item');
    const nomeItemOptions = [...nomeItemSelect.options]; // Cria uma cópia das opções originais

    // Event listener para o campo "Almoxarifado"
    almoxarifadoSelect.addEventListener('change', () => {
        const selectedAlmoxarifado = almoxarifadoSelect.value;

        // Limpar as opções do campo "Nome do Item"
        nomeItemSelect.innerHTML = '';

        // Adicionar as opções correspondentes
        nomeItemOptions.forEach(option => {
            const dataAlmoxarifado = option.getAttribute('data-almoxarifado');

            if (dataAlmoxarifado === selectedAlmoxarifado || selectedAlmoxarifado === '') {
                nomeItemSelect.appendChild(option.cloneNode(true));
            }
        });

        // Adicionar a opção "Selecione o Item"
        nomeItemSelect.insertBefore(document.createElement('option'), nomeItemSelect.firstChild);
        nomeItemSelect.options[0].text = 'Selecione o Item';
        nomeItemSelect.options[0].value = '';
    });
</script>

<script>
    // Função para obter a data atual no formato "YYYY-MM-DD"
    function obterDataAtual() {
        const dataAtual = new Date();
        const ano = dataAtual.getFullYear();
        const mes = String(dataAtual.getMonth() + 1).padStart(2, '0'); // +1 porque os meses começam em 0
        const dia = String(dataAtual.getDate()).padStart(2, '0');
        return `${dia}/${mes}/${ano}`;
    }

    // Obtenha o elemento de entrada pelo nome "data"
    const dataInput = document.querySelector('input[name="data"]');

    // Defina o valor do input como a data atual
    dataInput.value = obterDataAtual();

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

</script>
