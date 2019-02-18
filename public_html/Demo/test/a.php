<?php
class Foo {
  public $property = "Not constructed";

  public function __construct() {
    $this->property = "Constructed";
  }

  public function talk() {
    echo "I was {$this->property}.\n";
  }

  public static function fronkonstine() {
    $rc = new ReflectionClass(__CLASS__);
    return $rc->newInstanceWithoutConstructor();
  }
}

// Normal instantiation.
$x = new Foo();
var_dump($x);
$x->talk();

// Paranormal instantiation.
$y = Foo::fronkonstine();
var_dump($y);
$y->talk();
echo "But now...\n";
$y->__construct();
$y->talk();
?>

