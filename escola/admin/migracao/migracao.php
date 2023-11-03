<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    function arredondaNota($nota) {
        $parteDecimal = $nota - floor($nota);
    
        if($parteDecimal == 0){
            return ($nota);
        } else 
            if($parteDecimal >= 0.25 && $parteDecimal <= 0.6){
                return (floor($nota) + 0.5);
        
            } else{
                if($parteDecimal > 0.6){
                    return ceil($nota);
                }
                else{
                    return floor($nota);
                }
            } 
    }
    

    $nota1 = 6;

    echo $nota1 - floor($nota1); 
    echo "<br>";

    $notaArredondada1 = arredondaNota($nota1);

    echo "Nota 1: $notaArredondada1";
    ?>

</body>
</html>