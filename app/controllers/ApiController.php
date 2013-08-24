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
	
	public function write($version)
	{
		$doc = new Api();
		$files = $this->listFiles();
		
		$letters = array();
		foreach($files as $c)
			$letters[$c[0]][] = $c;
		
		$content = Import::view(array('version' => $version, 'letters' => $letters), 'api', 'index');
		$content = $this->resolveUrl($content, $version);
		$path = dirname(ROOT) . '/api/' . $version . '/index.php';
		file_put_contents($path, $content);
		
		foreach ($files as $file) 
		{
			$class = $file;
			$model = $doc->getDoc($class);
			$content = Import::view(array('menu' => $files, 'model' => $model, 'version' => $version, 'class' => $class), 'api', 'render');
			$content = $this->resolveUrl($content, $version);
			$path = dirname(ROOT) . '/api/' . $version . '/class/' . $class . '.php';
			file_put_contents($path, $content);
			
			$model = $doc->getSource($class);
			$content = Import::view(array('menu' => $files, 'model' => $model, 'version' => $version, 'class' => $class), 'api', 'file');
			$content = $this->resolveUrl($content, $version);
			$path = dirname(ROOT) . '/api/' . $version . '/file/' . $class . '.php';
			file_put_contents($path, $content);
		}
		return $this->_print('done');
	}
	
	public function test($version, $class)
	{
		$doc = new Api();
		$files = $this->listFiles();
		
		$model = $doc->getDoc($class);
		
		$this->_set('menu', $files);
		return $this->_view('render', $model);
	}
	
	private function listFiles()
	{
		$key = '';
		if(Cache::enabled())
		{
			$cache = Cache::factory();
			if($cache->has($key))
				return $cache->read($key);
		}
		
		$this->ignoreList = array('\.(jpg|png|css|js|git)$', 'vazio$', '/vendors/');
		
		$files = array();
		$directories = array(ROOT . 'core/libs');
		for($i = 0; $i < count($directories); $i++)
		{
			if ($handle = opendir($directories[$i]))
			{
				while (false !== ($file = readdir($handle)))
				{
					$path = $directories[$i] . '/' . $file;
					if ($file != '.' && $file != '..' && !$this->isIgnored($path))
					{
						if(is_dir($path))
							$directories[] = $path;
						else
							$files[] = str_replace ('.php', '', $file);
					}
				}
			}
		}
		
		if(Cache::enabled())
			$cache->write($key, $files, YEAR);
		
		return $files;
	}
	
	private $ignoreList = array();
	
	private function isIgnored($file)
	{
		$ignored = FALSE;
		$count = count($this->ignoreList);

		for($i = 0; $i < $count && !$ignored; $i++)
		{
			if(preg_match('#' . $this->ignoreList[$i] . '#', $file))
				$ignored = TRUE;
		}
		return $ignored;
	}
	
	private function resolveUrl($html, $version)
	{
		return str_replace(array('"~/', "'~/"), array('"'. ROOT_VIRTUAL . $version . '/', "'". ROOT_VIRTUAL . $version . '/'), $html);
	}
}