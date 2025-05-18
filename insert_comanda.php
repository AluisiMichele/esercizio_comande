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
    
    // Ottieni la quantità dei piatti, con valore predefinito 1 se non specificato
    $quantita = isset($_POST['quantita']) ? intval($_POST['quantita']) : 1;
    
    // Assicurati che la quantità sia almeno 1
    if ($quantita < 1) $quantita = 1;
    
    // Calcola il prezzo totale in base alla quantità
    $prezzo_totale = $_POST['prezzo'] * $quantita;
    $costo_totale = $_POST['costo'] * $quantita;
    
    // Controlla se esiste già questo piatto nella comanda
    $check_sql = "SELECT ID_dettaglio, quantità FROM dettagli_comande 
                 WHERE ID_menu = " . $_POST['ID_menu'] . " AND ID_comanda = " . $id_comanda;
    
    $check_result = $conn->query($check_sql);
    
    if ($check_result && $check_result->num_rows > 0) {
        // Il piatto esiste già, aggiorna la quantità
        $row = $check_result->fetch_assoc();
        $nuova_quantita = $row['quantità'] + $quantita;
        
        $update_sql = "UPDATE dettagli_comande 
                      SET quantità = " . $nuova_quantita . " 
                      WHERE ID_dettaglio = " . $row['ID_dettaglio'];
        
        if ($conn->query($update_sql) === TRUE) {
            // Reindirizza l'utente alla pagina precedente
            header("Location: comanda.php");
            exit();
        } else {
            echo "Errore durante l'aggiornamento: " . $conn->error;
        }
    } else {
        // Il piatto non esiste, inserisci nuovo record
        $sql = "INSERT INTO dettagli_comande (ID_menu, prezzo, costo, ID_comanda, quantità)
                VALUES (" . $_POST['ID_menu'] . ", " . $_POST['prezzo'] . ", " . $_POST['costo'] . ", " . $id_comanda . ", " . $quantita . ")";
        
        if ($conn->query($sql) === TRUE) {
            // Reindirizza l'utente alla pagina precedente
            header("Location: comanda.php");
            exit();
        } else {
            echo "Errore durante l'inserimento: " . $conn->error;
        }
    }

    $conn->close();
?>