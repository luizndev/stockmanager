<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifique se o formulário foi enviado
    $nomeArquivo = $_POST['nome_arquivo'] ?? 'arquivo'; // Nome do arquivo padrão se nenhum for fornecido
    $conteudoArquivo = $_POST['conteudo_arquivo'] ?? '<?php echo "Olá, Mundo!"; ?>'; // Conteúdo padrão do arquivo

    // Verifique se a pasta de destino existe ou crie-a
    $pastaDestino = 'stockmanager/';
    if (!is_dir($pastaDestino)) {
        mkdir($pastaDestino, 0777, true);
    }

    // Crie o arquivo .php
    $caminhoArquivo = $pastaDestino . $nomeArquivo . '.php';

    if (file_put_contents($caminhoArquivo, $conteudoArquivo) !== false) {
        echo "Arquivo '$nomeArquivo.php' criado com sucesso em '$pastaDestino'.";
    } else {
        echo "Erro ao criar o arquivo.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Criar Arquivo PHP</title>
</head>
<body>
    <form method="POST" action="">
        <label for="nome_arquivo">Nome do Arquivo:</label>
        <input type="text" name="nome_arquivo" id="nome_arquivo" required>
        <br><br>
        <label for="conteudo_arquivo">Conteúdo do Arquivo:</label>
        <textarea name="conteudo_arquivo" id="conteudo_arquivo" rows="5" required></textarea>
        <br><br>
        <input type="submit" value="Criar Arquivo">
    </form>
</body>
</html>
