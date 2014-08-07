<div class="buttons">
	<?php echo $this->element('button_groups/talk_to_bartender'); ?>
	<?php echo $this->element('button_groups/drinks'); ?>
</div>

<hr class="here_elsewhere" />

<?php if (! $gamestate['looted_soundbooth']): ?>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'soundbooth')); ?>
	<?php echo $this->Form->end('Go to the soundbooth'); ?>
<?php endif; ?>

<?php if (! $gamestate['q_tables_searched'] < 10): ?>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'search_tables')); ?>
	<?php echo $this->Form->end('Search under the tables'); ?>
<?php endif; ?>

<?php if ($gamestate['zhealth_comedian'] > 0): ?>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'front')); ?>
	<?php echo $this->Form->end('Approach the Comedy Corner'); ?>
<?php endif; ?>

<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
<?php echo $this->Form->hidden('zone', array('value' => 'dancefloor')); ?>
<?php echo $this->Form->end('Get out on the dancefloor'); ?>