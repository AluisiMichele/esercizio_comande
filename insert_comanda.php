<?php
    session_start();
    include('database.php');

    // Inizializza l'array dei piatti temporanei se non esiste
    if (!isset($_SESSION['piatti_temporanei'])) {
        $_SESSION['piatti_temporanei'] = array();
    }

    // Ottieni la quantità dei piatti, con valore predefinito 1 se non specificato
    $quantita = isset($_POST['quantita']) ? intval($_POST['quantita']) : 1;
    
    // Assicurati che la quantità sia almeno 1
    if ($quantita < 1) $quantita = 1;

    // Ottieni i dati del piatto dal menu
    $id_menu = $_POST['ID_menu'];
    $sql_menu = "SELECT Descrizione_piatto FROM menu WHERE ID_menu = $id_menu";
    $result_menu = $conn->query($sql_menu);
    
    if ($result_menu && $result_menu->num_rows > 0) {
        $row_menu = $result_menu->fetch_assoc();
        $descrizione_piatto = $row_menu['Descrizione_piatto'];
        
        // Controlla se il piatto esiste già nell'array temporaneo
        $piatto_esistente = false;
        foreach ($_SESSION['piatti_temporanei'] as $key => $piatto) {
            if ($piatto['id_menu'] == $id_menu) {
                // Aggiorna la quantità del piatto esistente
                $_SESSION['piatti_temporanei'][$key]['quantita'] += $quantita;
                $piatto_esistente = true;
                break;
            }
        }
        
        // Se il piatto non esiste, aggiungilo all'array
        if (!$piatto_esistente) {
            $_SESSION['piatti_temporanei'][] = array(
                'id_menu' => $id_menu,
                'descrizione' => $descrizione_piatto,
                'quantita' => $quantita,
                'prezzo' => $_POST['prezzo'],
                'costo' => $_POST['costo']
            );
        }
    }

    // Reindirizza alla pagina comanda
    header("Location: comanda.php");
    exit();

    $conn->close();
?>