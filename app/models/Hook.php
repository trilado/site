<?php
class Hook
{
	public function response($content)
	{
		return $content;
	}
	
	public function renderFlash($content)
	{
		return preg_replace('/<div class="(.+)">/', '<div class="alert alert-$1"><button type="button" class="close" data-dismiss="alert">×</button>', $content);
	}
}