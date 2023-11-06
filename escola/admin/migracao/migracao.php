<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        require 'functions.php';
        $newCaneta = new Caneta("Sim", "Preta", "0.7");
        $newCaneta2 = new Caneta("Não", "Azul", "0.9");
        
        $result = $newCaneta2-> exibirCaneta();
        echo $result;
    ?>

</body>
</html>