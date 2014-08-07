<?php if ($gamestate['q_free_shot_taken']): ?>
	<div class="fake_pic">The bar</div>
<?php else: ?>
	<div class="fake_pic">The bar, with a shot poured</div>
<?php endif; ?>

<?php echo $this->element('button_groups/bar'); ?>