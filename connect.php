<?php
function kapcsolodas($kapcsolati_szoveg, $felhasznalonev = '', $jelszo = '') {
    $pdo = new PDO($kapcsolati_szoveg, $felhasznalonev, $jelszo);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

$kapcsolat = kapcsolodas('mysql:host=mysql.caesar.elte.hu;dbname=danielmoln', 'danielmoln', 'EVXwfiEuGX57LdK1');
?>