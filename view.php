<?php
$conn = new mysqli("localhost", "mysql_user", "password", "form_db");
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM form_data ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dati salvati</title>
    <meta http-equiv="refresh" content="5"> <!-- ?? Auto-refresh ogni 5 secondi -->
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h2>Ultimi dati ricevuti</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Email</th>
            <th>Azienda</th>
            <th>Data</th>
            <th>Ora</th>
            <th>Privacy</th>
            <th>Timestamp</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td><?= htmlspecialchars($row['cognome']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['azienda']) ?></td>
            <td><?= htmlspecialchars($row['data_invio']) ?></td>
            <td><?= htmlspecialchars($row['ora_invio']) ?></td>
            <td><?= htmlspecialchars($row['accettato_privacy'] ?? $row['visioneDocumento']) ?></td>
            <td><?= $row['timestamp'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
