<?php
    session_start();
    include('database.php');

    // Ottieni l'ID della comanda dalla sessione
    $id_comanda = isset($_SESSION['id_comanda']) ? $_SESSION['id_comanda'] : 0;
    
    if ($id_comanda <= 0) {
        echo "Errore: Nessuna comanda attiva.";
        echo "<br><a href='tavoli.php'>Torna alla selezione tavoli</a>";
        exit();
    }
    
    $sql = "INSERT INTO dettagli_comande (ID_menu, prezzo, costo, ID_comanda)
     VALUES (" . $_POST['ID_menu'] . ", " . $_POST['prezzo'] . ", " . $_POST['costo'] . ", " . $id_comanda . ")";
    
    if ($conn->query($sql) === TRUE) {
        // Reindirizza l'utente alla pagina precedente
        header("Location: comanda.php");
        exit();
    } else {
        echo "Errore durante l'inserimento: " . $conn->error;
    }

    $conn->close();
?>