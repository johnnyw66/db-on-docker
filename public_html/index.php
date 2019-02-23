<h1>Hello Cloudreach! Johnny!!</h1>
<h4>Attempting MySQL connection from php...</h4>
<?php
   class Test {
	private $var1 ;
	private $var2 ;
	private $var3 ;
	public function __construct() {
	
		$this->var1='Hello' ;
		$this->var2='World!' ;
		$this->var3='Wow!!' ;
				
	}
	
	public function getVar1() { return $this->var1 ; }
	public function getVar2() { return $this->var2 ; }
	public function getVar3() { return $this->var3 ; }

	public function __toString() {
		return "var1 : ".$this->var1." var2: ".$this->var2." var 3: ".$this->var3 ;
	}
   }

   $test = new Test() ;
		

   $redis = new Redis(); 
   $client = $redis->connect('redis', 6379); 
   $redis->incr("counter");

   if ($redis->exists('ddklkjflkjf')) {
		echo 'IS SET<BR>' ;
   } else {
		echo 'IS NOT!!! SET<BR>' ;
	
   }
   //if (null !== ($v = $redis->get("foo:1"))) { echo ">>>>>>>>>>>>>>><<<<<<<<<<<<" ;}
   //echo " FOOFOO = ".(isset($redis->get("foofoo")) ? 'true' : 'false')."<BR>" ;

   $redis->set("foo:1", "bar");
   $redis->set("zoo:1", "bar2");
   $redis->set("zoo:2", "bar3");
   $redis->set("test", serialize($test)) ;

   $arList = $redis->keys("*"); 
   echo "Stored keys in redis::"; 
   print_r($arList); 
   echo " COUNT = ".$redis->get("counter")."<BR>" ;
   $o = unserialize($redis->get('test')) ;
   echo " TEST =".$o."<BR>" ;
	

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
