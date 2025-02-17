<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cartoes'])) {
    $cartoes = $_POST['cartoes'];
    $cartoesArray = explode("\n", $cartoes);
    $binEspecificas = [
        '498401', '498442', '498408', '498453', '498407',
        '485464', '407843', '498431', '404024', '415274',
        '407838', '550209', '516292', '553636', '601100', '527519'
    ];
    $resultados = [];

    foreach ($cartoesArray as $cartao) {
        $cartao = trim($cartao);
        foreach ($binEspecificas as $bin) {
            if (strpos($cartao, $bin) === 0) { // Verifica se o cartão começa com uma das BINs específicas
                // Divide a linha em seus componentes
                list($numero, $mes, $ano, $cvv) = explode('|', $cartao);
                // Formata o ano para dois dígitos
                $ano = substr($ano, -2);
                // Reconstrói a linha no formato desejado
                $resultadoFormatado = "$numero|$mes|$ano|$cvv";
                $resultados[] = $resultadoFormatado;
                break; // Para evitar múltiplos matches para o mesmo cartão
            }
        }
    }

    // Nome do arquivo onde os resultados serão salvos
    $fileName = 'resultados.txt';

    // Abre o arquivo para escrita
    $file = fopen($fileName, 'a');
    if ($file) {
        foreach ($resultados as $resultadoFormatado) {
            fwrite($file, $resultadoFormatado . PHP_EOL);
        }
        fclose($file);
    }

    // Retorna os resultados filtrados e formatados para exibição no site
    foreach ($resultados as $resultadoFormatado) {
        echo "<li>" . htmlspecialchars($resultadoFormatado) . "</li>";
    }
} else {
    echo "Nenhum dado de cartão recebido ou método não é POST.";
}
?>
