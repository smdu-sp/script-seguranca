<?php

$sgu_host = '10.75.32.125';
$sgu_usuario = 'root';
$sgu_senha = 'Hta123P';
$sgu_banco = 'SGU';

$sgu_conexao = new mysqli($sgu_host, $sgu_usuario, $sgu_senha, $sgu_banco);

if ($sgu_conexao->connect_error) {
    die("Erro ao conectar ao banco de dados SGU: " . $sgu_conexao->connect_error);
}





