<?php if ($gamestate['burpies']): ?>
	<section>
		<div class="fake_pic">Rooting around in purse</div>
		<p><?php echo $loot['message']; ?></p>
	</section>
	<section>
		<div class="fake_pic">Looking at toilet</div>
		<p>
			<q>Urp...</q> With that taken care of, you can finally have a nice puke in peace and quiet.
		</p>
		<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
		<?php echo $this->Form->hidden('zone', array('value' => 'womensrr')); ?>
		<?php echo $this->Form->hidden('action', array('value' => 'vomit')); ?>
		<?php echo $this->Form->end('Puke your guts out'); ?>
		<?php echo $this->element('button_groups/restrooms'); ?>
	</section>
	<?php $this->Js->buffer("setupSplitNarration()"); ?>
<?php else: ?>
	<div class="fake_pic">Rooting around in purse</div>
	<p><?php echo $loot['message']; ?></p>
	<?php echo $this->element('button_groups/restrooms'); ?>
<?php endif; ?>