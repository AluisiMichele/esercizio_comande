<?php

    include('database.php');

    $sql = "INSERT INTO dettagli_comande (ID_menu, prezzo, costo, ID_comanda)
     VALUES (" . $_POST['ID_menu'] . ", " . $_POST['prezzo'] . ", " . $_POST['costo'] . ", 1)";
    
    if ($conn->query($sql) === TRUE) {
        // Reindirizza l'utente alla pagina precedente
        header("Location: comanda.php");
        exit();
    } else {
        echo "Errore durante l'inserimento: " . $conn->error;
    }

    $conn->close();
    
?>
