<?php
include 'connessione.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['id_turno'], $data['campo'], $data['valore'])) {
    $id_turno = $data['id_turno'];
    $campo = $data['campo'];
    $valore = $data['valore'];

    // Esegui una query di aggiornamento in base al campo
    $update_query = "UPDATE Turno SET $campo = $1 WHERE id = $2";
    $result = pg_query_params($conn, $update_query, array($valore, $id_turno));

    if ($result) {
        http_response_code(200);
    } else {
        // Se c'è un errore, mostra l'errore SQL
        echo json_encode(array('error' => pg_last_error($conn)));
        http_response_code(500);
    }
} else {
    http_response_code(400);
}
?>
