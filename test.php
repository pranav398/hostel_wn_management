<?php
    include "includes/db.php";
    session_start();
    date_default_timezone_set('Asia/Kolkata');
    function updateHead(){
        $params = $_GET;
        $params['date'] = date("d.m.Y");

        header("Location: ?" . http_build_query($params));
        exit;
    }

    if (empty($_GET['date'])) updateHead();

    $today = new DateTime('today');
    $maxDate = (clone $today)->modify('+6 days');
    $current = DateTime::createFromFormat('!d.m.Y', $_GET['date']);
    $sqlDate = DateTime::createFromFormat('d.m.Y', $_GET['date'])->format('Y-m-d');
    $selected = DateTime::createFromFormat('!d.m.Y', $_GET['date']);

    if (!preg_match('/^\d{2}\.\d{2}\.\d{4}$/', $_GET['date'])) updateHead();
    if (!$selected || $selected->format('d.m.Y') !== $_GET['date']) updateHead();
    if ($selected < $today || $selected > $maxDate) updateHead();

    $disablePrev = $current == $today;
    $disableNext = $current == $maxDate;


    $hn = $_SESSION['hn'];
    $roll = $_SESSION['roll'];

    $wmsql = "SELECT * FROM `wm` WHERE `wm_id` LIKE '{$hn}___'";
    $wmresult = $conn->query($wmsql);
    $wm = [];
    $wmMap=[];

    while($wmrow = $wmresult->fetch_assoc()){
        $wm[] = $wmrow;
    }
    
    foreach($wm as $machine){
        $wmMap[$machine['wm_id']]=$machine;
    }

    $logsql = "SELECT * FROM `log` WHERE `wm_id` LIKE '{$hn}___' AND `status` = '1' AND DATE(`time`) = '$sqlDate'";
    $logresult = $conn->query($logsql);
    $log = [];
    $logMap=[];

    while($logrow = $logresult->fetch_assoc()){
        $wmid = $logrow['wm_id'];

        $slot = date(
            "H:i",
            strtotime($logrow['time'])
        );

        $logMap[$wmid][$slot] = $logrow;
    }

    print_r($wm);
    echo "<br><br>";
    print_r($wmMap);
    echo "<br><br>";
    print_r($wmMap['161021']['working']);
    echo "<br><br>";
    print_r($logMap['161021']['00:00']);
    echo "<br><br>";
    $var = "Hello";
    echo substr($var,1,2);
    echo "<br><br>";
    if(1) echo "2";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: #1e1e1e;
            margin: 0;                 
            min-height: 100vh;    
            color: aliceblue;     
        }
    </style>
</head>
<body>

</body>
</html>