
<div class="newgame">
    <form method="get">
        <input type='submit' value='STOP' name='stop'>  </input>   
    </form>
</div>

<?php
session_start();

$u = 0;
echo $_GET["stop"] ;

// while ($_GET["stop"] != "STOP"){
while ($u==0){


//  ___________Connect to DB ___________ //

$servername = "localhost";
$username = "root";
$password = "root";

// Create connection

$conn = new mysqli($servername, $username, $password, 'TTC');

// ___________INIT GAME BOARD___________ //

if (!isset($_SESSION["tab"])){
    $_SESSION["tab"] = ['&nbsp','&nbsp','&nbsp','&nbsp','&nbsp','&nbsp','&nbsp','&nbsp','&nbsp'];
    $_SESSION["count"] = 0;
    $_SESSION["empty"] = [0,1,2,3,4,5,6,7,8];
    $_SESSION["debug"] = array();
    $id1 = array();
}

//___________GET Q table___________ //

$sql = "SELECT * FROM `qtable`";
$query = $conn->query($sql);
$situations  = $query->fetch_all();

// ___________PLAY___________ //
$over = false;
$over2 = false;
$played = false;
$count = 0;
$action = null;
if($_SESSION["count"]%2 && sizeof($_SESSION["empty"])>=1 && !isset($_SESSION['over'])&& $_SESSION["count"]<8){ 
    $chance = 99;
    $rand = rand(1,100);
    if (($rand <= $chance) && $situations != null){    // play bestmove 70% chances
        foreach($situations as $situation){
            $sit = unserialize($situation[0]);
            $action = unserialize($situation[1]);
            $value = $situation[3];
            if ($_SESSION["tab"] == $sit){
                $id_states[] = [$situation[2],$situation[3]];
            }
        }
        if (isset($id_states)){ // if state in Q-table
            // get best move 
            $i = 0;
            $highest = 0;
            while(isset($id_states[$i])){
                if ($id_states[$i][1]>$higher){
                    $highest = $id_states[$i][1];
                }
            $i++;
            }
            $i = 0;
            while(isset($id_states[$i])){
                if($id_states[$i][1]==$highest){
                    $id1[] = $id_states[$i][0];
                }
            $i++;
            }
            $a = rand(0,count($id1));
            $id = $id1[$a];
            foreach($situations as $situation){
                $sit = unserialize($situation[0]);
                if ($id == $situation[2]){
                    $action = unserialize($situation[1]);
                }
            }
            // play best move
            if ($_SESSION["tab"][$action] == "&nbsp"){
                $_SESSION["actions"][]=[$_SESSION["tab"],$action];
                $_SESSION["tab"][$action] = "O";
                unset($_SESSION["empty"][$action]);
                $played = true;
            }
        }
        else{ // random play + store S/A if state not in Q-table
            while($over == false){
                $box = rand(0, 8);
                if($_SESSION["tab"][$box]=='&nbsp'){ // play
                    $_SESSION["actions"][]=[$_SESSION["tab"],$box];
                    $_SESSION["tab"][$box] = "O";
                    unset($_SESSION["empty"][$box]);
                    $_SESSION["count"] ++;
                    $over = true;
                }
            }
            foreach($situations as $situation){ // S/A already in Q-table ?
                $sit = unserialize($situation[0]);
                $action = unserialize($situation[1]);
                if ($_SESSION["tab"] == $sit && $box == $action ){
                    $count = 1;
                }  
            }  
            if($count == 0){ // store if not
                $ser_situ = $_SESSION["tab"];
                $ser_situ = serialize( $ser_situ);
                $ser_box = $box;
                $ser_box = serialize($ser_box);
                $sql2 ="INSERT Into qtable (states, act) VALUES ('$ser_situ','$ser_box')";
                $query = $conn->query($sql2);
            }  
        }
    }
    else{   // random play + store S/A if new
        while($over == false){
            $box = rand(0, 8);
            if($_SESSION["tab"][$box]=='&nbsp'){ // play
                $_SESSION["actions"][]=[$_SESSION["tab"],$box];
                $_SESSION["tab"][$box] = "O";
                unset($_SESSION["empty"][$box]);
                $_SESSION["count"] ++;
                $over = true;
            }
        }
        if($situations==NULL){ // init q-table
            $ser_situ = $_SESSION["tab"];
            $ser_situ = serialize($ser_situ);
            $ser_box = $box;
            $ser_box = serialize($ser_box);
            $sql2 ="INSERT Into qtable (states, act) VALUES ('$ser_situ','$ser_box')";
            $query = $conn->query($sql2);   
        }
        else{
            foreach($situations as $situation){ // S/A already in Q-table ?
                $sit = unserialize($situation[0]);
                $action = unserialize($situation[1]);
                if ($_SESSION["tab"] == $sit && $box == $action ){
                    $count = 1;
                }  
            }  
            if($count == 0){ // store if not
                $ser_situ = $_SESSION["tab"];
                $ser_situ = serialize( $ser_situ);
                $ser_box = $box;
                $ser_box = serialize($ser_box);
                $sql2 ="INSERT Into qtable (states, act) VALUES ('$ser_situ','$ser_box')";
                $query = $conn->query($sql2);
            }  
        }
    }
}
elseif(!isset($_SESSION['over'])){ // 2nd player 
    while($over2 == false){
        $box = rand(0, 8);
        if($_SESSION["tab"][$box]=='&nbsp'){
            $_SESSION["tab"][$box] = "X";
            $_SESSION["count"] ++;
            unset($_SESSION["empty"][$box]);
            $over2 = true;
        }
    }       
}

// ___________GAME over & RESULT___________ //

if($_SESSION["tab"][3] == $_SESSION["tab"][0] && $_SESSION["tab"][3] == $_SESSION["tab"][6] && $_SESSION["tab"][0] != '&nbsp' && $_SESSION["tab"][3] != '&nbsp' && $_SESSION["tab"][6] != '&nbsp'){ // A1 B1 C1 
    $_SESSION['over'] = $_SESSION["tab"][3];
}
if($_SESSION["tab"][4] == $_SESSION["tab"][1] && $_SESSION["tab"][4] == $_SESSION["tab"][7] && $_SESSION["tab"][1] != '&nbsp' && $_SESSION["tab"][4] != '&nbsp' && $_SESSION["tab"][7] != '&nbsp'){ // A2 B2 C2 
    $_SESSION['over'] = $_SESSION["tab"][4];
}
if($_SESSION["tab"][5] == $_SESSION["tab"][2] && $_SESSION["tab"][5] == $_SESSION["tab"][8] && $_SESSION["tab"][2] != '&nbsp' && $_SESSION["tab"][5] != '&nbsp' && $_SESSION["tab"][8] != '&nbsp'){ // A3 B3 C3 
    $_SESSION['over'] = $_SESSION["tab"][5];
}

if($_SESSION["tab"][1] == $_SESSION["tab"][0] && $_SESSION["tab"][1] == $_SESSION["tab"][2] && $_SESSION["tab"][0] != '&nbsp' && $_SESSION["tab"][1] != '&nbsp' && $_SESSION["tab"][2] != '&nbsp'){ // A1 A2 A3 
    $_SESSION['over'] = $_SESSION["tab"][1];
}
if($_SESSION["tab"][4] == $_SESSION["tab"][3] && $_SESSION["tab"][4] == $_SESSION["tab"][5] && $_SESSION["tab"][3] != '&nbsp' && $_SESSION["tab"][4] != '&nbsp' && $_SESSION["tab"][5] != '&nbsp'){ // B1 B2 B3 
    $_SESSION['over'] = $_SESSION["tab"][5];
}
if($_SESSION["tab"][7] == $_SESSION["tab"][6] && $_SESSION["tab"][7] == $_SESSION["tab"][8] && $_SESSION["tab"][6] != '&nbsp' && $_SESSION["tab"][7] != '&nbsp' && $_SESSION["tab"][8] != '&nbsp'){ // C1 C2 C3 
    $_SESSION['over'] = $_SESSION["tab"][7];
}

if($_SESSION["tab"][4] == $_SESSION["tab"][2] && $_SESSION["tab"][4] == $_SESSION["tab"][6] && $_SESSION["tab"][2] != '&nbsp' && $_SESSION["tab"][4] != '&nbsp' && $_SESSION["tab"][6] != '&nbsp'){ // A3 B2 C1 
    $_SESSION['over'] = $_SESSION["tab"][4];
}
if($_SESSION["tab"][4] == $_SESSION["tab"][0] && $_SESSION["tab"][4] == $_SESSION["tab"][8] && $_SESSION["tab"][0] != '&nbsp' && $_SESSION["tab"][4] != '&nbsp' && $_SESSION["tab"][8] != '&nbsp'){ // A1 B2 C3 
    $_SESSION['over'] = $_SESSION["tab"][4];
}

if(count($_SESSION["empty"]) <1 && !isset($_SESSION['over'])){ // draw
    $_SESSION['over'] = "/";
}

// ___________REWARD___________ //

if($_SESSION['over'] == "X"){
    $reward = 0;
    foreach(array_reverse($_SESSION["actions"]) as $actions){
        foreach($situations as $situation){
            $sit = unserialize($situation[0]);
            $action = unserialize($situation[1]);   
            if ($actions[0] == $sit && $actions[1] == $action ){
                $id = $situation[2];
                $val = 0.2 * (0.9 * $reward - $situation[3]) ;
                $sql2 ="UPDATE qtable SET value = '$val' WHERE id = '$id'";
                $query = $conn->query($sql2);   
                $reward = $val;
            }
        }
    }
}

if($_SESSION['over'] == "O"){
    $reward = 1;
    foreach(array_reverse($_SESSION["actions"]) as $actions){
        foreach($situations as $situation){
            $sit = unserialize($situation[0]);
            $action = unserialize($situation[1]);   
            if ($actions[0] == $sit && $actions[1] == $action ){
                $id = $situation[2];
                $val = 0.2 * (0.9 * $reward - $situation[3]) ;
                $sql2 ="UPDATE qtable SET value = '$val' WHERE id = '$id'";
                $query = $conn->query($sql2);   
                $reward = $val;
            }
        }
    }
}

if($_SESSION['over'] == "/"){
    $reward = 0.1; // set to 0.1
    foreach(array_reverse($_SESSION["actions"]) as $actions){
        foreach($situations as $situation){
            $sit = unserialize($situation[0]);
            $action = unserialize($situation[1]);   
            if ($actions[0] == $sit && $actions[1] == $action ){
                $id = $situation[2];
                $val = 0.2 * (0.9 * $reward - $situation[3]) ;
                $sql2 ="UPDATE qtable SET value = '$val' WHERE id = '$id'";
                $query = $conn->query($sql2);   
                $reward = $val;
            }
        }
    }
}
if (isset($_SESSION['over'])){
    $res = $_SESSION['over'];
    $sql2 ="INSERT Into result (result) VALUES ('$res')";
    $query = $conn->query($sql2);
    var_dump($_SESSION['over']);
    echo "<br>";
    echo count($situations);
    echo "<br>";
    session_destroy();
    unset($_SESSION['over']);
    unset($_SESSION["tab"]);
    unset($_SESSION["actions"]);
    $_SESSION['memory'] = array();
}

} // while

?>

