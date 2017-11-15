<?php 

    function tokenize($str, $token_symbols) {
    $word = strtok($str, $token_symbols);
    global $query, $queryfinal;
    $queryfinal.=$query;
    $queryfinal.= "WHERE id = '$word'";
    $word= strtok($token_symbols);
    while (false !== $word) {
        $queryfinal.=" OR id ='$word';";
        $word = strtok($token_symbols);
    }
    return $queryfinal;
}
?>