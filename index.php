<DOCTYPE html>
    <html>

    <head>
      <link rel="stylesheet" href="style.css">
    </head>

    <body>

    <?php
   
   include('database.php');

   echo"<a href = 'logout.php'> Logout </a><br>";

echo "<br>";

    echo "<form method='POST'>";
      echo "<select name='filtro' id='filtComande'>";

        echo"<option value='tutte'>tutte</option>";
        echo"<option value='attivosi'>attive</option>";
        echo"<option value='attivono'>non attive</option>";
    
      echo "</select>";

      echo "<input type='submit' value='filtra'>"; 
    echo"</form>";

    echo "<table border ='1'>";
    echo "<tr><td>ID</td><td>data</td><td>ora</td><td>stato</td><td>tavolo</td><td>coperti</td><td>id cameriere</td></tr>";

    
    $filtro = isset($_POST['filtro']) ? $_POST['filtro'] : 'tutte';

    $sql = "SELECT * FROM comande";
      if ($filtro == 'attivosi') {
        
        $sql .= " WHERE stato = 1";
      
      } elseif ($filtro == 'attivono') {
      
        $sql .= " WHERE stato = 0"; 
      }

    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        
        while($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>{$row['ID_comanda']}</td>"; 
          echo "<td>{$row['data']}</td>";
          echo "<td>{$row['ora']}</td>";
          echo "<td>{$row['stato']}</td>"; 
          echo "<td>{$row['N_tavolo']}</td>"; 
          echo "<td>{$row['N_coperti']}</td>";
          echo "<td>{$row['ID_cameriere']}</td>";
          echo "</tr>";
        
        }
      };
      
      echo "</table>";

      echo "<form action='tavoli.php'>";
      echo "<button type='submit'>nuova comanda</button>";
      echo "</form>";

      $conn->close();

?>


    </body>

    </html>