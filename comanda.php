  <DOCTYPE html>
    <html>

    <head>
    <link rel="stylesheet" href="style.css">
    </head>

    <body>

<DOCTYPE html>
    <html>

    <head>
    <link rel="stylesheet" href="style.css">
    </head>

    <body>

<?php
    session_start();
    include('database.php');

    if (isset($_POST['Id_tavolo'])) 
    { 
        // Data e ora correnti
        $data_corrente = date("Y-m-d");
        $ora_corrente = date("H:i:s");
        
        // ID cameriere 
        $id_cameriere = isset($_SESSION['id_cameriere']) ? $_SESSION['id_cameriere'] : 1;
        
        // RIMUOVIAMO L'INSERIMENTO AUTOMATICO DELLA COMANDA
        // Salviamo solo le informazioni temporanee in sessione
        $_SESSION['temp_tavolo'] = $_POST['Id_tavolo'];
        $_SESSION['temp_data'] = $data_corrente;
        $_SESSION['temp_ora'] = $ora_corrente;
        $_SESSION['temp_cameriere'] = $id_cameriere;
    }
 
    echo "<form action='tavoli.php'>";
    echo "<button>annulla</button>";
    echo "</form>";
    echo "<br>";
    
    // Mostra informazioni sulla comanda corrente
    if (isset($_SESSION['id_comanda'])) {
        echo "<div class='comanda-info'>";
        echo "<p><strong>Comanda #" . $_SESSION['id_comanda'] . " - Tavolo " . $_SESSION['n_tavolo'] . "</strong></p>";
        echo "</div>";
    } elseif (isset($_SESSION['temp_tavolo'])) {
        echo "<div class='comanda-info'>";
        echo "<p><strong>Preparazione comanda - Tavolo " . $_SESSION['temp_tavolo'] . "</strong></p>";
        echo "</div>";
    }

    echo "<form method='POST'>";  
        echo "<select name='filtro' id='piatti' >";

            echo"<option value='antipasti'>antipasti</option>";
            echo"<option value='primi'>primi</option>";
            echo"<option value='secondi'>secondi</option>";
    
            echo "<input type='submit' value='seleziona'>";

        echo "</select>";
    echo"</form>";

    $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : '';

    $sql = "SELECT ID_menu, Descrizione_piatto, costo, prezzo FROM menu";
      if ($filtro == 'antipasti') {
        
        $sql .= " WHERE ID_tipologia = 1";
      
      } elseif ($filtro == 'primi') {
      
        $sql .= " WHERE ID_tipologia = 2"; 
     
      } elseif ($filtro == 'secondi') {
      
        $sql .= " WHERE ID_tipologia = 3"; 
      }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
          
        echo "<form method='POST' action='insert_comanda.php' class='piatto-form'>";
          echo "<div class='piatto-container'>";
            echo "<input type='submit' name='selez_piatto' value='{$row['Descrizione_piatto']}'>";
            echo "<div class='quantity-control'>";
              echo "<label for='quantita_{$row['ID_menu']}'>Quantità:</label>";
              echo "<input type='number' id='quantita_{$row['ID_menu']}' name='quantita' value='1' min='1' max='10'>";
            echo "</div>";
          echo "</div>";
          echo "<input type='hidden' name='ID_menu' value='{$row['ID_menu']}'>";
          echo "<input type='hidden' name='costo' value='{$row['costo']}'>";
          echo "<input type='hidden' name='prezzo' value='{$row['prezzo']}'>";
        echo "</form><br><br>";
      
         }
      };

      echo "<div>";
      
      // Mostra i piatti già aggiunti alla comanda corrente
      if (isset($_SESSION['piatti_temporanei']) && !empty($_SESSION['piatti_temporanei'])) {
          echo "<h3>Piatti ordinati:</h3>";
          echo "<table border='1'>";
          echo "<tr><th>Piatto</th><th>Quantità</th><th>Prezzo Unitario</th><th>Totale</th></tr>";
          
          $totale = 0;
          
          foreach ($_SESSION['piatti_temporanei'] as $piatto) {
              $totale_piatto = $piatto['prezzo'] * $piatto['quantita'];
              echo "<tr>";
              echo "<td>{$piatto['descrizione']}</td>";
              echo "<td>{$piatto['quantita']}</td>";
              echo "<td>{$piatto['prezzo']} €</td>";
              echo "<td>{$totale_piatto} €</td>";
              echo "</tr>";
              
              $totale += $totale_piatto;
          }
          
          echo "<tr><td colspan='3'><strong>Totale</strong></td><td><strong>{$totale} €</strong></td></tr>";
          echo "</table>";
      } elseif (isset($_SESSION['id_comanda'])) {
          $id_comanda = $_SESSION['id_comanda'];
          
          echo "<h3>Piatti ordinati:</h3>";
          
          $sql_dettagli = "SELECT d.ID_dettaglio, m.Descrizione_piatto, d.quantità, d.prezzo, (d.prezzo * d.quantità) as totale_piatto 
                          FROM dettagli_comande d 
                          JOIN menu m ON d.ID_menu = m.ID_menu 
                          WHERE d.ID_comanda = $id_comanda";
                          
          $result_dettagli = $conn->query($sql_dettagli);
          
          if ($result_dettagli && $result_dettagli->num_rows > 0) {
              echo "<table border='1'>";
              echo "<tr><th>Piatto</th><th>Quantità</th><th>Prezzo Unitario</th><th>Totale</th></tr>";
              
              $totale = 0;
              
              while($row_dettaglio = $result_dettagli->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>{$row_dettaglio['Descrizione_piatto']}</td>";
                  echo "<td>{$row_dettaglio['quantità']}</td>";
                  echo "<td>{$row_dettaglio['prezzo']} €</td>";
                  echo "<td>{$row_dettaglio['totale_piatto']} €</td>";
                  echo "</tr>";
                  
                  $totale += $row_dettaglio['totale_piatto'];
              }
              
              echo "<tr><td colspan='3'><strong>Totale</strong></td><td><strong>{$totale} €</strong></td></tr>";
              echo "</table>";
          } else {
              echo "<p>Nessun piatto ordinato.</p>";
          }
      } else {
          echo "<p>Nessun piatto ordinato.</p>";
      }

      echo "</div>";

      // Mostra il form per il numero di coperti e conferma solo se ci sono piatti
      if ((isset($_SESSION['piatti_temporanei']) && !empty($_SESSION['piatti_temporanei'])) || 
          (isset($_SESSION['id_comanda']))) {
          
          echo "<div class='coperti-section'>";
          echo "<h3>Finalizza Comanda</h3>";
          echo "<form action='conferma_comanda.php' method='POST'>";
          echo "<label for='n_coperti'>Numero di coperti:</label>";
          echo "<input type='number' id='n_coperti' name='n_coperti' value='2' min='1' max='20' required>";
          echo "<br><br>";
          echo "<input type='submit' name='comanda' value='Conferma Comanda'>";
          echo "</form>";
          echo "</div>";
      }
      
      $conn->close();
?>


    </body>

    </html>

    </body>

    </html>
