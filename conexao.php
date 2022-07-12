<?php            
        
        $host = "localhost";
        $username = "";
        $password = "";
        $dbname = "";


        $con = mysqli_connect($host, $username, $password, $dbname);

        if (!$con)
        {
            die("A conexao falhou!" . mysqli_connect_error());
        }
        
