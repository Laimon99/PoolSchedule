<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserisci Turno Bagnino</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #007BFF; /* Colore del titolo */
            padding: 20px;
            background-color: #007BFF;
            color: white;
            margin-bottom: 20px;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        input[type="date"],
        input[type="time"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #007BFF;
        }

        .links-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .homepage-link a {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .homepage-link a:hover {
            background-color: #007BFF;
        }
    </style>
</head>

<?php
include 'connessione.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data_turno = $_POST['data_turno'];
    $orario_inizio = $_POST['orario_inizio'];
    $orario_fine = $_POST['orario_fine'];
    $piscina = $_POST['piscina'];
    
    // Calcolo del compenso
    $ore_lavorate = (strtotime($orario_fine) - strtotime($orario_inizio)) / 3600;
    $compenso = $ore_lavorate * 10.45;
    
    $query = "INSERT INTO Turno (data_turno, orario_inizio, orario_fine, piscina, compenso) 
              VALUES ('$data_turno', '$orario_inizio', '$orario_fine', '$piscina', $compenso)";
    
    $result = pg_query($conn, $query);
    
    if ($result) {
        echo "<p style='color: green;'>Turno inserito con successo!</p>";
    } else {
        echo "<p style='color: red;'>Errore nell'inserimento del turno: " . pg_last_error($conn) . "</p>";
    }
}

// Query per ottenere i nomi delle piscine
$piscine_query = "SELECT nome FROM Piscina";
$piscine_result = pg_query($conn, $piscine_query);
$piscine = [];
while ($row = pg_fetch_assoc($piscine_result)) {
    $piscine[] = $row['nome'];
}
?>

<body>
    <h2>Inserisci Turno Bagnino</h2>
    <div class="form-container">
        <form method="POST" action="">
            Data Turno: <input type="date" name="data_turno" required><br>
            Orario Inizio: <input type="time" name="orario_inizio" required><br>
            Orario Fine: <input type="time" name="orario_fine" required><br>
            Piscina: 
            <select name="piscina" required>
                <option value="">Seleziona una piscina</option>
                <?php foreach ($piscine as $piscina_nome): ?>
                    <option value="<?php echo htmlspecialchars($piscina_nome); ?>"><?php echo htmlspecialchars($piscina_nome); ?></option>
                <?php endforeach; ?>
            </select><br>
            <input type="submit" value="Inserisci Turno">
        </form>
    </div>

    <div class="links-container">
        <span class="homepage-link">
            <a href="visualizza_turni.php">Visualizza i turni</a>
        </span>
        <span class="homepage-link">
            <a href="index.php">Torna alla Homepage</a>
        </span>
        <span class="homepage-link">
            <a href="totale_compensi.php">Vedi i recap</a>
        </span>
    </div>
</body>
</html>
