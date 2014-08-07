<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
<?php echo $this->Form->hidden('zone', array('value' => 'restrooms')); ?>
<?php echo $this->Form->end('Visit the restrooms'); ?>

<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
<?php echo $this->Form->hidden('zone', array('value' => 'dancefloor')); ?>
<?php echo $this->Form->end('Get out on the dancefloor'); ?>