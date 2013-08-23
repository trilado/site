<?php

class Api
{

	public function getDoc($class)
	{		
		$class = new ReflectionClass($class);

		$result = array();

		$result['class'] = $this->docClass($class->getDocComment());
		$result['class']['name'] = $class->getName();
		$result['class']['file'] = str_replace(root, '', str_replace('\\', '/', $class->getFileName()));
		$result['class']['abstract'] = $class->isAbstract();

		$parent = $class;
		$parents = array();

		while ($parent = $parent->getParentClass())
			$parents[] = $parent->getName();
		$result['class']['extends'] = $parents;

		$result['properties'] = array();
		foreach ($class->getProperties() as $property)
		{
			$result['properties'][$property->getName()]['name'] = $property->getName();
			$result['properties'][$property->getName()]['visibility'] = $this->getVisibility($property);
			$result['properties'][$property->getName()]['static'] = $property->isStatic() ? 'static' : '';
			$result['properties'][$property->getName()]['doc'] = $this->docProperty($property->getDocComment());
		}
		if (count($result['properties']))
			sort($result['properties']);

		$result['methods'] = array();
		foreach ($class->getMethods() as $method)
		{
			$result['methods'][$method->getName()]['name'] = $method->getName();
			$result['methods'][$method->getName()]['visibility'] = $this->getVisibility($method);
			$result['methods'][$method->getName()]['abstratic'] = $method->isAbstract();
			$result['methods'][$method->getName()]['final'] = $method->isFinal();
			$result['methods'][$method->getName()]['static'] = $method->isStatic() ? 'static' : '';
			$result['methods'][$method->getName()]['line'] = $method->getStartLine();
			
			$result['methods'][$method->getName()]['doc'] = $this->docMethod($method->getDocComment());

			foreach ($method->getParameters() as $param)
			{
				if (!isset($result['methods'][$method->getName()]['doc']['params'][$param->getName()]))
				{
					$p = array();

					$p['type'] = '';
					$p['name'] = '';
					$p['text'] = '';
					$p['default'] = '';
					$p['optional'] = '';
					$result['methods'][$method->getName()]['doc']['params'][$param->getName()] = $p;
				}

				$result['methods'][$method->getName()]['doc']['params'][$param->getName()]['default'] = $param->isOptional() ? $this->formatQuote($result['methods'][$method->getName()]['doc']['params'][$param->getName()]['type'], ($param->isDefaultValueAvailable() ? $param->getDefaultValue() : '')) : '';
				$result['methods'][$method->getName()]['doc']['params'][$param->getName()]['optional'] = $param->isOptional() ? 'optional' : 'required';
			}
		}
		if (count($result['methods']))
			sort($result['methods']);
		return $result;
	}

	public function docClass($comment)
	{
		$lines = explode("\n", str_replace(array("\r\n", "\r"), "\n", $comment));
		$lines = array_slice($lines, 1, -1);

		$result = array();
		$result['text'] = '';

		foreach ($lines as $line)
		{
			$line = preg_replace('/^\s*\* ?/m', '', $line);
			$line = preg_replace('/([\t]+)/', "\t", $line);

			if (preg_match('/^@([a-zA-Z]+)\t(.*)$/', $line, $match))
			{
				$result[$match[1]]['text'] = $match[2];
			}
			else
			{
				if ($line)
					$result['text'] .= $line;
			}
		}
		return $result;
	}

	public function docMethod($comment)
	{
		$lines = explode("\n", str_replace(array("\r\n", "\r"), "\n", $comment));
		$lines = array_slice($lines, 1, -1);

		$result = array();
		$result['text'] = '';
		$result['params'] = array();
		$result['return'] = array();

		foreach ($lines as $line)
		{
			$line = preg_replace('/^\s*\* ?/m', '', $line);
			$line = preg_replace('/([\t]+)/', "\t", $line);

			if (preg_match('/^@([a-zA-Z]+)\t([a-zA-Z0-9_]+)(?:\t([^\t]*)(?:\t(.*))?)?$/', $line, $match))
			{
				if ($match[1] == 'param')
				{
					$name = str_replace('$', '', $match[3]);
					$result['params'][$name]['type'] = $match[2];
					$result['params'][$name]['name'] = $match[3];
					$result['params'][$name]['text'] = $match[4];
					$result['params'][$name]['default'] = '';
					$result['params'][$name]['optional'] = '';
				}
				elseif ($match[1] == 'return')
				{
					$result['return']['type'] = isset($match[2]) ? $match[2] : '';
					$result['return']['text'] = isset($match[3]) ? $match[3] : '';
				}
			}
			else
			{
				if ($line)
					$result['text'] .= $line;
			}
		}
		return $result;
	}

	public function docProperty($comment)
	{
		$lines = explode("\n", str_replace(array("\r\n", "\r"), "\n", $comment));
		$lines = array_slice($lines, 1, -1);

		$result = array();
		$result['text'] = '';

		foreach ($lines as $line)
		{
			$line = preg_replace('/^\s*\* ?/m', '', $line);
			$line = preg_replace('/([\t]+)/', "\t", $line);

			if (preg_match('/^@([a-zA-Z]+)\t(.*)$/', $line, $match))
			{
				$result[$match[1]] = $match[2];
			}
			else
			{
				if ($line)
					$result['text'] .= $line;
			}
		}
		return $result;
	}

	private function getVisibility($reflection)
	{
		if ($reflection->isPublic())
			return 'public';
		if ($reflection->isPrivate())
			return 'private';
		if ($reflection->isProtected())
			return 'protected';
	}

	private function formatQuote($type, $value)
	{
		if (is_string($value))
			$value = "'$value'";
		elseif (is_bool($value))
			$value = $value ? 'true' : 'false';
		elseif (is_null($value))
			$value = 'null';
		elseif (is_array($value))
			$value = 'array()';
		return $value;
	}

	public function render($doc)
	{
		echo '<h1>' . $doc['class']['name'] . '</h1>';
		echo '<b>Descrição</b>';
		echo '<p>' . $doc['class']['text'] . '</p>';

		echo '<h2>Propriedades</h2>';
		foreach ($doc['properties'] as $p)
		{
			echo '<h3 class="' . $p['visibility'] . ' ' . $p['static'] . '">' . $p['name'] . ' <span class="type">' . $p['doc']['var'] . '</span></h3>';
			echo '<p>' . $p['doc']['text'] . '</p>';
		}

		echo '<h2>Lista dos Métodos</h2>';
		foreach ($doc['methods'] as $m)
		{
			$params = array();
			foreach ($m['doc']['params'] as $p)
				$params[] = $p['type'] . ' ' . $p['name'] . ($p['default'] ? ' = ' . $p['default'] : '');
			echo '<h3 class="' . $m['visibility'] . ' ' . $m['static'] . '">' . $m['doc']['return']['type'] . ' ' . $m['name'] . '(' . implode(', ', $params) . ')</h3>';
		}
		foreach ($doc['methods'] as $m)
		{
			echo '<h2 class="' . $m['visibility'] . ' ' . $m['static'] . '">' . $m['name'] . '</h2>';
			echo '<p>' . $m['doc']['text'] . '</p>';
			if (count($m['doc']['params']))
			{
				echo '<h3>Parâmetros</h3>';
				echo '<ul>';
				foreach ($m['doc']['params'] as $p)
				{
					echo '<li>';
					echo '<div><span class="type">' . $p['type'] . '</span> ' . $p['name'] . ' <span class="optional">' . $p['optional'] . '</span>' . ($p['default'] ? ' <span class="optional">' . $p['default'] . '</span>' : '') . '</div>';
					echo '<p>' . $p['text'] . '</p>';
					echo '</li>';
				}
				echo '</ul>';
				if ($m['doc']['return'])
				{
					echo '<h3>Retorno</h3>';
					echo '<p><span class="type">' . $m['doc']['return']['type'] . '</span> ' . $m['doc']['return']['text'] . '</p>';
				}
			}
		}
	}

	public function getMenu()
	{
		$directories = func_get_args();
		if (!count($directories))
			$directories = array('core/libs/', 'core/libs/exceptions', 'core/libs/datasource', 'core/libs/cachesource');
		$menu = array();
		foreach ($directories as $d)
		{
			$files = scandir(root . $d);
			foreach ($files as $file)
			{
				if (preg_match('/.php$/', $file))
					$menu[] = str_replace('.php', '', $file);
			}
		}
		sort($menu);
		return $menu;
	}

	public function getSource($class)
	{
		$class = new ReflectionClass($class);
		$code = file_get_contents($class->getFileName());
		//return $this->source_code($code);
		return htmlspecialchars($code);
	}

	private function source_code($string)
	{
		$code = highlight_string($string, true);
		$code = substr($code, 36, -15);
		
		$lines = explode('<br />', $code);
		$comments = true;
		$list = array();
		$i = 0;
		foreach ($lines as $line)
		{
			$line = str_replace('&nbsp;&nbsp;&nbsp;&nbsp;', "\t", $line);
			
			$list[$i] = '';
			// fix multi-line comment bug
			if ((strstr($line, '<span style="color: #FF8000">/*') !== false) && (strstr($line, '*/') !== false))
			{ // single line comment using /* */
				$comments = false;
				$startcolor = 'orange';
			}
			elseif (strstr($line, '<span style="color: #FF8000">/*') !== false)
			{ // multi line comment using /* */
				$startcolor = 'orange';
				$comments = true;
			}
			else
			{ // no comment marks found
				$startcolor = 'green';
				if ($comments)
				{ // continuation of multi line comment
					if (strstr($line, '*/') !== false)
					{
						$comments = false;
						$startcolor = 'orange';
					}
					else
					{
						$comments = true;
					}
				}
				else
				{ // normal line  
					$comments = false;
					$startcolor = "green";
				}
			}
			// end fix multi-line comment bug

			if ($comments)
				$list[$i] .= '<span width="100%" nowrap style="color: orange;">' . $line . '</span>';
			else
				$list[$i] .= '<span width="100%" nowrap style="color: ' . $startcolor . ';">' . $line . '</span>';
			$i++;
		}
		return $list;
	}
}

//Informação da classe X
//	Nome, Arquivo, Descrição
//Propriedades
//	Visibilidade, Nome (link), Tipo, Descrição
//Lista dos métodos
//	Visiblidade, Nome (link)
//Métodos
//	Visibilidade, Nome, Descrição, Parâmetros (tipo, nome, opcional, default), Retorno