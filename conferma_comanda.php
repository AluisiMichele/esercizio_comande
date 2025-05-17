<?php
    session_start();
    include('database.php');
    
    if (isset($_POST['comanda']) && isset($_SESSION['id_comanda'])) {
        $id_comanda = $_SESSION['id_comanda'];
        
        // Aggiorna lo stato della comanda (opzionale, se necessario)
        // $sql = "UPDATE comande SET stato = 2 WHERE ID_comanda = $id_comanda";
        // $conn->query($sql);
        
        // Rimuovi l'ID della comanda dalla sessione per permettere la creazione di nuove comande
        unset($_SESSION['id_comanda']);
        unset($_SESSION['n_tavolo']);
        
        echo "<h2>Comanda #$id_comanda confermata con successo!</h2>";
        echo "<br><a href='index.php'>Torna alla lista comande</a>";
    } else {
        echo "<h2>Errore: Nessuna comanda da confermare.</h2>";
        echo "<br><a href='index.php'>Torna alla lista comande</a>";
    }
    
    $conn->close();
?>