<?php
    session_start();
    include('database.php');
    
    if (isset($_POST['comanda']) && isset($_POST['n_coperti'])) {
        $n_coperti = intval($_POST['n_coperti']);
        
        // Assicurati che ci siano piatti da ordinare
        if (!isset($_SESSION['piatti_temporanei']) || empty($_SESSION['piatti_temporanei'])) {
            echo "<h2>Errore: Nessun piatto selezionato.</h2>";
            echo "<br><a href='comanda.php'>Torna alla comanda</a>";
            exit();
        }
        
        // Verifica che abbiamo le informazioni del tavolo
        if (!isset($_SESSION['temp_tavolo'])) {
            echo "<h2>Errore: Informazioni tavolo mancanti.</h2>";
            echo "<br><a href='tavoli.php'>Torna alla selezione tavoli</a>";
            exit();
        }
        
        try {
            // Inizia una transazione
            $conn->autocommit(FALSE);
            
            // Inserisci la comanda con il numero di coperti specificato
            $sql_comanda = "INSERT INTO comande (N_tavolo, stato, data, ora, N_coperti, ID_cameriere) 
                           VALUES (?, 1, ?, ?, ?, ?)";
            
            $stmt_comanda = $conn->prepare($sql_comanda);
            $stmt_comanda->bind_param("issii", 
                $_SESSION['temp_tavolo'],
                $_SESSION['temp_data'],
                $_SESSION['temp_ora'],
                $n_coperti,
                $_SESSION['temp_cameriere']
            );
            
            if (!$stmt_comanda->execute()) {
                throw new Exception("Errore nell'inserimento della comanda: " . $stmt_comanda->error);
            }
            
            // Ottieni l'ID della comanda appena creata
            $id_comanda = $conn->insert_id;
            
            // Inserisci tutti i piatti nei dettagli comanda
            $sql_dettaglio = "INSERT INTO dettagli_comande (ID_menu, prezzo, costo, ID_comanda, quantità, N_uscita, nota, stato) 
                             VALUES (?, ?, ?, ?, ?, 0, '', 0)";
            
            $stmt_dettaglio = $conn->prepare($sql_dettaglio);
            
            foreach ($_SESSION['piatti_temporanei'] as $piatto) {
                $stmt_dettaglio->bind_param("iddii",
                    $piatto['id_menu'],
                    $piatto['prezzo'],
                    $piatto['costo'],
                    $id_comanda,
                    $piatto['quantita']
                );
                
                if (!$stmt_dettaglio->execute()) {
                    throw new Exception("Errore nell'inserimento del piatto: " . $stmt_dettaglio->error);
                }
            }
            
            // Conferma la transazione
            $conn->commit();
            
            // Salva i dati prima di pulire le sessioni
            $tavolo_confermato = $_SESSION['temp_tavolo'];
            
            // Pulisci le variabili di sessione
            unset($_SESSION['piatti_temporanei']);
            unset($_SESSION['temp_tavolo']);
            unset($_SESSION['temp_data']);
            unset($_SESSION['temp_ora']);
            unset($_SESSION['temp_cameriere']);
            unset($_SESSION['id_comanda']);
            unset($_SESSION['n_tavolo']);
            
            echo "<h2>Comanda #$id_comanda confermata con successo!</h2>";
            echo "<p><strong>Tavolo:</strong> $tavolo_confermato</p>";
            echo "<p><strong>Numero coperti:</strong> $n_coperti</p>";
            echo "<br><a href='index.php'>Torna alla lista comande</a>";
            
        } catch (Exception $e) {
            // In caso di errore, annulla la transazione
            $conn->rollback();
            echo "<h2>Errore durante la conferma della comanda:</h2>";
            echo "<p>" . $e->getMessage() . "</p>";
            echo "<br><a href='comanda.php'>Torna alla comanda</a>";
        }
        
    } else {
        echo "<h2>Errore: Dati mancanti per la conferma.</h2>";
        echo "<br><a href='comanda.php'>Torna alla comanda</a>";
    }
    
    $conn->close();
?>