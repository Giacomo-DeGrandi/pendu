<?php 

session_start();

?>
<!DOCTYPE html>
<html>
 <head>
 <title> Runtrack PHP - Jour 7</title>
 <meta name="viewport" content="width=device-width, initial-scale=0.5">
 </head>
 <style> 

p {
    text-align : center;
    font-size : 30px;
}

.container{
    background-color : darkslateblue;
    width : 400px;
    height : 400px;
    display : flex;
    flex-direction :row;
    justify-content : center;
    align-items: start;
    padding : 20px;
}

main{
    display : flex;
    flex-direction :row;
    justify-content : center;
    align-items: start;
    gap : 20px;
}

span {
    font-size: 1em;
    font-family:  monospace;
}

a{  
    text-decoration: none;
    font-size: 1em;
    font-family:  monospace;
}
h2 { 
    font-size: 1.5em;
    font-family:  monospace;
    line-height: 5px;
}
h3 { 
    line-height: 5px;
    font-size: 1.5em;
    font-family:  monospace;
    display: inline;
}


.game{
    display : flex;
    flex-direction :column;
    justify-content : center;
    align-items: center;
    gap : 20px;
}

.container1{
    width : 100%;
    height : 100px;
    display : flex;
    flex-direction :row;
    justify-content : center;
    align-items: center;
}

.socle{
    display : flex ; 
    flex-direction : row;
    justify-content: end;
    align-items : end;
    height : 400px;
    width : 200px;
    margin-right : -50px;
    margin-left : -90px;
}

.base{
    width : 20px;
    height : 15px;
    background-color : white;  
}

.traverse{
    display : flex;
    flex-direction :row;
}

.brick{
    width : 20px;
    height : 40px;
    background-color : white;   
}

.brick2{
    width : 20px;
    height : 20px;
    background-color : white;   
}

.tête{
    width : 40px;
    height : 40px;
    background-color : white;  
    border-radius : 1100px;
    margin-left :-8px;
    margin-top: 10px;  
}

.tronc{
    display : flex ; 
    flex-direction : row;
    gap : 6px;
    margin-left : -25px;
}

.one{
    width : 10px; 
}

.two{
    width : 40px; 
}

.three{
    width : 10px; 
}

.thorax{
    width : 40px;
    height : 100px;
    background-color : white;  
    border-radius : 90px;
    margin-top: 10px;  
}

.arm1{
    width : 10px;
    height : 70px;
    background-color : white;  
    border-radius : 90px;
    margin-top: 20px;  
}

.arm2{
    width : 10px;
    height : 70px;
    background-color : white;  
    border-radius : 90px;
    margin-top: 20px;  

}

.legs{
    display : flex ; 
    flex-direction : row;
    gap : 15px;
}

.leg1{
    width : 15px;
    height : 90px;
    background-color : white;  
    border-radius : 90px;
    margin-left :-8px;
    margin-top: 10px;  
}

.leg2{
    width : 15px;
    height : 90px;
    background-color : white;  
    border-radius : 90px;
    margin-left :-8px;
    margin-top: 10px;  
}

.text{
    width : 550px;
    height : 70px;
    background-color : darkslateblue;
    display : flex;
    flex-direction : row;
    justify-content : center;
    align-items : center;
    gap : 10px;
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
    background-color : white;
    font-family : monospace;
    border:none;
    font-size : 20px;
}

.text input{
    width : 30px;
    height : 30px;
    text-align :center;
}
.divletter {
    background-color: white;
    font-family : monospace;
    padding: 10px;
    width: 25px;
    height: 25px;
    font-size: 2em;
    text-align: center;
}
.divvic {
    background-color: white;
    font-family : monospace;
    font-size: 1.5em;
    text-align: center;
}

.divvic input {
    font-family : monospace;
    font-size: 1em;
    padding: 5px;
}
#lettre {
    color: white; 
}

</style>
 <body>
    <main>
<?php 

if(isset($_SESSION['erreur'])){
   // echo $_SESSION['erreur']; don't do nothing
} else {
    $_SESSION['erreur']=0;
}

// __________ declare WORDS __________ //

$str = file_get_contents('mots.txt');
$result = explode(' ',$str); 
$result = $result[array_rand($result)];
$_SESSION["words"]=$result;

// __________ define current WORD __________ //

if(!isset($_SESSION["display"])){
    $_SESSION["Cword"] = str_split($_SESSION["words"]);
    foreach($_SESSION["Cword"] as $word){
        $_SESSION["display"][]="";
    }
}

// __________Compare INPUT with WORD __________ //

function cleanString($text) {
    $utf8 = array(
        '/[áàâãªä]/u'   =>   'a',
        '/[ÁÀÂÃÄ]/u'    =>   'A',
        '/[ÍÌÎÏ]/u'     =>   'I',
        '/[íìîï]/u'     =>   'i',
        '/[éèêë]/u'     =>   'e',
        '/[ÉÈÊË]/u'     =>   'E',
        '/[óòôõºö]/u'   =>   'o',
        '/[ÓÒÔÕÖ]/u'    =>   'O',
        '/[úùûü]/u'     =>   'u',
        '/[ÚÙÛÜ]/u'     =>   'U',
        '/ç/'           =>   'c',
        '/Ç/'           =>   'C',
        '/ñ/'           =>   'n',
        '/Ñ/'           =>   'N',
        '/–/'           =>   ' ', // UTF-8 hyphen to "normal" hyphen
        '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
        '/[“”«»„]/u'    =>   ' ', // Double quote
        '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
    );
    return preg_replace(array_keys($utf8), array_values($utf8), $text);
}


$i = 0;

if(isset($_POST["letter"])){
    $letters=$_POST["letter"];
    $letters=htmlspecialchars(cleanString($letters)); // some securities and change accented letters with not accented relatives etc..
    $OK = false;
    foreach($_SESSION["Cword"] as $wletter){
        if(strtoupper($letters) == $wletter){
            $_SESSION["display"][$i] = $wletter;
            $OK = true;
        }
        $i++;
    }
    if($OK==false){
        $_SESSION["erreur"]++;
    }
}


if($_SESSION['erreur']==6){
    $_SESSION["display"]=$_SESSION["Cword"];
}

// __________Restart session for NEWGAME __________ //

if(isset($_POST["newgame"])||$_SESSION["erreur"] >6){
    session_destroy();
    header('Location: index.php');
}

?>
<div class="TTC">  
    <div class='newgame'> 
        <form method ="post" action="">   
                <input type="submit" value="ADMIN" name="admin" class="memory"> </input> 
        </form> 
    </div>
</div>
<div class="game">
<div class='newgame'> 
    <span id="lettre">lettre</span>
        <form method ="post">
        <input type="text" name="letter" id ="letter" maxlength="1" >  </input> <!-- if we want to accept only alpha pattern="[A-Za-z]*" -->
    </form>   
</div>
<?php 


// LOGIN "admin" PASSWORD "admin"   __________________________________________________________________________________ //


if(isset($_POST['admin'])){
    echo  '<div class="divvic"><form action="" method="post">
            <input type="text" name="login" placeholder="login" required><br><br>
            <input type="password" name="password" placeholder="password" required><br><br>
            <input type="submit" name="enter" value="enter">
        </form></div>';
}
if( (isset($_POST['login']) and !empty($_POST['login'])) and 
    (isset($_POST['password']) and !empty($_POST['password'])) ){ 
    $login=htmlspecialchars($_POST['login']);
    $password=htmlspecialchars($_POST['password']);
    if($login === 'admin' and $password === 'admin'){
        echo '<a href="admin.php"><h1> go to the admin page here</h1></a>';
    } else {
        echo '<span>please fill in all the fields</span>';
    }
}

// DEFAITE ______________________________________________________

if($_SESSION['erreur']==6){
    echo  '<div class="divvic"><h1>DÉFAITE !</h1><br>';
    echo '<form method ="post" action="">   
            <input type="submit" value="PLAY AGAIN" name="newgame" class="memory"> </input> 
        </form></div>';
}

// VICTOIRE _____________________________________________________

$k=0;
$cword= (sizeof($_SESSION['Cword'])) -1 ;
for($n = 0; $n<=$cword;$n++){
    if($_SESSION['display'][$n] == $_SESSION['Cword'][$n]){
        $k++;
    }
}


if($k == ($cword + 1) and $_SESSION["erreur"]<6){
    echo '<div class="divvic"><h1>Victoire</h1>';
     echo '<form method ="post" action="">   
            <input type="submit" value="PLAY AGAIN" name="newgame" class="memory"> </input>
        </form></div> ';
}

// LETTERS ALREADY TRIED__________________________________________

if(isset($_POST['letter'])){
    $_SESSION['options'][]= $_POST['letter'];
    echo '<h2> already tested </h2>';
    echo '<h3>';
    foreach($_SESSION['options']as $k => $v){
    echo strtoupper($v).' ';
    }
    echo '</h3>';
}

?>
<div class ="container">
    <div class ="socle">
        <div class="base"> </div>
        <div class="base"> </div>
        <div class="base"> </div>
        <div class="base"> </div>
    </div>
    <div class ="poteau">
        <div class="brick"> </div>
        <div class="brick"> </div>
        <div class="brick"> </div>
        <div class="brick"> </div>
        <div class="brick"> </div>
        <div class="brick"> </div>
        <div class="brick"> </div>
        <div class="brick"> </div>
        <div class="brick"> </div>
        <div class="brick"> </div>
    </div>
    <div class ="traverse">
        <div class="brick2"> </div>
        <div class="brick2"> </div>
        <div class="brick2"> </div>
        <div class="brick2"> </div>
        <div class="brick2"> </div>
        <div class="brick2"> </div>
        <div class="brick2"> </div>
        <div class="brick2"> </div>
        <div class="brick2"> </div>
        <div class="brick2"> </div>
    </div>
    <div class ="poteau">
        <div class="brick"> </div>
        <div class="brick"> </div>
        <?php 
        if($_SESSION['erreur']==1 || $_SESSION['erreur']==2 ||  $_SESSION['erreur']==3 ||  $_SESSION['erreur']==4 ||  $_SESSION['erreur']==5 ||  $_SESSION['erreur']==6){
            echo "<div class='tête'> </div>";}
            ?>
        <div class="tronc"> 
            <div class="one">
            <?php 
        if($_SESSION['erreur']==2 ||  $_SESSION['erreur']==3 ||  $_SESSION['erreur']==4 ||  $_SESSION['erreur']==5 ||  $_SESSION['erreur']==6){
            echo "<div class='arm1'> </div>";}
            ?>            </div> 
            <div class="two">
            <?php 
        if($_SESSION['erreur']==3 ||  $_SESSION['erreur']==4 ||  $_SESSION['erreur']==5 ||  $_SESSION['erreur']==6){
            echo "<div class='thorax'> </div>";}
            ?>            </div> 
            <div class="three">
            <?php 
        if($_SESSION['erreur']==4 ||  $_SESSION['erreur']==5 ||  $_SESSION['erreur']==6){
            echo "<div class='arm2'> </div>";}
            ?>            </div> 
        </div>
        <div class="legs">         
        <?php 
        if($_SESSION['erreur']==5||  $_SESSION['erreur']==6){
            echo "<div class='leg1'> </div>";}
        if($_SESSION['erreur']==6){
            echo "<div class='leg2'> </div>";}
            ?>        
        </div>
    </div>
</div>

<?php
// $_SESSION["words"]=["CRABE","CRAYON","ARAIGNEE","TOURNEVIS","OLIVE"];
// $w = str_split($_SESSION["words"][array_rand($_SESSION["words"],1)]);


echo "<div class='text'> ";


/*
foreach($_SESSION["Cword"] as $word){
    $_SESSION["display"][]="";
    $val = $_SESSION["display"][$i];
    echo "<div class='divletter'>". $val."</div>";
    $i++;
}
*/

for($n = 0; $n<=isset($_SESSION["Cword"][$n]);$n++){
$_SESSION["display"][]="";
$val = $_SESSION["display"][$n];
    if($_SESSION["display"][$n] == $val){
        echo '<div class="divletter">'.$_SESSION["display"][$n].'</div>';
    } else {
        echo '<div class="divletter"></div>';
    }
}

echo "</div>"; 



//var_dump($_SESSION['Cword']);
//var_dump($_SESSION['display']);
//var_dump($m[$f]);

/*
echo $_SESSION["display"][0];
echo $_SESSION["display"][1];
echo $_SESSION["display"][2];
echo $_SESSION["display"][3];
echo $_SESSION["display"][4];
echo $_SESSION["display"][5];
*/
?>

</div>

<div class="memory">  <div class='newgame'> 
     <form method ="post" action="">   
        <input type='submit' value='NEW GAME' name='newgame'> </input> 
    </form>   

</div> </div>
</main>
<footer>

</footer>
</body>
</html>