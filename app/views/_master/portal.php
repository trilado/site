<!DOCTYPE html>
<html lang="<?= Config::get('default_lang') ?>">
	<head>
		<meta charset="<?= Config::get('charset') ?>">
		<title>Trilado Framework</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Trilado Framework">
		<meta name="author" content="Vaneves">
		<!-- styles -->
		<link href="~/css/bootstrap.min.css" rel="stylesheet">
		<link href="~/css/portal.css" rel="stylesheet">
		<link href="~/css/api.css" rel="stylesheet">
		<link href="~/css/prettify.css" rel="stylesheet">
	</head>
	<body onload="prettyPrint()">
		<header class="top">
			<div class="container">
				<div class="logo">
					<a href="~/" title=""><img src="~/img/logo.png" alt="Logomarca" /></a>
				</div>
			</div>
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<?php $c = str_replace('controller', '', strtolower(controller)) ?>
							<li class="<?= $c == 'home' && action == 'index' ? 'active' : '' ?>"><a href="~/">Início</a></li>
							<li><a href="https://github.com/trilado/trilado/releases">Download</a></li>
							<li class="dropdown <?= $c == 'doc' || $c == 'api' ? 'active' : '' ?>">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									Documentação
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li class="nav-header">API</li>
									<li><a href="~/2.0/api/">2.0</a></li>
									<li><a href="~/2.1/api/">2.1</a></li>
									<li class="divider"></li>
									<li class="nav-header">Guia</li>
									<li><a href="~/2.0/guide/">2.0</a></li>
									<li><a href="~/2.1/guide/">2.1</a></li>
								</ul>
							</li>
							<li><a href="https://github.com/trilado/trilado/issues">Issues</a></li>
							<li class="dropdown <?= $c == 'home' && action == 'about' ? 'active' : '' ?>">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									Sobre
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li><a href="~/about">O Trilado</a></li>
									<li><a href="~/features">Características</a></li>
									<li><a href="~/team">Equipe</a></li>
									<li><a href="~/license">Licença</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</header>
		<div class="container">
			<div class="">
				<?= flash ?>
				<?= content ?>
			</div>
		</div>
		<div class="container">
			<hr />
			<p>Copyright © 2009 - <?= date('Y') ?>. Trilado está liberado sob a <a href="~/license">Licença New BSD</a>.</p>
		</div>
		<script src="~/js/jquery-1.8.1.min.js"></script>
		<script src="~/js/bootstrap.min.js"></script>
		<script src="~/js/prettify.js"></script>
		<script src="~/js/lang-php.js"></script>
		<script src="~/js/all.js"></script>
		<script type="text/javascript" src="http://sawpf.com/1.0.js"></script>
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-35728415-1']);
			_gaq.push(['_setDomainName', 'triladophp.org']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	</body>
</html>