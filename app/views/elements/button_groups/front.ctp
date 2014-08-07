<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
<?php echo $this->Form->hidden('zone', array('value' => 'bar')); ?>
<?php echo $this->Form->end('Walk back to the bar'); ?>

<?php if (! $gamestate['looted_soundbooth']): ?>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'soundbooth')); ?>
	<?php echo $this->Form->end('Go to the soundbooth'); ?>
<?php endif; ?>