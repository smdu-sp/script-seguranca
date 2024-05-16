<?php

require 'scripts.php';
require 'conexaoSGU.php';

// Obtendo o ano e o mês atual
$anoAtual = date("Y");
$mesAtual = date("m");

// Calculando o mês anterior
$anoMesAnterior = date("Y_m", strtotime("-1 month"));

// Nome das tabelas
$tabelaAtual = $anoAtual . "_" . $mesAtual;
$tabelaAnterior = $anoMesAnterior;

$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'sisseg';

$sisseg_conexao = new mysqli($host, $usuario, $senha, $banco);

// Consulta SQL para encontrar funcionários que estão na tabela do mês anterior, mas não na tabela do mês atual
$sql = "SELECT ant.cpRF, ant.cpNome, ant.cpUnid
        FROM $tabelaAnterior ant
        LEFT JOIN $tabelaAtual atual ON ant.cpRF = atual.cpRF
        WHERE atual.cpRF IS NULL";

$result = $sgu_conexao->query($sql);

echo "<table class='table'>
        <thead class='table-dark'>
            <tr>
                <th>RF</th>
                <th>Usuário de rede</th>
                <th>Nome</th>               
            </tr>
        </thead>
        <tbody>";



if ($result->num_rows > 0) {
    // Exibir os resultados
    while ($row = $result->fetch_assoc()) {                  
        $rede = "D". substr($row["cpRF"], 0, -1);
        echo "<tr>
                <td>" . $row["cpRF"] . "</td>
                <td>" . $rede . "</td>
                <td>" . $row["cpNome"] . "</td>                
              </tr>";                
    }
} else {
    echo "<tr><td colspan='2'>Não houve exonerações esse mês</td></tr>";
}

echo "</tbody>
    </table>";   

// Fechar conexão com o banco de dados
$sgu_conexao->close();

echo "<br><a href='index.php' class='btn btn-primary'>Voltar</a>";

?>
