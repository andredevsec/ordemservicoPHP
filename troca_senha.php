<?php
session_start();
require_once("bd/bd_usuario.php");
require_once("bd/bd_cliente.php");
require_once("bd/bd_terceirizado.php");

if (empty($_POST['email']) || empty($_POST['senha']) || empty($_POST['perfil'])) {
    $_SESSION['mensagem_erro'] = 'Por favor, preencha todos os campos!';
    header("Location: troca_senha_form.php");
    exit();
}

$email = $_POST["email"];
$nova_senha = md5($_POST["senha"]);
$perfil = $_POST["perfil"];

switch ($perfil) {
    case '1':
        $usuarioExiste = buscaUsuario($email);
        if ($usuarioExiste > 0) {
            $conexao = conecta_bd();
            $query = "SELECT * FROM usuario WHERE email='$email'";
            $resultado = mysqli_query($conexao, $query);
            $dadosUsuario = mysqli_fetch_assoc($resultado);
            
            $resultado = editarSenhaUsuario($dadosUsuario['cod'], $nova_senha);
            if ($resultado) {
                $_SESSION['mensagem_sucesso'] = 'Senha alterada com sucesso!';
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['mensagem_erro'] = 'Erro ao alterar a senha do usuário.';
                header("Location: troca_senha_form.php");
                exit();
            }
        } else {
            $_SESSION['mensagem_erro'] = 'Usuário não encontrado.';
            header("Location: troca_senha_form.php");
            exit();
        }
        break;
        
    case '2':
        $clienteExiste = buscaCliente($email);
        if ($clienteExiste > 0) {
            $conexao = conecta_bd();
            $query = "SELECT * FROM cliente WHERE email='$email'";
            $resultado = mysqli_query($conexao, $query);
            $dadosCliente = mysqli_fetch_assoc($resultado);
            
            $resultado = editarSenhaCliente($dadosCliente['cod'], $nova_senha);
            if ($resultado) {
                $_SESSION['mensagem_sucesso'] = 'Senha alterada com sucesso!';
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['mensagem_erro'] = 'Erro ao alterar a senha do cliente.';
                header("Location: troca_senha_form.php");
                exit();
            }
        } else {
            $_SESSION['mensagem_erro'] = 'Cliente não encontrado.';
            header("Location: troca_senha_form.php");
            exit();
        }
        break;

    case '3':
        $terceirizadoExiste = buscaTerceirizado($email);
        if ($terceirizadoExiste > 0) {
            $conexao = conecta_bd();
            $query = "SELECT * FROM terceirizado WHERE email='$email'";
            $resultado = mysqli_query($conexao, $query);
            $dadosTerceirizado = mysqli_fetch_assoc($resultado);
            
            $resultado = editarSenhaTerceirizado($dadosTerceirizado['cod'], $nova_senha);
            if ($resultado) {
                $_SESSION['mensagem_sucesso'] = 'Senha alterada com sucesso!';
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['mensagem_erro'] = 'Erro ao alterar a senha do terceirizado.';
                header("Location: troca_senha_form.php");
                exit();
            }
        } else {
            $_SESSION['mensagem_erro'] = 'Terceirizado não encontrado.';
            header("Location: troca_senha_form.php");
            exit();
        }
        break;

    default:
        $_SESSION['mensagem_erro'] = 'Perfil inválido!';
        header("Location: troca_senha_form.php");
        exit();
}

$_SESSION['mensagem_erro'] = 'Email não encontrado!';
header("Location: troca_senha_form.php");
exit();
?>
