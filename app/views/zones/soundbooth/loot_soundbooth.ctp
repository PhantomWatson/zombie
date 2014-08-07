<section>
	<div class="fake_pic">Looting corpse</div>
	<?php echo $this->element('loot', compact('loot')); ?>
</section>
<section>
	<div class="fake_pic">Grabbing flashlight</div>
	<p>
		You notice a flashlight. <q>Hey, this could come in handy.</q> You pick it up and stick it in your pocket.
	</p>
	<?php echo $this->element('button_groups/soundbooth'); ?>
</section>
<?php $this->Js->buffer("setupSplitNarration()"); ?>