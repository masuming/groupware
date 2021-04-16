<?php
try {
    $pdo=new PDO('mysql:host=;dbname=;charset=utf8','','',
    array(PDO::ATTR_EMULATE_PREPARES=>false));   
}

catch (PDOException $e) {
    die('データベース接続失敗。'.$e->getMessage());
}
?>