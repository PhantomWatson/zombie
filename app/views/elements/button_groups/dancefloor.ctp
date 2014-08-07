<?php if ($gamestate['zhealth_hippie'] <= 0): ?>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'restrooms')); ?>
	<?php echo $this->Form->end('Visit the restrooms'); ?>
<?php endif; ?>

<?php if ($gamestate['zhealth_hippie'] <= 0): ?>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'backstage')); ?>
	<?php echo $this->Form->end('Go backstage'); ?>
<?php endif; ?>

<?php if (! ($gamestate['q_tipjar_found'] && $gamestate['zhealth_wheelchair'] > 0)): ?>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'bar')); ?>
	<?php echo $this->Form->end('Walk back to the bar'); ?>
<?php endif; ?>