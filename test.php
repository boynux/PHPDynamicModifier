<?php
include "a.php";
include "modifier.php";

$a = new A;
$mod = new Modifier ($a);

$a = $mod->attach (function () {
	echo "prefix:";
});

assert ($a instanceof A);
$a->test ();
