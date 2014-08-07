<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
<?php echo $this->Form->hidden('zone', array('value' => 'bar')); ?>
<?php echo $this->Form->hidden('action', array('value' => 'tip')); ?>
<?php echo $this->Form->end('Tip the bartender a buck'); ?>