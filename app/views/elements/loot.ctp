<?php if (isset($loot)): ?>
	<?php if (isset($loot['pic'])): ?>
		<img src="/img/photos/<?php echo $loot['pic']; ?>" />
	<?php endif; ?>
	<p><?php echo $loot['message']; ?></p>
<?php endif; ?>