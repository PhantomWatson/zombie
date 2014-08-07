<section>
	<div class="fake_pic">Looting corpse</div>
	<?php echo $this->element('loot', compact('loot')); ?>
</section>

<section>
	<div class="fake_pic">Player picking up helmet</div>
	<p>
		<q>Hey, bonus!</q> you exclaim as you reach down and pick up the
		<span class="loot">zombie derby girl's helmet</span>. You shake all of the zombie gunk
		out of it and strap it to your own head, immediately feeling a little better protected.
		You silently hope that you can steal a full suit of armor from the next zombie you fight.
	</p>
</section>

<section>
	<div class="fake_pic">Derby girl</div>

	<p>
		The derby girl skates up to you, <q>You saved me! Thanks a lot! Is there anything
		I can do to repay you?</q>
	</p>

	<p>
		<q>Totally,</q> you say. <q>You can tell me how you did that fancy move that took that
		zombie out.</q>
	</p>

	<p>
		<q>Oh, you mean the Two-Wheeler Backwards Midnight Shin-Whack?</q>
	</p>

	<p>
		You stare at her. <q>Yeah, I suppose I do.</q>
	</p>

	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'dancefloor')); ?>
	<?php echo $this->Form->hidden('action', array('value' => 'learn_twbmsw')); ?>
	<?php echo $this->Form->end('Learn the two-wheel... reverse... whack. Thing.'); ?>
</section>

<?php $this->Js->buffer("setupSplitNarration()"); ?>