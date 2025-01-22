

    <?php

    include('database.php');

    
    $sql = "INSERT INTO dettagli_comande (ID_menu, prezzo, costo, ID_comanda) VALUES ($_POST['ID_menu'],  $_POST['prezzo'], $_POST['costo'], 1)";
   
    
    $result = $conn->query($sql);   

    
      $conn->close();
?>


