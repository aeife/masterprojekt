<?php

    function array_sort($array, $on, $order=SORT_ASC)
    {
        //source: http://php.net/manual/de/function.sort.php
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                break;
                case SORT_DESC:
                    arsort($sortable_array);
                break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    include('../smarty/Smarty.class.php');
    $smarty = new Smarty;

    $username="root";
    $database="masterprojekt";

    mysql_connect('localhost',$username, "");
    mysql_select_db($database);

    $result = mysql_query("SELECT distinct(username) FROM game ORDER BY username");
    $users = [];

    while ($row = mysql_fetch_array($result)){
        if ($row[0] != "Guest")
            array_push($users, ["username" => $row[0], "score" => 0]);
    }


    $result = mysql_query("SELECT * FROM game WHERE username != 'Guest' ORDER BY username ");

    $score = [];
    while ($row = mysql_fetch_array($result)){
        array_push($score, ["username" => $row['username'], "place" => $row['place']]);
    }

    $j = 0;
    for ($i = 0; $i < sizeof($users); $i++){
        while ($j < sizeof($score) && $users[$i]["username"] == $score[$j]["username"] ){
            switch ($score[$j]["place"]){
                case 1:
                    $users[$i]["score"] += 50;
                    break;
                case 2:
                    $users[$i]["score"] += 25;
                    break;
                case 3:
                    $users[$i]["score"] += 10;
                    break;
                case 4:
                    $users[$i]["score"] += 5;
                    break;
            }
            $j++;
        }
    }

    array_sort($users, "score", SORT_DESC);

    $smarty = new Smarty();
    $smarty->assign('list', $users);
    $smarty->display('../views/scorePlayers.tpl');

?> 