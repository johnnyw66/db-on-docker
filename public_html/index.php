<h1>Hello Cloudreach! Johnny!!</h1>
<h4>Attempting MySQL connection from php...</h4>
<?php
   class Test {
	private $var1 ;
	private $var2 ;
	private $var3 ;
	public function __construct() {
	
		$var1='Hello' ;
		$var2='World!' ;
		$var3='VAR 3!!' ;
				
	}
	
	public function getVar1() { return $this->var1 ; }
	public function getVar2() { return $this->var2 ; }
	public function getVar3() { return $this->var3 ; }

	public function __toString() {
		return "{$this->var1}" ;
	}
   }

   $test = new Test() ;
		

   $redis = new Redis(); 
   $client = $redis->connect('redis', 6379); 
   $redis->incr("counter");

   $redis->set("foo:1", "bar");
   $redis->set("zoo:1", "bar2");
   $redis->set("zoo:2", "bar3");
   $redis->set("test", $test) ;


   $arList = $redis->keys("*"); 
   echo "Stored keys in redis::"; 
   print_r($arList); 
   echo " COUNT = ".$redis->get("counter")."<BR>" ;

   var_dump($redis->get('test')) ;

   //var_dump($test) ;

// Parameters passed using a named array:

//$responses = $redis->transaction()->set('foo', 'bar')->get('foo')->execute();



$host = 'mysql';
$user = 'socialuser';
$pass = 'secret';
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to MySQL successfully!";
}

?>
