<?php

require_once ('scripts.php');

$ldapServers = array(
    'ldap://10.10.53.10',
    'ldap://10.10.53.11',
    'ldap://10.10.53.12',
    'ldap://10.10.64.213',
    'ldap://10.10.65.242',
    'ldap://10.10.65.90',
    'ldap://10.10.65.91',
    'ldap://10.10.66.85',
    'ldap://10.10.68.42',
    'ldap://10.10.68.43',
    'ldap://10.10.68.44',
    'ldap://10.10.68.45',
    'ldap://10.10.68.46',
    'ldap://10.10.68.47',
    'ldap://10.10.68.48',
    'ldap://10.10.68.49'
);

$ldapUser = 'usr_smdu_freenas'; // Nome de usuário com permissão para fazer consultas LDAP
$ldapPass = 'Prodam01'; // Senha do usuário LDAP
$ldapBaseDn = 'ou=Users,ou=SMUL,dc=rede,dc=sp'; // DN da base LDAP onde os usuários estão localizados

// Definir a quantidade de dias para a verificação
$diasParaVerificar = 30; // Altere este valor conforme necessário

// Calcular o timestamp para a data limite
$dataLimite = strtotime("-$diasParaVerificar days");

// Array para armazenar o último logon de cada usuário
$lastLogons = array();

foreach ($ldapServers as $ldapServer) {
    // Conectar ao servidor LDAP
    $ldapConn = ldap_connect($ldapServer);
    ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);

    if ($ldapConn) {
        // Fazer bind com as credenciais do usuário LDAP
        $ldapBind = ldap_bind($ldapConn, $ldapUser, $ldapPass);

        if ($ldapBind) {
            // Pesquisar por todos os usuários no OU
            $searchFilter = "(objectClass=user)";
            $searchResult = ldap_search($ldapConn, $ldapBaseDn, $searchFilter);

            if ($searchResult) {
                $entries = ldap_get_entries($ldapConn, $searchResult);

                if ($entries['count'] > 0) {
                    // Iterar sobre os resultados e encontrar o último logon de cada usuário
                    for ($i = 0; $i < $entries['count']; $i++) {
                        // Verificar se o campo 'lastlogontimestamp' está presente e não é nulo
                        if (isset($entries[$i]['lastlogontimestamp']) && $entries[$i]['lastlogontimestamp'] !== null) {
                            $user = $entries[$i]['samaccountname'][0];
                            $lastLogonTimestamp = $entries[$i]['lastlogontimestamp'][0];
                            $nome = $entries[$i]['cn'][0]; // Movido aqui para dentro do loop

                            // Verificar se este é o logon mais recente para este usuário
                            if (!isset($lastLogons[$user]) || $lastLogonTimestamp > $lastLogons[$user]['timestamp']) {
                                $lastLogons[$user] = array(
                                    'timestamp' => $lastLogonTimestamp,
                                    'server' => $ldapServer,
                                    'nome' => $nome // Adicionado o nome aqui
                                );
                            }
                        }
                    }
                } else {
                    echo "Nenhum usuário encontrado em $ldapServer.\n";
                }
            } else {
                echo "Erro ao pesquisar usuários em $ldapServer.\n";
            }
        } else {
            echo "Erro ao fazer bind com o servidor LDAP em $ldapServer.\n";
        }

        // Fechar a conexão LDAP
        ldap_close($ldapConn);
    } else {
        echo "Não foi possível conectar ao servidor LDAP em $ldapServer.\n";
    }
}

echo "<table class='table table-bordered'>
<thead class='table-dark'>
<tr>
    <th>Usuário</th>
    <th>Nome</th>
    <th>Último logon</th>
</tr>
</thead>";

// Exibir o último logon de cada usuário que ocorreu antes da data limite
foreach ($lastLogons as $user => $logonInfo) {
    $lastLogonDate = date('Y-m-d H:i:s', ($logonInfo['timestamp'] / 10000000) - 11644473600);
    $dataLogonTimestamp = strtotime($lastLogonDate);
    // Converter a data para o formato do Brasil (dd/mm/yyyy)
    $lastLogonDate = date('d/m/Y H:i:s', ($logonInfo['timestamp'] / 10000000) - 11644473600);


    if ($dataLogonTimestamp < $dataLimite) {
        echo "<tr>
                <td>$user</td>
                <td>{$logonInfo['nome']}</td>
                <td>$lastLogonDate</td>
              </tr>";
    }
}
echo "</table>";

?>