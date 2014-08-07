<?php if ($gamestate['zhealth_soundbooth'] > 0): ?>

	<div class="fake_pic">Zombie lurking in the soundbooth</div>
	<p>
		Look at that undead dickface, lurking in the soundbooth like he owns the place.
	</p>	
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'soundbooth')); ?>
	<?php echo $this->Form->hidden('action', array('value' => 'combat')); ?>
	<?php echo $this->Form->end('Perform an eviction'); ?>
	
	<hr class="here_elsewhere" />

<?php else: ?>

	<div class="fake_pic">Soundbooth with dead zombie in it</div>
	<p>
		You hope that someone on the janitorial staff will drag this zombie out of the soundbooth tomorrow so you don't have to.
	</p>

<?php endif; ?>

<?php echo $this->element('button_groups/soundbooth'); ?>