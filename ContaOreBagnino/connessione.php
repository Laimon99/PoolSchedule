<?php
$host = 'localhost';
$port = '5432';
$dbname = 'ContaOreBagnino';
$user = 'postgres';
$password = 'unimi';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Errore di connessione: " . pg_last_error());
}
?>