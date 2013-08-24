<?php
class GuideController extends Controller
{
	public function render($version, $file = 'index', $sub = null)
	{
		if($sub)
			$file .= '/' . $sub;
		$file = dirname(ROOT) . '/guide/' . $version . '/' . rtrim($file, '/') . '.md';
		$menu = dirname(ROOT) . '/guide/' . $version . '/menu.md';
		
		if (file_exists($file)) {
			$parser = new MarkdownExtra_Parser();
			$md = $parser->transform(file_get_contents($file));
			$menu = $parser->transform(file_get_contents($menu));

			$menu = $this->resolveUrl($menu, $version);
			$md = $this->resolveUrl($md, $version);
			
			$this->_set('menu', '<ul class="nav nav-list nav-stacked">' . substr($menu, 4));
			$this->_set('content', $md);
			return $this->_view();
		}
		return $this->_snippet('notfound', 'Página não encontrada');
	}
	
	private function resolveUrl($html, $version)
	{
		return str_replace(array('"~/', "'~/"), array('"'. ROOT_VIRTUAL . $version . '/', "'". ROOT_VIRTUAL . $version . '/'), $html);
	}
}