<h2>API</h2>
<hr />
<ul class="nav nav-pills letters">
	<?php for ($i = 'A'; $i != 'AA'; $i++): ?>
		<?php if (array_key_exists($i, $letters)): ?>
			<li><a href="#letter-<?= $i ?>"><?= $i ?></a></li>
		<?php else: ?>
			<li class="disabled"><a href="#"><?= $i ?></a></li>
		<?php endif ?>
	<?php endfor ?>
</ul>

<div class="api">
	<?php $j = 0 ?>
	<?php foreach ($letters as $l => $classes): ?>
		<?php if ($j++ % 3 == 0): ?>
		<div class="row-fluid">
		<?php endif ?>
			<div class="span4">
				<a name="letter-<?= $l ?>"></a>
				<h3><?= $l ?></h3>
				<ul>
					<?php foreach ($classes as $c): ?>
						<li><a href="~/api/class/<?= $c ?>"><?= $c ?></a></li>
					<?php endforeach ?>
				</ul>
			</div>
		<?php if ($j % 3 == 0): ?>
		</div>
		<?php endif ?>
	<?php endforeach ?>
</div>