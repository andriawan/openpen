<pre>
<?php 

require_once 'AndDatabase.php';
require_once 'AndErrReport.php';
require_once 'AndSecurityGuard.php';
require_once 'AndDevDebug.php';
require_once 'AndGenerator.php';

AndErrReport::enableErrorMessage();

$x = new AndDatabase();
$x->connect();

$v = new AndReport();

AndDevDebug::printNice($x);
AndDevDebug::printNice($v);

$firstname	 = $x->rowObj("select name from student where student_id = :id", array('id' => 2001) );

$result = $x->query("select * from student");

$sx = $result[0];

$split = new DateTime();

AndDevDebug::printNice($firstname);

$x->closeConnection();

AndDevDebug::printNice($split);

echo AndGenerator::generateString();




//creates a unique id with the 'about' prefix
$a = uniqid('about');
echo $a;
echo "<br>";

//creates a longer unique id with the 'about' prefix
$b = uniqid ('about' , true);
echo $b;
echo "<br>";

//creates a unique ID with a random number as a prefix - more secure than a static prefix 
$c = uniqid (rand(), true);
echo $c;
echo "<br>";

//this md5 encrypts the username from above, so its ready to be stored in your database
$md5c = md5($c);
echo $md5c;
echo "<br>";

//You can also use $stamp = strtotime ("now"); But I think date("Ymdhis") is easier to understand.
$stamp = date("Ymdhis");
$ip = $_SERVER['SERVER_NAME'];
$orderid = "$stamp-$ip";
$orderid = str_replace(".", "", "$orderid");
echo($orderid);
echo "<br>";

AndDevDebug::printNice(AndGenerator::generateServerInfo());
AndDevDebug::printNice(AndPath::setPath("hello","file.php"));


//set the random id length 
$random_id_length = 10; 

//generate a random id encrypt it and store it in $rnd_id 
$rnd_id = crypt(uniqid(rand(),1)); 

//to remove any slashes that might have come 
$rnd_id = strip_tags(stripslashes($rnd_id)); 

//Removing any . or / and reversing the string 
$rnd_id = str_replace(".","",$rnd_id); 
$rnd_id = strrev(str_replace("/","",$rnd_id)); 

//finally I take the first 10 characters from the $rnd_id 
$rnd_id = substr($rnd_id,0,$random_id_length); 

echo "Random Id: $rnd_id" ;
echo "<br>";

// Generate Guid 
function NewGuid() { 
    $s = strtoupper(md5(uniqid(rand(),true))); 
    $guidText = 
        substr($s,0,8) . '-' . 
        substr($s,8,4) . '-' . 
        substr($s,12,4). '-' . 
        substr($s,16,4). '-' . 
        substr($s,20); 
    return $guidText;
}
// End Generate Guid 

$Guid = NewGuid();
echo $Guid;
echo "<br>";


?>

</pre>