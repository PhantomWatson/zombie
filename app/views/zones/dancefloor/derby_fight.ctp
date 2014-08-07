<div class="fake_pic">
	Zombie derby girl and human derby girl fighting and emerging
	from backstage
</div>

<p>
	All of a sudden, two fully-uniformed derby girls, locked in combat, come skating out
	from backstage. You dodge out of the way just in time to avoid being knocked over,
	and watch as they take their fight to the dancefloor. You can see that only one of
	the derby girls is a zombie and the other one is having having trouble fighting her off.
</p>

<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
<?php echo $this->Form->hidden('zone', array('value' => 'dancefloor')); ?>
<?php echo $this->Form->hidden('action', array('value' => 'combat_derby')); ?>
<?php echo $this->Form->end('Save her!'); ?>