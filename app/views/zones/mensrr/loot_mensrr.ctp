<section>
	<div class="fake_pic">Looting the zombie's pockets</div>
	<?php echo $this->element('loot', compact('loot')); ?>
</section>
<?php if ($gamestate['burpies']): ?>
	<section>
		<div class="fake_pic">You pick up the tip jar</div>
		<p>
			A winner is you! Time to bring <span class="loot">the bartender's stolen tip jar</span> back to the bar.
		</p>
	</section>
	<section>
		<div class="fake_pic">Looking at toilet</div>
		<p>
			<q>Urp...</q> With that taken care of, you can finally have a nice puke in peace and quiet.
		</p>
		<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
		<?php echo $this->Form->hidden('zone', array('value' => 'mensrr')); ?>
		<?php echo $this->Form->hidden('action', array('value' => 'vomit')); ?>
		<?php echo $this->Form->end('Puke your guts out'); ?>
		<?php echo $this->element('button_groups/restrooms'); ?>
	</section>
<?php else: ?>
	<section>
		<div class="fake_pic">You pick up the tip jar</div>
		<p>
			A winner is you! Time to bring <span class="loot">the bartender's stolen tip jar</span> back to the bar.
		</p>
		<?php echo $this->element('button_groups/restrooms'); ?>
	</section>
<?php endif; ?>
<?php $this->Js->buffer("setupSplitNarration()"); ?>