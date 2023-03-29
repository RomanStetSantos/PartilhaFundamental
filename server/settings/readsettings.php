<?php

function read($file, $length) {
    $length -= 1;
    $connector = "=";
    $openedfile = fopen($file, "r");
    $infoarray = array();

    if (!$openedfile) {
        echo 'Ficheiro nao existe';
        return 0;
    }

    try {
        for ($i = 0; $i<=$length; $i++) {
            $string = fgets($openedfile, 4096);
            $info = explode($connector, $string);
            if (!isset($info[1])) {
                echo 'Campo invalido em ' . $info[0];
                return 0;
            }
            $infoarray[$info[0]] = $info[1];
        }
    } catch(Exception $ee) {
        echo 'Erro durante leitura: ', $ee->getMessage();
        return 0;
    }
    return $infoarray;
}

?>
