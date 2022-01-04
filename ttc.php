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
}
</style>

<?php 

session_start();

// ___________INIT GAME BOARD___________ //

if (!isset($_SESSION["tab"])){
    $_SESSION["tab"] = ['&nbsp','&nbsp','&nbsp','&nbsp','&nbsp','&nbsp','&nbsp','&nbsp','&nbsp'];
    $_SESSION["count"] = 0;
    $_SESSION["empty"] = [0,1,2,3,4,5,6,7,8];
}


// ___________EMPTY BOX___________ //

// if($_SESSION["tab"][0]==$_SESSION["tab"][1]||$_SESSION["tab"][0]==$_SESSION["tab"][2]||$_SESSION["tab"][1]==$_SESSION["tab"][2]){
//     while($over2 == false){
//         $box2 = rand(0, 2);
//         if(($_SESSION["tab"][$box2]=='&nbsp')){
//             $_SESSION["tab"][$box] = "O";
//             $_SESSION["count"] ++;
//             $over = true;
//             $over2 = true;
//             unset($_SESSION["empty"][$box]);
//             header('Location:ttc.php');
//         }
//     }
// }

// ___________PLAY___________ //
if($_SESSION["count"]%2 && sizeof($_SESSION["empty"])>=1 && !isset($_SESSION['over'])&& $_SESSION["count"]<8){ // computer
    while($over == false){
        $box = rand(0, 8);
        if($_SESSION["tab"][4]=='&nbsp'){ // play center if free
            $_SESSION["tab"][4] = "O";
            $_SESSION["count"] ++;
            $over = true;
            unset($_SESSION["empty"][$box]);
            header('Location:ttc.php');
        }
        elseif($_SESSION["c1"] <2 && ($_SESSION["tab"][0]==$_SESSION["tab"][1]||$_SESSION["tab"][0]==$_SESSION["tab"][2]||$_SESSION["tab"][1]==$_SESSION["tab"][2]) && ($_SESSION["tab"][0]=='X'||$_SESSION["tab"][1]=='X'||$_SESSION["tab"][2]=='X')){
            if($_SESSION["tab"][0]==$_SESSION["tab"][1]&&$_SESSION["tab"][2]=='&nbsp'&&$_SESSION["tab"][1]=='X'&&$_SESSION["tab"][0]=='X'){
                $_SESSION["tab"][2] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            if($_SESSION["tab"][0]==$_SESSION["tab"][2]&&$_SESSION["tab"][1]=='&nbsp'&&$_SESSION["tab"][2]=='X'&&$_SESSION["tab"][0]=='X'){
                $_SESSION["tab"][1] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            if($_SESSION["tab"][1]==$_SESSION["tab"][2]&&$_SESSION["tab"][0]=='&nbsp'&&$_SESSION["tab"][1]=='X'&&$_SESSION["tab"][2]=='X'){
                $_SESSION["tab"][0] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            $_SESSION["c1"]++;
        }
        elseif($_SESSION["c2"] <2 && ($_SESSION["tab"][0]==$_SESSION["tab"][3]||$_SESSION["tab"][0]==$_SESSION["tab"][6]||$_SESSION["tab"][3]==$_SESSION["tab"][6]) && ($_SESSION["tab"][0]=='X'||$_SESSION["tab"][3]=='X'||$_SESSION["tab"][6]=='X')){
            if($_SESSION["tab"][0]==$_SESSION["tab"][3]&&$_SESSION["tab"][6]=='&nbsp'&&$_SESSION["tab"][0]=='X'&&$_SESSION["tab"][3]=='X'){
                $_SESSION["tab"][6] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            if($_SESSION["tab"][3]==$_SESSION["tab"][6]&&$_SESSION["tab"][0]=='&nbsp'&&$_SESSION["tab"][3]=='X'&&$_SESSION["tab"][6]=='X'){
                $_SESSION["tab"][0] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            if($_SESSION["tab"][0]==$_SESSION["tab"][6]&&$_SESSION["tab"][3]=='&nbsp'&&$_SESSION["tab"][0]=='X'&&$_SESSION["tab"][6]=='X'){
                $_SESSION["tab"][3] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            $_SESSION["c2"]++;
        }
        elseif($_SESSION["c3"] <2 && ($_SESSION["tab"][6]==$_SESSION["tab"][8]||$_SESSION["tab"][8]==$_SESSION["tab"][7]||$_SESSION["tab"][6]==$_SESSION["tab"][7]) && ($_SESSION["tab"][6]=='X'||$_SESSION["tab"][7]=='X'||$_SESSION["tab"][8]=='X')){
            if($_SESSION["tab"][6]==$_SESSION["tab"][7]&&$_SESSION["tab"][8]=='&nbsp'&&$_SESSION["tab"][6]=='X'&&$_SESSION["tab"][7]=='X'){
                $_SESSION["tab"][8] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            if($_SESSION["tab"][7]==$_SESSION["tab"][8]&&$_SESSION["tab"][6]=='&nbsp'&&$_SESSION["tab"][7]=='X'&&$_SESSION["tab"][8]=='X'){
                $_SESSION["tab"][6] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            if($_SESSION["tab"][6]==$_SESSION["tab"][8]&&$_SESSION["tab"][7]=='&nbsp'&&$_SESSION["tab"][6]=='X'&&$_SESSION["tab"][8]=='X'){
                $_SESSION["tab"][7] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            $_SESSION["c3"]++;
        }
        elseif($_SESSION["c4"] <2 && ($_SESSION["tab"][2]==$_SESSION["tab"][5]||$_SESSION["tab"][5]==$_SESSION["tab"][8]||$_SESSION["tab"][2]==$_SESSION["tab"][8]) && ($_SESSION["tab"][2]=='X'||$_SESSION["tab"][5]=='X'||$_SESSION["tab"][8]=='X')){
            if($_SESSION["tab"][2]==$_SESSION["tab"][5]&&$_SESSION["tab"][8]=='&nbsp'&&$_SESSION["tab"][2]=='X'&&$_SESSION["tab"][5]=='X'){
                $_SESSION["tab"][8] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            if($_SESSION["tab"][5]==$_SESSION["tab"][8]&&$_SESSION["tab"][2]=='&nbsp'&&$_SESSION["tab"][5]=='X'&&$_SESSION["tab"][8]=='X'){
                $_SESSION["tab"][2] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            if($_SESSION["tab"][2]==$_SESSION["tab"][8]&&$_SESSION["tab"][5]=='&nbsp'&&$_SESSION["tab"][2]=='X'&&$_SESSION["tab"][8]=='X'){
                $_SESSION["tab"][5] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            $_SESSION["c4"]++;
        }
        elseif($_SESSION["c5"] <2 && ($_SESSION["tab"][0]==$_SESSION["tab"][4]||$_SESSION["tab"][4]==$_SESSION["tab"][8]||$_SESSION["tab"][0]==$_SESSION["tab"][8]) && ($_SESSION["tab"][0]=='X'||$_SESSION["tab"][4]=='X'||$_SESSION["tab"][8]=='X')){
            if($_SESSION["tab"][0]==$_SESSION["tab"][4]&&$_SESSION["tab"][8]=='&nbsp'&&$_SESSION["tab"][0]=='X'&&$_SESSION["tab"][4]=='X'){
                $_SESSION["tab"][8] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            if($_SESSION["tab"][4]==$_SESSION["tab"][8]&&$_SESSION["tab"][0]=='&nbsp'&&$_SESSION["tab"][4]=='X'&&$_SESSION["tab"][8]=='X'){
                $_SESSION["tab"][0] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            if($_SESSION["tab"][0]==$_SESSION["tab"][8]&&$_SESSION["tab"][4]=='&nbsp'&&$_SESSION["tab"][0]=='X'&&$_SESSION["tab"][8]=='X'){
                $_SESSION["tab"][4] = "O";
                $_SESSION["count"] ++;
                $over = true;
                unset($_SESSION["empty"][$box]);
                header('Location:ttc.php');
            }
            $_SESSION["c5"]++;
        }
        elseif($_SESSION["tab"][$box]=='&nbsp'){ // play random
            $_SESSION["tab"][$box] = "O";
            $_SESSION["count"] ++;
            $over = true;
            unset($_SESSION["empty"][$box]);
            header('Location:ttc.php');
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
        header('Location:ttc.php');
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

if(count($_SESSION["empty"]) <1 ){
    $_SESSION['over'] = $_SESSION["tab"];
}

// ___________RESTART___________ //

if(isset($_GET['restart'])){
    session_destroy();
    header('Location:ttc.php');
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