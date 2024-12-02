<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione Turni Bagnino</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            padding: 20px;
            background-color: #007BFF;
            color: white;
            font-size: 2.5em;
        }

        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            background-color: #ffffff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            width: 80%;
            border-radius: 5px;
        }

        nav ul li {
            margin: 0 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #007BFF;
            font-size: 1.2em;
            padding: 15px 20px;
            display: block;
        }

        nav ul li a:hover {
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Benvenuto nel sistema di gestione turni per bagnini</h1>
    <nav>
        <ul>
            <li><a href="inserisci_turno.php">Inserisci un nuovo turno</a></li>
            <li><a href="visualizza_turni.php">Visualizza turni</a></li>
            <li><a href="totale_compensi.php">Visualizza recap mensile</a></li>
        </ul>
    </nav>
</body>
</html>
