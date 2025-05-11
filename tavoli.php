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

    echo "<p>SELEZIONA IL TAVOLO</p><br>";

    echo "<form method ='GET' action = 'comanda.php'>";  

            echo "<input type='submit' name = 'Id_tavolo' value='1'><br>";
            echo "<input type='submit' name = 'Id_tavolo' value='2'><br>";
            echo "<input type='submit' name = 'Id_tavolo' value='3'><br>";
            echo "<input type='submit' name = 'Id_tavolo' value='4'><br>";
            echo "<input type='submit' name = 'Id_tavolo' value='5'><br>";

       
    echo"</form>";

?>


    </body>

    </html>