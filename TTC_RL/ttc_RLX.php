<!DOCTYPE html>
<html>
 <head>
 <title> Tic tac toe</title>
 </head>
 <body>

 <style> 
 table, th, td {
  width : 350px;
  height : 120px;
}

body{
    display : flex;
    flex-direction :row;
    justify-content : center;
    align-items: start;
    gap : 20px;
}

.container{
    display : flex;
    flex-direction : column;
    justify-content : center;
    align-items : center;
    gap: 10px;
}

button {
width :120px;
height :120px;
height : 100%;
background-color : darkslateblue;
color : white;
font-size : 70px;
font-weight : bold;
border :none;

}

.ggame{
    margin-top :50px;
}

form {
height : 100px;
}

p {
    text-align : center;
    font-size : 30px;
}

.newgame{
    width : 440px;
    height : 70px;
    background-color : darkslateblue;
    display : flex;
    flex-direction : row;
    justify-content : center;
    align-items : center;
    gap : 10px;
    margin-top: 30px;
}

.newgame input{
    padding : 7px;
    margin-top : 32px;
    background-color : white;
    font-family : monospace;
    border:none;
    font-size : 20px;
}

</style>

<?php 

session_start();

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
    $_SESSION["SQLstop"] = 0;
    $_SESSION["empty"] = [0,1,2,3,4,5,6,7,8];
}


//___________GET SITUATIONS___________ //
$sql = "SELECT * FROM `actions`";
$query = $conn->query($sql);
$situations  = $query->fetch_all();

// ___________PLAY___________ //
if($_SESSION["count"]%2 && sizeof($_SESSION["empty"])>=1 && !isset($_SESSION['over'])&& $_SESSION["count"]<8){ 
    while($over == false){
        $box = rand(0, 8);
        if($_SESSION["tab"][$box]=='&nbsp'){ 
            // add state + action BDD 
            if($situations==NULL){
                $ser_situ = $_SESSION["tab"];
                $ser_situ = serialize($ser_situ);
                $ser_box = $box;
                $ser_box = serialize($ser_box);
                $sql2 ="INSERT Into actions (states, act) VALUES ('$ser_situ','$ser_box')";
                $query = $conn->query($sql2);   
            }
            else{
                foreach($situations as $situation){
                    $sit = unserialize($situation[0]);
                    $action = unserialize($situation[1]);
                    if ($_SESSION["tab"] == $sit && $box == $action ){
                        $count = 1;
                    }
                }
                if($count == 0){
                    $ser_situ = $_SESSION["tab"];
                    $ser_situ = serialize( $ser_situ);
                    $ser_box = $box;
                    $ser_box = serialize($ser_box);
                    $sql2 ="INSERT Into actions (states, act) VALUES ('$ser_situ','$ser_box')";
                    $query = $conn->query($sql2);
                }       
            }   
            // play
            $_SESSION["actions"][]=[$_SESSION["tab"],$box];
            $_SESSION["tab"][$box] = "O";
            $_SESSION["count"] ++;
            $over = true;
            unset($_SESSION["empty"][$box]);
            header('Location:ttc_RLX.php');
        }
        elseif($_SESSION["count"]==8){
            $over = true;
        }      
    }
}
elseif(isset($_GET)&& !isset($_SESSION['over'])){ // player 
    if($_SESSION["tab"][key($_GET)-1]=='&nbsp'){
        $_SESSION["tab"][key($_GET)-1] = "X";
        $_SESSION["count"] ++;
        unset($_SESSION["empty"][key($_GET)-1]);
        header('Location:ttc_RLX.php');
        $_SESSION["SQLstop"]++;
    }
}
// ___________Is GAME over ?___________ //

if($_SESSION["tab"][3] == $_SESSION["tab"][0] && $_SESSION["tab"][3] == $_SESSION["tab"][6] && $_SESSION["tab"][0] != '&nbsp' && $_SESSION["tab"][3] != '&nbsp' && $_SESSION["tab"][6] != '&nbsp'){ // A1 B1 C1 
    $_SESSION['over'] = $_SESSION["tab"][3];
}
if($_SESSION["tab"][4] == $_SESSION["tab"][1] && $_SESSION["tab"][4] == $_SESSION["tab"][7] && $_SESSION["tab"][1] != '&nbsp' && $_SESSION["tab"][4] != '&nbsp' && $_SESSION["tab"][7] != '&nbsp'){ // A2 B2 C2 
    $_SESSION['over'] = $_SESSION["tab"][4];
}
if($_SESSION["tab"][5] == $_SESSION["tab"][2] && $_SESSION["tab"][5] == $_SESSION["tab"][8] && $_SESSION["tab"][2] != '&nbsp' && $_SESSION["tab"][5] != '&nbsp' && $_SESSION["tab"][6] != '&nbsp'){ // A3 B3 C3 
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

// ___________RESULT___________ //

if(count($_SESSION["empty"]) <1 && !isset($_SESSION['over'])){
    $_SESSION['over'] = "/";
}

// ___________LEARNING___________ //

if($_SESSION['over'] == "X"){
    foreach($situations as $situation){
        $sit = unserialize($situation[0]);
        $action = unserialize($situation[1]);
        foreach($_SESSION["actions"] as $actions){
            if ($actions[0] == $sit && $actions[1] == $action ){
                $id = $situation[2];
                $sql2 ="UPDATE actions SET value = '1' WHERE id = '$id'";
                $query = $conn->query($sql2);
            }
        }
    }
}  

if($_SESSION['over'] == "O"){
    foreach($situations as $situation){
        $sit = unserialize($situation[0]);
        $action = unserialize($situation[1]);
        foreach($_SESSION["actions"] as $actions){
            if ($actions[0] == $sit && $actions[1] == $action ){
                $id = $situation[2];
                $sql2 ="UPDATE actions SET value = '2' WHERE id = '$id'";
                $query = $conn->query($sql2);
            }
        }
    }
}

if($_SESSION['over'] == "/"){
    foreach($situations as $situation){
        $sit = unserialize($situation[0]);
        $action = unserialize($situation[1]);
        foreach($_SESSION["actions"] as $actions){
            if ($actions[0] == $sit && $actions[1] == $action ){
                $id = $situation[2];
                $sql2 ="UPDATE actions SET value = '0' WHERE id = '$id'";
                $query = $conn->query($sql2);
            }
        }
    }
}

// ___________RESTART___________ //

if(isset($_GET['restart'])){
    session_destroy();
    header('Location:ttc_RLX.php');
    $_SESSION['memory'] = array();
}

?>

<div class="HANGMAN">  <div class='newgame'> 
    <form method ="post" action="hangman.php">   
        <input type='submit' value='HANGMAN' name='newgame'> </input> 
    </form>   
</div> </div>

<div class="game">

<div class="container">
<div class="newgame">
    <form method="GET">
        <input type='submit' value='NEW GAME' name='restart'>  </input>   
    </form>
</div>
<div class="ggame">

<form method = "get">
    <table>
    <tr> 
        <td> <button type='submit' value=<?php echo $_SESSION["tab"][0]?> name='1'> <?php echo $_SESSION["tab"][0]?>  </button>     </td>  
        <td> <button type='submit' value=<?php echo $_SESSION["tab"][1]?> name='2'> <?php echo $_SESSION["tab"][1]?>  </button>     </td>  
        <td> <button type='submit' value=<?php echo $_SESSION["tab"][2]?> name='3'> <?php echo $_SESSION["tab"][2]?>  </button>     </td>  
        </tr>
    <tr> 
        <td> <button type='submit' value=<?php echo $_SESSION["tab"][3]?> name='4'><?php echo $_SESSION["tab"][3]?>   </button>    </td> 
        <td> <button type='submit' value=<?php echo $_SESSION["tab"][4]?> name='5'><?php echo $_SESSION["tab"][4]?>   </button>     </td> 
        <td> <button type='submit' value=<?php echo $_SESSION["tab"][5]?> name='6'><?php echo $_SESSION["tab"][5]?>   </button>     </td> 
        </tr>
    <tr> 
        <td> <button type='submit' value=<?php echo $_SESSION["tab"][6]?> name='7'><?php echo $_SESSION["tab"][6]?>   </button>    </td> 
        <td> <button type='submit' value=<?php echo $_SESSION["tab"][7]?> name='8'><?php echo $_SESSION["tab"][7]?>   </button>     </td>
        <td> <button type='submit' value=<?php echo $_SESSION["tab"][8]?> name='9'><?php echo $_SESSION["tab"][8]?>   </button>     </td>  
        </tr>
    <tr> 
</table>
<?php 

// $temp = [$_SESSION["tab"]];
// $temp = serialize($temp);
// $sql2 ="INSERT Into  actions (board) VALUES ('b')";
// $query = $conn->query($sql2); 

    echo "<pre>";
    var_dump($_SESSION["actions"]);
    // var_dump($_SESSION['debug']);
    // echo $sit != $_SESSION['debug'];
    echo "</pre>";

// var_dump($situations);
// echo "<pre>";
//     $temp = unserialize($situations[0][0]);
//     var_dump($_SESSION['debug_sit']);
//     var_dump($_SESSION['debug_board']);
//     echo "</pre>";
?>


</form>


</div>

</div>

</div>


<div class="memory">  <div class='newgame'> 
    <form method ="post" action="memory.php">   
        <input type='submit' value='MEMORY' name='newgame'> </input> 
    </form>   
</div> </div>
</body>
</html>