  <DOCTYPE html>
    <html>

    <head>
    <link rel="stylesheet" href="style.css">
    </head>

    <body>

    <?php

    include('database.php');

    if (isset($_POST['Id_tavolo'])) 
    { $sql2 = "INSERT INTO comande (N_tavolo, stato) VALUES (" . $_POST['Id_tavolo'] . ", 1)";
      $conn->query($sql2);
    }
 
    echo "<form action='tavoli.php'>";
    echo "<button>annulla</button>";
    echo "</form>";
    echo "<br>";

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

      

      echo "</div>";

      echo "<input type='submit' name='comanda' value='conferma comanda'>";
      
      $conn->close();
?>


    </body>

    </html>
