<?php
include 'connessione.php';

// Funzione per eliminare un turno
if (isset($_GET['elimina'])) {
    $id_turno = $_GET['elimina'];
    $elimina_query = "DELETE FROM Turno WHERE id = $id_turno";
    pg_query($conn, $elimina_query);
    echo "<p style='color: green;'>Turno eliminato con successo.</p>";
}

// Gestione della modifica dei dati
if (isset($_POST['modifica'])) {
    $id_turno = $_POST['id_turno'];
    $field = key($_POST); // Ottiene il campo da modificare
    $value = $_POST[$field];

    // Costruisci la query di aggiornamento
    $modifica_query = "UPDATE Turno SET $field = '$value' WHERE id = $id_turno";
    if (pg_query($conn, $modifica_query)) {
        echo "successo";
    } else {
        echo "errore";
    }
}

// Ottieni tutte le piscine per il filtro
$piscine_query = "SELECT nome FROM Piscina";
$piscine_result = pg_query($conn, $piscine_query);
$piscine = [];
while ($row = pg_fetch_assoc($piscine_result)) {
    $piscine[] = $row;
}

// Imposta la visualizzazione di default a mensile
$visualizzazione = $_GET['view'] ?? 'mensile';
$mese = $_GET['mese'] ?? date('m');
$anno = $_GET['anno'] ?? date('Y');
$id_piscina = $_GET['id_piscina'] ?? '';

// Modulo per la selezione di mese, anno e piscina
echo '<form method="GET" action="" style="display: flex; justify-content: center; align-items: center; gap: 10px;">
        <label for="mese">Mese:</label>
        <select name="mese" id="mese">';

// Genera il menu a discesa per i mesi in italiano
$mese_nomi = [
    '01' => 'Gennaio', '02' => 'Febbraio', '03' => 'Marzo', 
    '04' => 'Aprile', '05' => 'Maggio', '06' => 'Giugno', 
    '07' => 'Luglio', '08' => 'Agosto', '09' => 'Settembre', 
    '10' => 'Ottobre', '11' => 'Novembre', '12' => 'Dicembre'
];

foreach ($mese_nomi as $num => $nome) {
    $selected = ($mese == $num) ? 'selected' : '';
    echo "<option value='$num' $selected>$nome</option>";
}

echo '</select>
      <label for="anno">Anno:</label>
      <input type="number" name="anno" id="anno" value="' . $anno . '" required>
      <label for="id_piscina">Piscina:</label>
      <select name="id_piscina" id="id_piscina">
        <option value="">Tutte</option>';

foreach ($piscine as $piscina) {
    $selected = ($id_piscina == $piscina['nome']) ? 'selected' : '';
    echo "<option value='{$piscina['nome']}' $selected>{$piscina['nome']}</option>";
}

echo '</select>
      <input type="hidden" name="view" value="' . $visualizzazione . '">
      <input type="submit" value="Visualizza Turni">
      </form>';

// Query per ottenere i turni selezionati, inclusa la piscina
$query = "SELECT t.data_turno, 
                 to_char(t.data_turno, 'FMDay DD-MM-YYYY') AS data_formattata, 
                 t.orario_inizio, t.orario_fine, t.compenso, t.piscina, t.id 
          FROM Turno t
          WHERE to_char(t.data_turno, 'YYYY-MM') = '$anno-$mese'";



if (!empty($id_piscina)) {
    $query .= " AND t.piscina = '$id_piscina'";
}

          
$query .= "ORDER BY t.data_turno ASC, t.orario_inizio ASC";


$result = pg_query($conn, $query);


// Query per ottenere la somma dei compensi
$somma_query = "SELECT SUM(compenso) AS totale_compenso 
                FROM Turno 
                WHERE to_char(data_turno, 'YYYY-MM') = '$anno-$mese'";

if (!empty($id_piscina)) {
    $somma_query .= " AND piscina = '$id_piscina'";
}

$somma_result = pg_query($conn, $somma_query);
$somma_row = pg_fetch_assoc($somma_result);
$totale_compenso = $somma_row['totale_compenso'] ?? 0;

// Mappa per i giorni della settimana
$giorni_settimana = [
    'Sunday' => 'Domenica',
    'Monday' => 'Lunedì',
    'Tuesday' => 'Martedì',
    'Wednesday' => 'Mercoledì',
    'Thursday' => 'Giovedì',
    'Friday' => 'Venerdì',
    'Saturday' => 'Sabato'
];

echo "<h1>Turni per " . $mese_nomi[$mese] . " $anno</h1>";

if ($result && pg_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Data</th><th>Orario</th><th>Piscina</th><th>Compenso</th><th>Azioni</th></tr>";
    while ($row = pg_fetch_assoc($result)) {
        $giorno_inglese = date('l', strtotime($row['data_turno']));
        $giorno_italiano = $giorni_settimana[$giorno_inglese];

        echo "<tr>";
        echo "<td class='editable' data-field='data_turno' data-id='" . $row['id'] . "'>" . $giorno_italiano . " " . date('d-m-Y', strtotime($row['data_turno'])) . "</td>";
        echo "<td class='editable' data-field='orario_inizio' data-id='" . $row['id'] . "'>" . date('H:i', strtotime($row['orario_inizio'])) . " - " . date('H:i', strtotime($row['orario_fine'])) . "</td>";
        echo "<td class='editable' data-field='piscina' data-id='" . $row['id'] . "'>" . $row['piscina'] . "</td>";
        echo "<td class='editable' data-field='compenso' data-id='" . $row['id'] . "'>" . number_format($row['compenso'], 2) . " EURO</td>";
        echo "<td><a href='?view=$visualizzazione&mese=$mese&anno=$anno&id_piscina=$id_piscina&elimina=" . $row['id'] . "' class='button elimina'>Elimina</a></td>";
        echo "</tr>";
    }


    echo "<tr style='font-weight: bold;'>";
    echo "<td colspan = '3';></td>";
    echo "<td> Totale Compensi: " . number_format($totale_compenso, 2) . " EURO</td>";
    echo "<td></td>";
    echo "</tr>";

    echo "</table>";
} else {
    echo "<p>Nessun turno trovato per il mese/anno selezionato.</p>";
}   
?>

<link rel="stylesheet" href="style.css">

<!-- Contenitore per i link -->
<div class="links-container" style="display: flex; justify-content: center; gap: 20px; margin-top: 20px;">
    <!-- Link per andare alla pagina per aggiungere turni nuovi -->
    <span class="homepage-link">
        <a href="inserisci_turno.php">Aggiungi un turno nuovo</a>
    </span>

    <!-- Link per tornare alla homepage -->
    <span class="homepage-link">
        <a href="index.php">Torna alla Homepage</a>
    </span>
</div>

<style>
    /* Stili della pagina */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    h1 {
        background-color: #1322ff;
        color: white;
        padding: 20px;
        text-align: center;
    }

    table {
        width: 70%; /* Modificato per aumentare la larghezza della tabella */
        margin: 20px auto;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    form {
        min-width: 600px; /* Imposta una larghezza minima per il modulo */
    }

    th, td {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
    }

    th {
        background-color: #1322ff;
        color: white;
    }

    td {
        background-color: #f9f9f9;
    }

    td:hover {
        background-color: #f1f1f1;
    }

    .homepage-link {
        text-align: center;
    }

    .homepage-link a {
        padding: 10px 20px;
        background-color: #1322ff;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .homepage-link a:hover {
        background-color: #0e1e7a;
    }

    /* Stile per il bottone di eliminazione */
    .button.elimina {
        background-color: red; /* Colore rosso per il bottone di eliminazione */
        padding: 5px 10px;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        margin-top: 1px;
    }

    .button.elimina:hover {
        background-color: darkred; /* Colore scuro al passaggio del mouse */
    }
</style>
