<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form di registrazione</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>MODULO DI REGISTRAZIONE</h2>
    
  
    <a href="companiy.site.com" target="_blank">
      <img src="company.logo.png" alt="FTA" class="responsive-img center">
    </a>

    
    <h6 class="subtitle">
      Company address & info
    </h6>
          
    <form id="registationForm" action="submit_pdf.php" method="post">
        
      <div class="row">
        <div class="col">
          <label for="nome">Nome:</label>
          <input type="text" id="nome" name="nome" required>
        </div>
        <div class="col">
          <label for="cognome">Cognome:</label>
          <input type="text" id="cognome" name="cognome" required>
        </div>
      </div>
      
      <label for="azienda">Nome Azienda:</label>
      <input type="text" id="azienda" name="azienda" required>
      
      <label for="email">Indirizzo Mail:</label>
      <input type="email" id="email" name="email" required>
      
      <div class="row">
        <div class="col">
          <label for="data">Data:</label>
          <input type="date" name="data" id="data" required>
        </div>
        <div class="col">
          <label for="ora">Ora di ingresso:</label>
          <input type="time" name="ora" id="ora" required>
        </div>
      </div>
      <?php
        $documentViewed= false;
      
      ?>
      <div class="documentLink">
        <a href="document.pdf" id="documentLink" target="_blank" style="font-size: 30px; text-decoration:underline;" onclick=<?php $documentViewed= true; ?> cursor>CLICCA QUI</a>
        <h6 style="text-align: center;">(Leggi il documento prima di inviare)</h6>
      </div>
      
      <div class="checkbox-container" id="checkboxContainer" >
        <!--style="display: none; "-->  
        <input type="checkbox" id="documentoVisionato" name="documentoVisionato" required>

        <label class="documentoVisionato" for="documentoVisionato">Confermo di aver letto il documento e accetto*</label>
        
        
      </div>
      <label for="documentoVisionato" class="documentoVisionato">(*campo obbligatorio)</label>
      <button id="button" type="submit" style="display: none;">INVIA</button>
    
    
    
    
    
        

    </form>
  
   
    
    
</body>
<script>
    document.getElementById('documentLink').addEventListener('click', () => {
        document.getElementById('button').style.display = 'block';
    });
    function setDateTime() {
            const now = new Date();
            
           
            const dateInput = document.getElementById('data');
            dateInput.value = now.toISOString().split('T')[0];
            dateInput.readOnly = true
            
           
            const timeInput = document.getElementById('ora');
            timeInput.value = now.toTimeString().split(' ')[0].slice(0, 5);
            timeInput.readOnly = true;
            
        }

        
        window.onload = setDateTime;
    
</script>

</html>
