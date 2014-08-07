<div id="talk_to_bartender">
	<input type="button" value="Talk to the bartender" onclick="showTalkPanel()" />
</div>
<div id="bartender_questions" style="display: none;">
	<div>
		<?php if ($gamestate['burpies']): ?>
			<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
			<?php echo $this->Form->hidden('zone', array('value' => 'bar')); ?>
			<?php echo $this->Form->hidden('action', array('value' => 'talk')); ?>
			<?php echo $this->Form->hidden('question', array('value' => 'burpies')); ?>
			<?php echo $this->Form->end('OH NO I GOTTA MAKE PUKIES.'); ?>
		<?php endif; ?>

		<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
		<?php echo $this->Form->hidden('zone', array('value' => 'bar')); ?>
		<?php echo $this->Form->hidden('action', array('value' => 'talk')); ?>
		<?php echo $this->Form->hidden('question', array('value' => 'what_now')); ?>
		<?php echo $this->Form->end('What should I do now?'); ?>

		<?php if ($gamestate['q_mensrr_stank_encountered'] && ! $gamestate['q_air_freshener_used']): ?>
			<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
			<?php echo $this->Form->hidden('zone', array('value' => 'bar')); ?>
			<?php echo $this->Form->hidden('action', array('value' => 'talk')); ?>
			<?php echo $this->Form->hidden('question', array('value' => 'destankify')); ?>
			<?php echo $this->Form->end("I can't get into the men's room."); ?>
		<?php endif; ?>

		<?php if ($gamestate['q_backstage_too_dark'] && ! $gamestate['q_flashlight_found']): ?>
			<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
			<?php echo $this->Form->hidden('zone', array('value' => 'bar')); ?>
			<?php echo $this->Form->hidden('action', array('value' => 'talk')); ?>
			<?php echo $this->Form->hidden('question', array('value' => 'flashlight')); ?>
			<?php echo $this->Form->end("Backstage is dark and scary."); ?>
		<?php endif; ?>
	</div>
</div>