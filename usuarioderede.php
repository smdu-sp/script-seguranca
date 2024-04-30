<?php

$ldap_username = "usr_SMDU_Freenas"; // Nome de usuário com privilégios de leitura no AD
$ldap_password = "Prodam01"; // Senha do usuário com privilégios de leitura no AD
$base_dn = "ou=Users,ou=SMUL,dc=rede,dc=sp"; // DN da OU que contém os usuários no AD

// Conectar ao servidor LDAP
$ldap_connection = ldap_connect("ldap://10.10.68.49");

if ($ldap_connection) {
    // Autenticar no servidor LDAP
    $bind = ldap_bind($ldap_connection, $ldap_username, $ldap_password);

    if ($bind) {
        $pageSize = 1000;
        $cookie = '';

        do {
            // Definir o controle LDAP estendido para paginação
            $controls = [['oid' => LDAP_CONTROL_PAGEDRESULTS, 'value' => ['size' => 2, 'cookie' => $cookie]]];

            $result = ldap_search(
                $ldap_connection,
                $base_dn,
                "(objectClass=user)",
                array("samaccountname", "cn"),
                0,
                0,
                0,
                LDAP_DEREF_NEVER,
                $controls
            );

            ldap_parse_result($ldap_connection, $result, $errcode, $matcheddn, $errmsg, $referrals, $controls);

            $db_host = "localhost";
            $db_user = "root";
            $db_password = "";
            $db_name = "sisseg";

            $db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

            // Processar resultados
            $entries = ldap_get_entries($ldap_connection, $result);
            for ($i = 0; $i < $entries['count']; $i++) {

                $login = $entries[$i]["samaccountname"][0];
                $nome = $entries[$i]["cn"][0];

                // Convertendo para UTF-8 (se necessário)
                $login_utf8 = mb_convert_encoding($login, 'UTF-8', 'UTF-8');
                $nome_utf8 = mb_convert_encoding($nome, 'UTF-8', 'UTF-8');

                mysqli_set_charset($db_connection, "utf8mb4");

                $escaped_login = mysqli_real_escape_string($db_connection, $login_utf8);
                $escaped_nome = mysqli_real_escape_string($db_connection, $nome_utf8);

                $insert_query = "INSERT INTO loginrede (usuario, nome) VALUES ('$escaped_login', '$escaped_nome')";

                $insert_result = mysqli_query($db_connection, $insert_query);

            }

            // Obter o cookie de controle para a próxima página
            if (isset($controls[LDAP_CONTROL_PAGEDRESULTS]['value']['cookie'])) {
                $cookie = $controls[LDAP_CONTROL_PAGEDRESULTS]['value']['cookie'];
            } else {
                $cookie = '';
            }

        } while ($cookie !== null && $cookie != '');

    } else {
        echo "Falha na autenticação no servidor LDAP.";
    }

    // Fechar a conexão LDAP
    ldap_close($ldap_connection);
} else {
    echo "Falha na conexão com o servidor LDAP.";
}

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "sisseg";

$db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);

// Verificar a conexão
if ($db_connection->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $db_connection->connect_error);
}

// Consulta SQL para comparar e atualizar os registros
$sql = "UPDATE loginrede lr
        LEFT JOIN servidor s ON lr.usuario COLLATE utf8mb4_unicode_ci = s.loginrede COLLATE utf8mb4_unicode_ci
        SET lr.servidor = IFNULL(s.id, 0),
            lr.situacao = IF(s.id IS NOT NULL, 'Ativo', 'Inativo')";

// Executar a consulta
if ($db_connection->query($sql) === TRUE) {
    echo "Atualização concluída com sucesso.";
} else {
    echo "Erro ao executar a atualização: " . $db_connection->error;
}

header('Location: index.html');
?>