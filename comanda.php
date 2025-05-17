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
        
        // ID cameriere (potresti voler recuperare questo dall'utente loggato)
        $id_cameriere = isset($_SESSION['id_cameriere']) ? $_SESSION['id_cameriere'] : 1;
        
        // Numero di coperti (predefinito o da form)
        $n_coperti = isset($_POST['n_coperti']) ? $_POST['n_coperti'] : 2;
        
        $sql2 = "INSERT INTO comande (N_tavolo, stato, data, ora, N_coperti, ID_cameriere) 
                VALUES (" . $_POST['Id_tavolo'] . ", 1, '$data_corrente', '$ora_corrente', $n_coperti, $id_cameriere)";
        
        if ($conn->query($sql2) === TRUE) {
            // Ottieni l'ID della comanda appena creata
            $_SESSION['id_comanda'] = $conn->insert_id;
            $_SESSION['n_tavolo'] = $_POST['Id_tavolo'];
        } else {
            echo "Errore nella creazione della comanda: " . $conn->error;
        }
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
          
        echo "<form method='POST' action='insert_comanda.php'>";
          echo "<input type='submit' name='selez_piatto' value='{$row['Descrizione_piatto']}'>"; 
          echo "<input hidden type='text' name='ID_menu' value='{$row['ID_menu']}'>";
          echo "<input hidden type='text' name='costo' value='{$row['costo']}'>"; 
          echo "<input hidden type='text' name='prezzo' value='{$row['prezzo']}'>"; 
        echo "</form><br><br>";
      
         }
      };

      echo "<div>";
      
      // Mostra i piatti già aggiunti alla comanda corrente
      if (isset($_SESSION['id_comanda'])) {
          $id_comanda = $_SESSION['id_comanda'];
          
          echo "<h3>Piatti ordinati:</h3>";
          
          $sql_dettagli = "SELECT d.ID_dettaglio, m.Descrizione_piatto, d.prezzo 
                          FROM dettagli_comande d 
                          JOIN menu m ON d.ID_menu = m.ID_menu 
                          WHERE d.ID_comanda = $id_comanda";
                          
          $result_dettagli = $conn->query($sql_dettagli);
          
          if ($result_dettagli && $result_dettagli->num_rows > 0) {
              echo "<table border='1'>";
              echo "<tr><th>Piatto</th><th>Prezzo</th></tr>";
              
              $totale = 0;
              
              while($row_dettaglio = $result_dettagli->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>{$row_dettaglio['Descrizione_piatto']}</td>";
                  echo "<td>{$row_dettaglio['prezzo']} €</td>";
                  echo "</tr>";
                  
                  $totale += $row_dettaglio['prezzo'];
              }
              
              echo "<tr><td><strong>Totale</strong></td><td><strong>{$totale} €</strong></td></tr>";
              echo "</table>";
          } else {
              echo "<p>Nessun piatto ordinato.</p>";
          }
      }

      echo "</div>";

      echo "<form action='conferma_comanda.php' method='POST'>";
      echo "<input type='submit' name='comanda' value='conferma comanda'>";
      echo "</form>";
      
      $conn->close();
?>


    </body>

    </html>
