<div class="row">
	<div class="span3">
		<ul class="nav nav-list nav-stacked">
			<?php foreach ($menu as $m): ?>
				<?php if($m == $class): ?>
				<li class="active"><a href="~/api/class/<?= $m ?>"><?= $m ?></a></li>
				<?php else: ?>
				<li><a href="~/api/class/<?= $m ?>"><?= $m ?></a></li>
				<?php endif ?>
			<?php endforeach ?>
		</ul>
	</div>
	<div class="span9 api">
		<h2>Classe: <?= $model['class']['name'] ?> <?= $model['class']['abstract'] ? '<span class="label label-warning">abstract</span>' : '' ?></h2>
		
		<hr />
		
		<h3>Arquivo</h3>
		<p><a href="~/api/file/<?= $model['class']['name'] ?>"><?= $model['class']['file'] ?></a></p>
		<h3>Descrição</h3>
		<p><?= $model['class']['text'] ?></p>
		<?php if (count($model['class']['extends'])): ?>
			<h3>Herança</h3>
			<?php for($i = count($model['class']['extends']) -1; $i >= 0; $i--): ?>
				<ul><li><a href="~/api/class/<?= $model['class']['extends'][$i] ?>"><?= $model['class']['extends'][$i] ?></a></li>
			<?php endfor ?>
			<?= implode('', array_fill(0, count($model['class']['extends']), '</ul>')) ?>
		<?php endif ?>

			<?php if (isset($model['properties'])): ?>
				<hr />
				<h2 class="hr">Propriedades</h2>
				<?php foreach ($model['properties'] as $p): ?>
					<h3 class="<?= $p['visibility'] . ' ' . $p['static'] ?>"><?= $p['name'] ?> <?= isset($p['doc']['var']) ? '<span class="label">' . $p['doc']['var'] . '</span>' : '' ?></h3>
					<p><?= $p['doc']['text'] ?></p>
				<?php endforeach ?>
			<?php endif ?>

			<?php if (count($model['methods'])): ?>
				<hr /> 
				<h2 class="hr">Lista dos Métodos</h2>
				<ul class="methods">
				<?php foreach ($model['methods'] as $m): ?>
					<?php $params = array(); ?>
					<?php if (isset($m['doc']['params'])): ?>
						<?php foreach ($m['doc']['params'] as $p): ?>
							<?php $params[] = '<span class="label">' . (isset($p['type']) ? $p['type'] : '') . '</span> ' . (isset($p['name']) ? $p['name'] : '') . ($p['default'] ? ' = ' . $p['default'] : '') ?>
						<?php endforeach ?>
					<?php endif ?>
					<li class="<?= $m['visibility'] . ' ' . $m['static'] ?>"><a href="#method:<?= $m['name'] ?>"><?= $m['name'] . '(' . implode(', ', $params) ?>)</a></li>
				<?php endforeach ?>
				</ul>
				<?php foreach ($model['methods'] as $m): ?>
					<hr />
					<a name="method:<?= $m['name'] ?>"></a>
					<h3 class="<?= $m['visibility'] . ' ' . $m['static'] ?>"><?= $m['name'] ?> <?= $m['final'] ? '<span class="label label-inverse">final</span>' : '' ?> <?= $m['abstratic'] ? '<span class="label label-warning">abstract</span>' : '' ?> <small>(na linha <a href="~/api/file/<?= $model['class']['name'] ?>#l<?= $m['line'] ?>"><?= $m['line'] ?></a>)</small></h3>
					<p><?= $m['doc']['text'] ?></p>
					<?php if (count($m['doc']['params'])): ?>
						<h4>Parâmetros</h4>
						<ul>
							<?php foreach ($m['doc']['params'] as $p): ?>
								<li>
									<div><span class="label"><?= $p['type'] ?></span> <b><?= $p['name'] ?></b> <?= $p['optional'] ? '<span class="label label-info">'. $p['optional'] .'</span>' : '' ?><?= ($p['default'] ? ' <span class="label">' . $p['default'] . '</span>' : '') ?></div>
									<p><?= $p['text'] ?></p>
								</li>
							<?php endforeach ?>
						</ul>
					<?php endif ?>
					<?php if (count($m['doc']['return'])): ?>
						<h4>Retorno</h4>
						<p><span class="label"><?= $m['doc']['return']['type'] ?></span> <?= $m['doc']['return']['text'] ?></p>
					<?php endif ?>
				<?php endforeach ?>
		<?php endif ?>
	</div>
</div>