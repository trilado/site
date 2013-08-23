<?php
class ApiController extends Controller
{
	public function __construct() {}
	
	public function index($version)
	{
		$file = dirname(ROOT) . '/api/' . $version . '/index.php';
		if (file_exists($file)) 
		{
			$content = file_get_contents($file);
			return $this->_content($content);
		}
		return $this->_snippet('notfound', 'Página não encontrada');
	}
	
	public function render($version, $class, $type)
	{
		$file = dirname(ROOT) . '/api/' . $version . '/' . $type . '/' . $class . '.php';
		if (file_exists($file)) 
		{
			$content = file_get_contents($file);
			return $this->_content($content);
		}
		return $this->_snippet('notfound', 'Página não encontrada');
	}
}