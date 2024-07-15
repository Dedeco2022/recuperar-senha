<?php

// verificar o e-mail
// verificar o token 
$email = $_GET['email'];
$token = $_GET['token'];

require_once "conexao.php";
$conexao = conectar();
$sql = "SELECT * FROM recuperar_senha WHERE email = '$email' AND token = '$token'";
$resultado = executarSQL($conexao, $sql);
$recuperar = mysqli_fetch_assoc($resultado);

if($recuperar == null){
    echo "E-mail ou token incorretos. Tente fazer um novo pedido de recuperação de senha.";
    die();
} else{
    //verifivar a validade do pedido
    //verificar se o link ja foi usado
    date_default_timezone_set('America/Sao_Paulo');
    $agora = new DateTime('now');
    $data_criacao = DateTime::createFromFormat('Y-m-d H:i:s', $recuperar['data_criacao']);
    $umDia = DateInterval::createFromDateString('1 day');
    $data_expiracao = date_add($data_criacao, $umDia);
    if($agora < $data_expiracao){
        echo "Funcionou!";
    }
}