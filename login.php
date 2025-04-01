
<!DOCTYPE html>
    <html>

    <head>
    <link rel="stylesheet" href="style.css">
    </head>

    <body>

    <?php

session_start();

include "database.php";

$timeout = 900; 

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $username = $_POST['nome_utente'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM camerieri WHERE username = ? AND pass_id = ?";
    $query = $conn->prepare($sql);
    $query->bind_param("ss", $username, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 1) 
    {
        $row = $result->fetch_assoc();

        $_SESSION['login'] = "OK";
        $_SESSION['nome_utente'] = $row['username'];
        $_SESSION['password'] = $row['pass_id'];
        $_SESSION['last_activity'] = time(); 
        
        header("Location: index.php");
        exit();
    } 
    else 
    {
        $errore = "Credenziali errate!";
    }
}
    

    
   echo "<form method='POST' action='login.php'>";
    
   echo "<p>Nome utente</p>";
    echo "<input type='text' name='nome_utente' value=''>";
    echo "<p>Password</p>";
    echo "<input type=text name='password' value=''>";
    echo "<br><br><input type=submit>";

   echo "</form>";

   if (isset($errore)) echo "<p style='color: red;'>$errore</p>";

?>


    </body>

    
    </html>