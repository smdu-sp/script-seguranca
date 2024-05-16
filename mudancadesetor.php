<?php

require 'scripts.php';
require 'conexaoSGU.php';

// Obtendo o ano e o mês atual
// Obter o nome da tabela do SGU com base no ano e mês atual e passado
$ano_mes_atual = date('Y_m');
$ano_mes_passado = date('Y_m', strtotime('-1 month'));

// Query para selecionar os dados da tabela no banco SGU para os meses atual e passado
$sgu_query = "SELECT s1.cpNome, s1.cpRF, u.sigla 
              FROM $ano_mes_atual s1
              INNER JOIN unidade u ON s1.cpUnid = u.id               
              WHERE cpEspecie = 'REMOCAO'";

$sgu_resultado = $sgu_conexao->query($sgu_query);

$usuarios_diferentes_unidades = array();

// Iterar sobre os resultados
while ($row = $sgu_resultado->fetch_assoc()) {
    // Adicionar usuário ao array
    $usuarios_diferentes_unidades[] = $row;
}

echo "<table class='table'>
<thead class='table-dark'>
    <tr>
        <th>RF</th>
        <th>Usário de rede</th>
        <th>Nome</th>           
        <th>Unidade Atual</th>        
    </tr>
</thead>
<tbody>";

// Mostrar usuários com unidades diferentes entre os meses atual e passado
if (!empty($usuarios_diferentes_unidades)) {
    foreach ($usuarios_diferentes_unidades as $usuario) {
        $loginrede = 'D' . substr($usuario['cpRF'], 0, -1);
        echo "<tr>
                <td>" . $usuario['cpRF'] . "</td>
                <td>" . $loginrede . "</td>
                <td>" . $usuario['cpNome'] . "</td>               
                <td class='table-success'>" . $usuario['sigla'] . "</td>                
              </tr>";  
    }
} else {
    echo "<tr><td colspan='4'>Nenhum usuário com unidades diferentes entre os meses atual e passado.</td></tr>";
}

echo "</tbody></table><br>Total de usuários com unidades diferentes entre os meses atual e passado: " . count($usuarios_diferentes_unidades) . "<br>";
