<?php

class Markdown
{
	public function tags($text)
	{
		$mark = array(
			'/#(.*?)#/is',
			'/##(.*?)##/is',
			'/###(.*?)###/is',
			'/####(.*?)####/is',
			'/#####(.*?)#####/is',
			'/\*\*(.*?)\*\*/is',
			'/\*(.*?)\*/is',
		);
		$html = array(
			'<h1>$1</h1>',
			'<h2>$1</h2>',
			'<h3>$1</h3>',
			'<h4>$1</h4>',
			'<h5>$1</h5>',
			'<b>$1</b>',
			'<i>$1</i>',
		);
		$text = preg_replace($mark, $html, $text);
		return $text;
	}
}