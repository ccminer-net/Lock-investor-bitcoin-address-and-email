<?php
global $current_user;
get_currentuserinfo();
$current_id = get_current_user_id() ;
$servername = "[YOUR SERVER IP ADDRESS]";
$username = "[YOUR DATABASE USERNAME]";
$password = "[YOUR DATABASE PASSWORD]";
$dbname = "[YOUR DATABASE NAME]";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT id,email,wallet FROM lock_email";
$result = $conn->query($sql);
$arr=array();
$sql = "SELECT id FROM lock_email";
$result = $conn->query($sql);
$arr=array();
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$arr[]= $row["id"] ;
    }
if (in_array($current_id, $arr))
{
header("location: https://ccminer.net/trade/"); #IF THE USER INVESTOR ALREADY LOCKED HIS/HER EMAIL AND BITCOIN ADDRESS HE/SHE WILL BE REDIRECTED TO THE TRADE PAGE
}
}
echo ('
<center><h3>FOR YOUR SAFETY, LOCK YOUR DATA</h3></center>
<form name="SellCCM" action="https://ccminer.net/lock/" method="POST">
<center>EMAIL:<br> <input style="height:35px; width:253px" name="EMAIL" type="text" /></center>
<center>WALLET:<br> <input style="height:35px; width:353px" name="WALLET" type="text" /></center>
<center><input type="submit" name="submittedd" value="SUBMIT" /></center>
</form>
<center><h3>USE A VALID AND SAFE EMAIL!<br>WE WILL USE THIS EMAIL FOR SECURITY COMUNICATIONS<br>IN CASE YOU WILL DECIDE TO CHANGE YOUR PAYOUT ADDRESS THE ONLY WAY WILL BE TROUGH THE SAFE EMAIL!!</center></h3>
');
if (isset ($_POST['submittedd'])){
if (empty($_POST['EMAIL'])){
echo ('THE EMAIL CAN NOT BE EMPTY'); 
}else{
global $current_user;
get_currentuserinfo(); 
$id = get_current_user_id() ;
$email=$_POST['EMAIL'];
$wallet=$_POST['WALLET'];
$sql ="INSERT INTO lock_email (id, email, wallet) VALUES ('$id','$email','$wallet')"; #WE NAMED THE SQL TABLE "lock_email"
if ($conn->query($sql) === TRUE) {
    header("location: https://ccminer.net/trade/");# ONCE DONE THE USER/INVESTOR IS REDIRECTED TO THE TRADE PAGE
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
}
}
?>
