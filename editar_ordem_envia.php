<?php
require_once("valida_session.php");
require_once ("bd/bd_ordem.php");

$codigo = $_POST["cod"];
$cod_cliente = $_POST["cod_cliente"];
$cod_terceirizado = $_POST["cod_terceirizado"];
$cod_servico = $_POST["cod_servico"];
$data_servico = $_POST["data_servico"];
$status = $_POST["status"];
$data = date("y/m/d");

// Debug
error_log("Código: $codigo");
error_log("Cod Cliente: $cod_cliente");
error_log("Cod Terceirizado: $cod_terceirizado");
error_log("Cod Serviço: $cod_servico");
error_log("Data Serviço: $data_servico");
error_log("Status: $status");

$dados = editarOrdem($codigo, $cod_cliente, $cod_terceirizado, $cod_servico, $data_servico, $status, $data);

error_log("Resultado da Edição: " . print_r($dados, true));

if ($dados == 1) {
    $_SESSION['texto_sucesso'] = 'Os dados da ordem de serviço foram alterados no sistema.';
    header("Location: ordem.php");
} else {
    $_SESSION['texto_erro'] = 'Os dados da ordem de serviço não foram alterados no sistema! Detalhes: ' . $dados;
    header("Location: ordem.php");
}

?>
