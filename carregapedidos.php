<?php
require('conexao.php');

$sql = "select * from pedidos ORDER BY data DESC";

$resultado = $con->query($sql);

if ($resultado->num_rows > 0) {
while ($row = $resultado->fetch_assoc()) {
    
        if($row["ok"] == 0){
            
            if($row["observacao"] != ""){
                
                echo"<div style='width: 70%; border: 2px solid red;'>";
                echo"<br>";
                echo"<h2>Pedido: ".$row["id"]."</h2>";
                echo"<br>";
                echo"<h3>Mesa: ".$row["mesa"]."</h3>";
                echo"<hr style='border-color: red; width: 60%;'>";
                echo"<br>";
                $cod = $row["cod"];
                $sql2 = "select * from item_pedido WHERE pedido_cod = '$cod' ORDER BY nome ASC";
                $resultado2 = $con->query($sql2);
                if ($resultado2->num_rows > 0) {
                    while ($row2 = $resultado2->fetch_assoc()) {
                        echo"<h3 style='color: blue;'>".$row2["quantidade"]."x - ".$row2["nome"]."</h3><br>";
                    }
                }
                echo"<hr style='border-color: red; width: 60%;'>";
                echo"<h3>Observação: ".$row["observacao"]."</h3>";
                echo"<br>";
                echo"<h3>Status: <b style='color: red;'>A Fazer</b></h3>";
                echo"<br>";
                
            }else{
                
                echo"<div style='width: 70%; border: 2px solid red;'>";
                echo"<br>";
                echo"<h2>Pedido: ".$row["id"]."</h2>";
                echo"<br>";
                echo"<h3>Mesa: ".$row["mesa"]."</h3>";
                echo"<hr style='border-color: red; width: 60%;'>";
                echo"<br>";
                $cod = $row["cod"];
                $sql2 = "select * from item_pedido WHERE pedido_cod = '$cod' ORDER BY nome ASC";
                $resultado2 = $con->query($sql2);
                if ($resultado2->num_rows > 0) {
                    while ($row2 = $resultado2->fetch_assoc()) {
                        echo"<h3 style='color: blue;'>".$row2["quantidade"]."x - ".$row2["nome"]."</h3><br>";
                    }
                }
                echo"<hr style='border-color: red; width: 60%;'>";
                echo"<h3>Status: <b style='color: red;'>A Fazer</b></h3>";
                echo"<br>";
                
            }
            
            echo "<form method='GET' action='pedidos.php' enctype='multipart/form-data'>
                        <div class='text-wrap'>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <input name='id' type='hidden' value='".$row['id']."'>
                                    <input name='ok' style='background-color: green; border-color: green; color: white;' type='submit' value='Feito' class='btn-sm btn-primary'>
                                </div>
                            </div>
                        </div>
                    </form>";
            echo"<br>";        
            echo"</div>";        
            echo "<br><br>";  
            
        }else{
            if($row["observacao"] != ""){
                
                echo"<div style='width: 70%; border: 2px solid green;'>";
                echo"<br>";
                echo"<h2>Pedido: ".$row["id"]."</h2>";
                echo"<br>";
                echo"<h3>Mesa: ".$row["mesa"]."</h3>";
                echo"<hr style='border-color: green; width: 60%;'>";
                echo"<br>";
                $cod = $row["cod"];
                $sql2 = "select * from item_pedido WHERE pedido_cod = '$cod' ORDER BY nome ASC";
                $resultado2 = $con->query($sql2);
                if ($resultado2->num_rows > 0) {
                    while ($row2 = $resultado2->fetch_assoc()) {
                        echo"<h3 style='color: blue;'>".$row2["quantidade"]."x - ".$row2["nome"]."</h3><br>";
                    }
                }
                echo"<hr style='border-color: green; width: 60%;'>";
                echo"<h3>Observação: ".$row["observacao"]."</h3>";
                echo"<br>";
                echo"<h3>Status: <b style='color: green;'>Feito</b></h3>";
                echo"<br>";
                
            }else{
                
                echo"<div style='width: 70%; border: 2px solid green;'>";
                echo"<br>";
                echo"<h2>Pedido: ".$row["id"]."</h2>";
                echo"<br>";
                echo"<h3>Mesa: ".$row["mesa"]."</h3>";
                echo"<hr style='border-color: green; width: 60%;'>";
                echo"<br>";
                $cod = $row["cod"];
                $sql2 = "select * from item_pedido WHERE pedido_cod = '$cod' ORDER BY nome ASC";
                $resultado2 = $con->query($sql2);
                if ($resultado2->num_rows > 0) {
                    while ($row2 = $resultado2->fetch_assoc()) {
                        echo"<h3 style='color: blue;'>".$row2["quantidade"]."x - ".$row2["nome"]."</h3><br>";
                    }
                }
                echo"<hr style='border-color: green; width: 60%;'>";
                echo"<h3>Status: <b style='color: green;'>Feito</b></h3>";
                echo"<br>";
                
            }
            echo "<form method='GET' action='pedidos.php' enctype='multipart/form-data'>
                        <div class='text-wrap'>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <input name='id' type='hidden' value='".$row['id']."'>
                                    <input name='ok' style='background-color: red; border-color: red; color: white;' type='submit' value='Desfazer' class='btn-sm btn-primary'>
                                </div>
                            </div>
                        </div>
                    </form>";
            echo"<br>";         
            echo"</div>";         
            echo "<br>";         
        }
    }
}

?>