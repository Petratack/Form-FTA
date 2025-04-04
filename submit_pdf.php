<?php
use PHPMailer\PHPMailer\PHPMailer;use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'FPDF/doc/fpdf.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $cognome = $_POST['cognome'] ?? '';
    $azienda = $_POST['azienda'] ?? '';
    $email = $_POST['email'] ?? '';
    $visioneDocumento = $_POST['documentoVisionato'] ?? '';
    $data = $_POST['data'] ?? '';
    $ora = $_POST['ora'] ?? '';

    if ($visioneDocumento == "on") {
        $visioneDocumento = "ACCETTA";
    } elseif ($visioneDocumento == "off") {
        $visioneDocumento = "NON ACCETTA";
    }
    
    $conn= new mysqli("localhost", "mysql_user", "password", "form_db"); //form_db

    if($conn->connect_error){
        die("connessione fallita: " . $conn->connect_error);
    }  

    $stmt = $conn->prepare("INSERT INTO form_data (nome, cognome, email, azienda, data_invio, ora_invio, visioneDocumento) VALUES (?,?,?,?,?,?,?)");
    //$stmt = $conn->prepare("INSERT INTO form_data (nome, cognome, email, azienda, data_invio, ora_invio, accettato_privacy) VALUES ($nome, $cognome, $email, $azienda, $data, $ora, 1)");
    
    //$accettato= $privacy === 'Accettata' ? 1: 0;
    $stmt-> bind_param("sssssss", $nome, $cognome, $email, $azienda, $data, $ora, $visioneDocumento);

    if($stmt->execute()){
        echo"Dati salvati nel database con successo";
    }else{
        echo "Errore: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();









   
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(40, 10, 'Modulo Accettazione al Documento per la Privacy');
    $pdf->Ln(50);
    $pdf->Image('img/FTA_colore-1-1024x731.png', 20,20,-400,-400);
    $pdf->Ln(0);
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Cell(0,5,"FTA SISTEMI SRL VIA CUSSIGNACCO 78/16 - 33040 Pradamano (UD).");
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Ln(20);
    $pdf->Cell(0, 20, "Il/la sottoscritto/a  $nome  $cognome");
    $pdf->Ln(10);
    $pdf->Cell(0,20,"(Azienda:  $azienda;  Email:  $email)");
    $pdf->Ln(20);
    $pdf->Cell(0, 10, "Presa la visione nel documento  allegato nel modulo di registrazione", 0, 1);
    $pdf->Cell(0, 10, "$visioneDocumento  quanto stabilito.", 0, 1);
    $pdf->Ln(20);
    $pdf->Cell(0, 10, "Modulo compilato in data  $data  e ora  $ora", 0, 1);
    $pdf->Ln(20);
    $pdf->Cell(0, 15, "Firma Interessato_________________________ "  );
    $pdf->Ln(10);
    $pdf->Cell(0, 15 ,"Firma Datore___________________________ " );
    
    $pdfFile = 'data/modulo_inviato.pdf';
    $pdf->Output('F', 'data/modulo_inviato.pdf');

   
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sender@email.com'; 
        $mail->Password   = 'sender password';           
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ],
        ];

        
        $mail->setFrom($email, "$nome $cognome");
        $mail->addAddress('recipient@email.com'); 

        $mail->isHTML(true);
        $mail->Subject = "Nuova registrazione da $nome $cognome";
        $mail->Body    = "In allegato il modulo inviato da $nome $cognome.";
        $mail->addAttachment($pdfFile);

        $mail->send();
        ?>
            <!DOCTYPE html>
            <html lang="it">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title></title>
                <link rel="stylesheet" href="styles.css">
            </head>
            <body>
                <h2>Email inviata con successo!</h2>
                <button onclick="location.href='Form.php';" href="index.php" class="span" id="documentLink" target="_blank" >Ritorna al Form.</a>
            </body>
            </html>
            <?php


    } catch (Exception $e) {
        echo "Errore nell'invio: {$mail->ErrorInfo}";
    }
} else {
    echo "Accesso non autorizzato.";
}


$redirect_time = 5; 
$redirect_url = 'Form.php'; 

echo "<meta http-equiv='refresh' content='$redirect_time;url=$redirect_url'>";



?>
