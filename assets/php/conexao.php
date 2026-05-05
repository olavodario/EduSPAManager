<?php
// Arquivo de configuração da conexão com o banco de dados MySQL
// Utiliza PDO para conexão segura

// Carrega variáveis de ambiente (se houver)
// $dotenv->load();

// Configurações do banco de dados
$host = "localhost";
$dbname = "spa11";
$username = "root";
$password = "";

// Tentativa de conexão com o banco
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configurações do PDO
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo -> exec("SET NAMES 'utf8'");
    $pdo -> exec("SET CHARACTER SET utf8");
    $connection_status = $pdo -> getAttribute(PDO::ATTR_CONNECTION_STATUS);
} catch (PDOException $e) {
    echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
}

