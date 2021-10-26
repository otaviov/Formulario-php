<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "form-php";
$port = "3306"; 

try {

    $conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);
    echo "Conexão com o banco de dados realizada com sucesso!";

} catch (Exception $ex){

    echo "Erro: Conexão não realizada com o banco de dados!";

}



