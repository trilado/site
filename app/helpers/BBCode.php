<?php
class BBCode
{
	public static function parse($text)
	{
		$bbcode = array(
			'/\[b\](.*?)\[\/b\]/is',
			'/\[i\](.*?)\[\/i\]/is',
			'/\[h1\](.*?)\[\/h1\]/is',
			'/\[h2\](.*?)\[\/h2\]/is',
			'/\[h3\](.*?)\[\/h3\]/is',
			'/\[url=(.*?)\](.*?)\[\/url\]/is',
			'/\[url\](.*?)\[\/url\]/is',
			'/\[img\](.*?)\[\/img\]/is',
			'/\[code\](.*?)\[\/code\]/is',
			'/\[quote\](.*?)\[\/quote\]/is',
			'/\[quote=(.*?)\](.*?)\[\/quote\]/is',
			'/\[hr\]/is',
			'/\[list\](.*?)\[\/list\]/is',
			'/\[list=(.*?)\](.*?)\[\/list\]/is',
			'/\[\*\](.*?)\n/is',
		);
		$html = array(
			'<b>$1</b>',
			'<i>$1</i>',
			'<h1>$1</h1>',
			'<h2>$1</h2>',
			'<h3>$1</h3>',
			'<a href="$1" target="_blank">$2</a>',
			'<a href="$1" target="_blank">$1</a>',
			'<img src="$1" alt="" />',
			'<pre class="pre-scrollable">$1</pre>',
			'<blockquote><p>$1</p></blockquote>',
			'<blockquote><p>$2</p><small>$1</small></blockquote>',
			'<hr />',
			'<ul>$1</ul>',
			'<ol type="$1">$2</ol>',
			'<li>$1</li>',
		);
		
		$text = nl2br($text);
		$text = preg_replace($bbcode, $html, $text);
		$text = preg_replace('#<ul>(.*?)</ul>#ise', "'<ul>'. self::br2nl('$1') .'</ul>'", $text);
		$text = preg_replace('#<ol type="(.*?)">(.*?)</ol>#ise', "'<ol type=\"$1\">'. self::br2nl('$2') .'</ol>'", $text);
		$text = preg_replace('#<pre class="pre-scrollable">(.*?)</pre>#ise', "'<pre class=\"pre-scrollable prettyprint linenums\">'. self::br2nl('$1') .'</pre>'", $text);
		return $text;
	}
	private static function br2nl($text)
	{
		return str_replace(array('<br />', '<br/>', '<br>'), '', $text);
	}
}