<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela SQL</title>
    <?php require_once ('scripts.php'); ?>
</head>

<body>

    <h2>Usuários de Rede não encontrados no SIGPEC</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Usuário</th>
                <th>Nome</th>
                <th>Status</th>
                <th>Observação</th>
                <th>Atualizar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Conexão com o banco de dados
            $db_host = "localhost";
            $db_user = "root";
            $db_password = "";
            $db_name = "sisseg";

            $db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);

            // Verificar a conexão
            if ($db_connection->connect_error) {
                die("Erro ao conectar ao banco de dados: " . $db_connection->connect_error);
            }

            // Consulta SQL para buscar dados da tabela
            $sql = "SELECT usuario, nome, situacao, observacao FROM loginrede WHERE situacao = 'Inativo'";
            $result = $db_connection->query($sql);

            if ($result->num_rows > 0) {
                // Saída dos dados de cada linha
                while ($row = $result->fetch_assoc()) {
                    $status = $row["situacao"];
                    if ($status == "Inativo") {
                        echo "<tr>
                <td>" . $row["usuario"] . "</td>
                <td>" . $row["nome"] . "</td>
                <td><select class='form-select' aria-label='Default select example'>                        
                <option value='1'>Ativo</option>
                <option value='2' selected>Inativo</option>
                <option value='3'>Excluído</option>                            
              </select></td>
                <td><input class='form-control' type='text' name='observacao'" . $row["observacao"] . "</td>
                <td><button type='submit' class='btn btn-primary'>Atualizar</button></td>                        
            </tr>";
                    } else {
                        echo "<tr>
                <td>" . $row["usuario"] . "</td>
                <td>" . $row["nome"] . "</td>
                <td><select class='form-select' aria-label='Default select example'>                        
                <option value='1' selected>Ativo</option>
                <option value='2'>Inativo</option>
                <option value='3'>Excluído</option>                         
              </select></td>
                <td><input class='form-control' type='text' name='observacao'" . $row["observacao"] . "</td>
                <td><button type='submit' class='btn btn-primary'>Atualizar</button></td>                        
            </tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='3'>Nenhum registro encontrado</td></tr>";
            }

            // Fechar a conexão com o banco de dados
            $db_connection->close();
            ?>
        </tbody>
    </table>

</body>

</html>