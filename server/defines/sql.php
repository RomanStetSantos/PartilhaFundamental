<?php

require '../settings/readsettings.php';

$sqlsettings = readsettings("sql.txt", 5);

function Connect() {
    $mysqli = new msqli(
        $sqlsettings["host"], 
        $sqlsettings["username"], 
        $sqlsettings["password"], 
        $sqlsettings["database"], 
        $sqlsettings["port"]
    );
    return $mysqli;
}

function Disconnect($mysqli) {
    if (isset($mysqli)) {
        mysqli_close($mysqli);
        $mysqli = null;
    }
}

function ExecuteQuery($statement, $datatype, $values) {
    try {
        $mysqli = Connect();
        $pst = $mysqli -> prepare($statement);
        $pst->bind_param($datatype, $values);
        $pst->execute();
        $result = $pst->get_result();
        Disconnect($mysqli);
        return $result;
    }
    catch(Exception $e) {
        echo 'Query Error: ' . $e->getMessage();
        return false;
    }
}

function Execute($statement, $datatype, $values) {
    try {
        $mysqli = Connect();
        $pst = $mysqli -> prepare($statement);
        $pst->bind_param($datatype, $values);
        $pst->execute();
        Disconnect($mysqli);
        return true;
    }
    catch(Exception $e) {
        echo 'Execute Error: ' . $e->getMessage();
        return false;
    }
}

function ExecuteWithoutReturn($statement, $datatype, $values) {
    try {
        $mysqli = Connect();
        $pst = $mysqli -> prepare($statement);
        $pst->bind_param($datatype, $values);
        $pst->execute();
        Disconnect($mysqli);
    }
    catch(Exception $e) {
        echo 'Execute Asynch Error: ' . $e->getMessage();
    }
}

?>
