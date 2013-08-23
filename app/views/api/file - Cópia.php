<div class="grid_12">
	<h1>Classe: <?php echo $class ?></h1>
	<div class="code">
		<table>
			<tr>
				<td width="100%">
					<pre><ol><?php foreach($model as $n => $l): ?><li id="l<?= $n + 1 ?>"><?= $l ?></li><?php endforeach ?></ol></pre>
				</td>
			</tr>
		</table>
	</div>
</div>