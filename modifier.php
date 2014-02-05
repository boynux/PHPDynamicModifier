<?php

class Modifier
{
	public function __construct ($class)
	{
		$this->class = $class;
	}

	public function attach (\Closure $func)
	{
		$className = $this->getClassName ();
		$name = $className . '_' . md5 ($className);

		include $this->createClass ();
		return new $name ($this->class, $func);
	}

	private function getClassName ()
	{
		return get_class ($this->class);
	}

	private function getMethods ()
	{
		return array ('test', 'test2');
	}

	private function createClass ()
	{
		$className = $this->getClassName ();
		$name = $className . '_' . md5 ($className);

		$klass = <<<EOF
<?php
class $name extends $className 
{
	public function __construct (\$class, \$func) 
	{
		\$this->class = \$class;
		\$this->func = \$func;
	}

	public function test ()
	{
		call_user_func (\$this->func);
		return \$this->class->test ();
	}

	public function test2 ()
	{
		\$this->func ();
		return \$this->class->test2 ();
	}

	public function __call (\$method, \$args)
	{
		# return call_user_func_array (array (\$this, \$method), \$args);
	}
}
EOF;
		file_put_contents ("/tmp/$name.php", $klass);
		return "/tmp/$name.php";
	}
}
