<div class="fake_pic">
	View of front area of club with comedian zombie on stage with microphone in hand
</div>

<p>
	A former comedian is propped up on the comedy stage, following the instincts that he had in life
	to make humorous observations of everyday life, groan-worthy puns, and ironic sexual innuendo.
	Except they're all just coming out as <q>UUUUNNNNNGGGGHHHH.</q>
</p>

<p>
	Food for thought: The comedy business and its fierce arms race of dick jokes have twisted this once
	charismatic and charming jokester into a jaded, cynical curmudgeon. Also food for thought: He wants to
	eat your brains. <em>Ba-dum tsh.</em>
</p>

<p>
	Why did the zombie cross the road?
</p>

<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
<?php echo $this->Form->hidden('zone', array('value' => 'front')); ?>
<?php echo $this->Form->hidden('action', array('value' => 'combat')); ?>
<?php echo $this->Form->end('To get its ass kicked'); ?>

<hr class="here_elsewhere" />

<?php echo $this->element('button_groups/front'); ?>