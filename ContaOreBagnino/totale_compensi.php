<?php
include 'connessione.php';

// Query per ottenere i compensi totali raggruppati per mese (con nome del mese e anno)
$query = "SELECT to_char(data_turno, 'TMMonth YYYY') AS mese, SUM(compenso) AS totale_compenso
          FROM Turno
          GROUP BY to_char(data_turno, 'TMMonth YYYY'), to_char(data_turno, 'YYYY-MM')
          ORDER BY to_char(data_turno, 'YYYY-MM') DESC";

$result = pg_query($conn, $query);

echo "<h1>RECAP MENSILI</h1>";

if ($result && pg_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr><th>Mese</th><th>Totale Compenso (EURO)</th></tr>";
    
    // Itera sui risultati e crea una riga per ogni mese
    while ($row = pg_fetch_assoc($result)) {
        // Capitalizziamo correttamente il nome del mese
        $mese_capitalizzato = ucwords(strtolower($row['mese']));
        echo "<tr>";
        echo "<td>" . $mese_capitalizzato . "</td>";
        echo "<td>" . number_format($row['totale_compenso'], 2) . " EURO</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p>Nessun compenso trovato.</p>";
}
?>

<br>
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

    <!-- Link per vedere i turni -->
    <span class="homepage-link">
        <a href="visualizza_turni.php">Vedi i turni</a>
    </span>
</div>

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #e0e0e0;
        margin: 0;
        padding: 0;
    }

    h1 {
        background-color: #007BFF;
        color: white;
        padding: 20px;
        text-align: center;
        font-size: 2.2em;
    }

    table {
        width: 70%;
        margin: 30px auto;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 15px;
        text-align: center;
        border: 1px solid #cccccc;
    }

    th {
        background-color: #007BFF;
        color: #ffffff;
        font-weight: bold;
    }

    td {
        background-color: #f8f9fa;
        font-size: 1.1em;
    }

    td:hover {
        background-color: #e9ecef;
    }

    a {
        color: #007BFF;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }

    .links-container {
        margin-top: 30px;
    }
</style>
