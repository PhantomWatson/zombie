<?php if ($gamestate['last_zone'] != 'womensrr'): ?>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'womensrr')); ?>
	<?php echo $this->Form->end('Check out the women\'s restroom'); ?>
<?php endif; ?>

<?php if ($gamestate['last_zone'] != 'mop_closet'): ?>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'mop_closet')); ?>
	<?php echo $this->Form->end('Open the mop closet'); ?>
<?php endif; ?>

<?php if ($gamestate['last_zone'] != 'mensrr'): ?>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'mensrr')); ?>
	<?php echo $this->Form->end('Check out the men\'s restroom'); ?>
<?php endif; ?>

<hr class="here_elsewhere" />

<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
<?php echo $this->Form->hidden('zone', array('value' => 'dancefloor')); ?>
<?php echo $this->Form->end('Get out on the dancefloor'); ?>

<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
<?php echo $this->Form->hidden('zone', array('value' => 'backstage')); ?>
<?php if (isset($releasing_mop_closet_zombie)): ?>
	<?php echo $this->Form->end('Follow the zombie backstage'); ?>
<?php else: ?>
	<?php echo $this->Form->end('Go backstage'); ?>
<?php endif; ?>