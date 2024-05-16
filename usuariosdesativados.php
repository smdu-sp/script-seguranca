<?php

require_once ('scripts.php');

// Configurações do servidor LDAP
$ldapServer = 'ldap://10.10.53.10'; // Endereço do servidor LDAP
$ldapUser = 'usr_smdu_freenas'; // Nome de usuário com permissão para fazer consultas LDAP
$ldapPass = 'Prodam01'; // Senha do usuário LDAP
$ldapBaseDn = 'ou=Users,ou=SMUL,dc=rede,dc=sp'; // DN da base LDAP onde os usuários estão localizados

// Conectar ao servidor LDAP
$ldapConn = ldap_connect($ldapServer);
ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);

if ($ldapConn) {
    // Fazer bind com as credenciais do usuário LDAP
    $ldapBind = ldap_bind($ldapConn, $ldapUser, $ldapPass);

    if ($ldapBind) {
        // Filtrar usuários desativados
        $searchFilter = "(&(objectClass=user)(userAccountControl:1.2.840.113556.1.4.803:=2))"; // Filtrar usuários desativados
        $searchResult = ldap_search($ldapConn, $ldapBaseDn, $searchFilter);

        if ($searchResult) {
            $entries = ldap_get_entries($ldapConn, $searchResult);

            if ($entries['count'] > 0) {
                // Exibir os usuários desativados
                echo "<h2>Usuários Desativados no AD</h2>";
                echo "<table class='table table-bordered'>
                        <thead class='table-dark'>
                        <tr>
                            <th>Usuário</th>
                            <th>Nome</th>
                            <th>Email</th>
                        </tr>
                        </thead>";
                for ($i = 0; $i < $entries['count']; $i++) {
                    $username = $entries[$i]['samaccountname'][0];
                    $name = $entries[$i]['cn'][0];
                    $email = isset($entries[$i]['mail'][0]) ? $entries[$i]['mail'][0] : 'N/A';

                    echo "<tr>
                            <td>$username</td>
                            <td>$name</td>
                            <td>$email</td>
                        </tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Nenhum usuário desativado encontrado na OU SMUL.</p>";
            }
        } else {
            echo "<p>Erro ao pesquisar usuários na OU SMUL.</p>";
        }
    } else {
        echo "<p>Erro ao fazer bind com o servidor LDAP.</p>";
    }

    // Fechar a conexão LDAP
    ldap_close($ldapConn);
} else {
    echo "<p>Não foi possível conectar ao servidor LDAP.</p>";
}

echo "<br><a href='index.php' class='btn btn-primary'>Voltar</a>";

?>
