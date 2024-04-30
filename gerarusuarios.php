<?php
require "scripts.php";

// Conexão com o banco de dados SGU
$sgu_host = '10.75.32.125';
$sgu_usuario = 'root';
$sgu_senha = 'Hta123P';
$sgu_banco = 'SGU';

$sgu_conexao = new mysqli($sgu_host, $sgu_usuario, $sgu_senha, $sgu_banco);

if ($sgu_conexao->connect_error) {
    die("Erro ao conectar ao banco de dados SGU: " . $sgu_conexao->connect_error);
}

// Conexão com o banco de dados SISSEG (local)
$sisseg_host = 'localhost';
$sisseg_usuario = 'root';
$sisseg_senha = '';
$sisseg_banco = 'sisseg';

$sisseg_conexao = new mysqli($sisseg_host, $sisseg_usuario, $sisseg_senha, $sisseg_banco);

if ($sisseg_conexao->connect_error) {
    die("Erro ao conectar ao banco de dados SISSEG: " . $sisseg_conexao->connect_error);
}

// Obter o nome da tabela do SGU com base no ano e mês atuais
$nome_tabela_sgu = date('Y_m');

// Query para selecionar os dados da tabela no banco SGU
$sgu_query = "SELECT cpID, cpNome, cpRF, cpUnid, cpEspecie FROM $nome_tabela_sgu";

$sgu_resultado = $sgu_conexao->query($sgu_query);

$usuarios_adicionados = array();

// Iterar sobre os resultados
while ($row = $sgu_resultado->fetch_assoc()) {
    // Verificar se o valor de cpRF já existe na tabela do SISSEG
    $rf = $row['cpRF'];
    $verificar_existencia_query = "SELECT COUNT(*) AS total FROM servidor WHERE rf = '$rf'";
    $resultado_verificacao = $sisseg_conexao->query($verificar_existencia_query);
    $total_registros = $resultado_verificacao->fetch_assoc()['total'];

    if ($total_registros == 0) {
        // Copiar os dados para o banco de dados SISSEG
        $id = $row['cpID'];
        $nome = $row['cpNome'];
        $loginrede = 'D' . substr($row['cpRF'], 0, -1);
        $email = '';
        $rf = $row['cpRF'];
        $unidadeatual = $row['cpUnid'];
        $situacao = 'Ativo';

        // Query para inserir os dados no banco SISSEG
        $sisseg_query = "INSERT INTO servidor (id, nome, loginrede, email, rf, unidadeatual, situacao) 
                         VALUES ('$id', '$nome', '$loginrede', '$email', '$rf', '$unidadeatual', '$situacao')";

        if ($sisseg_conexao->query($sisseg_query) === TRUE) {
            // Adicionar nome do usuário ao array
            $usuarios_adicionados[] = $nome;
        } else {
            echo "Erro ao inserir dados no SISSEG: " . $sisseg_conexao->error;
        }
    }
}



// Mostrar usuários adicionados
if (!empty($usuarios_adicionados)) {
    echo "<table class='table'>
        <thead class='table-dark'>
            <tr>             
                <th>Nome</th>
            </tr>
        </thead>
        <tbody>";
    foreach ($usuarios_adicionados as $usuario) {
        echo "<tr>
        <td>" . $usuario . "</td>
        </tr>";

    }
} else {
    echo "<h3>Nenhum usuário adicionado no SISSEG.</h3>";
}

echo "</tbody></table><br> <h2>Total de usuários adicionados: " . count($usuarios_adicionados) . "</h2><br>";

echo "<a href='index.php' class='btn btn-primary'>Voltar</a>";

$sgu_conexao->close();
$sisseg_conexao->close();


