<?php
function fnGetPagesFromTable($table) {
    global $dbconn;
    $qry = "SELECT count(id) as aantal FROM " . $table . ";";
    try {
        $stmt = $dbconn->prepare($qry);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $result = $row['aantal'];
    } catch(PDOException $e) {
        $result = 0;
    }
return $result;
}

function witregel($teller) {
    for($i = 1; $i <= $teller; $i++) {
        echo '<br>';
    }
}
?>