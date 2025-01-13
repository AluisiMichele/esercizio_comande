  <DOCTYPE html>
    <html>

    <head>
    <link rel="stylesheet" href="style.css">
    </head>

    <body>

    <?php

    include('database.php');

    

    echo "<form action='index.php'>";
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

    $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : 'antipasti';

    $sql = "SELECT * FROM menu";
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
          
        echo "<form method='POST'>";
          echo "<input type='submit' name='selez_piatto' value='{$row['Descrizione piatto']}'>"; 
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