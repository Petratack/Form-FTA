<?php

    if(isset($_POST['textdata']))
    {
    $nome = $_POST['nome'] ?? '';
    $cognome = $_POST['cognome'] ?? '';
    $azienda = $_POST['azienda'] ?? '';
    $email = $_POST['email'] ?? '';
    $visioneDocumento = $_POST['documentoVisionato'] ?? '';
    $data = $_POST['data'] ?? '';
    $ora = $_POST['ora'] ?? '';
    $fp = fopen('data/data.txt', 'a');
    fwrite($fp, $data);
    fclose($fp);
    }


    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST['nome'] ?? '';
        $cognome = $_POST['cognome'] ?? '';
        $azienda = $_POST['azienda'] ?? '';
        $email = $_POST['email'] ?? '';
        $visioneDocumento = $_POST['documentoVisionato'] ?? '';
        $data = $_POST['data'] ?? '';
        $ora = $_POST['ora'] ?? '';
    
        
        if($visioneDocumento=="on"){
            $visioneDocumento="SI";
        }elseif($visioneDocumento=="off") {
            $visioneDocumento="NO";
        }

        $fp = fopen('data/data.txt', 'a');
        $contenuto = "Nome: $nome, Cognome: $cognome, Azienda: $azienda, Email: $email, Documento visto: $visioneDocumento, Data: $data, Ora: $ora\n";
        fwrite($fp, $contenuto);
        fclose($fp);


        $mail = new PHPMailer(true);

        try {
            
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'patrickgalante25@gmail.com'; // mittente gmail
            $mail->Password   = 'mcvk ihuu ylze yxdi';        
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];
            

            // mittente e destinatario
            $mail->setFrom($email, "$nome $cognome");
            $mail->addAddress('patrick.galante9823@gmail.com'); // destinatario mail

           
            $mail->isHTML(true);
            $mail->Subject = "Nuova registrazione da $nome $cognome";
            $mail->Body    = "
                <h3>Nuovo modulo inviato</h3>
                <p><strong>Nome:</strong> $nome</p>
                <p><strong>Cognome:</strong> $cognome</p>
                <p><strong>Azienda:</strong> $azienda</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Documento visto:</strong> $visioneDocumento</p>
                <p><strong>Data:</strong> $data</p>
                <p><strong>Ora:</strong> $ora</p>
            ";

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
                <a href="index.html" class="span" id="documentLink" target="_blank" >Ritorna al Form.</a>
            </body>
            </html>
            <?php
        } catch (Exception $e) {
            echo "Errore nell'invio: {$mail->ErrorInfo}";
        }
    } else {
        echo "Accesso non autorizzato.";
    }
?>



