<section>
	<div class="fake_pic">Player sets tip jar on the bar</div>
	<p>
		<q>You found it! Thanks for getting this back for me,</q> the bartender says while counting out the money in the jar.
		<q>Mike makes us bartenders buy our own tip jars. ... Hey, are you a mohel?</q>
	</p>
	<p>
		<q>Huh?</q>
	</p>
</section>
<section>
	<div class="fake_pic">Bartender hands player $20.</div>
	<p>
		<q>Because here's your cut of the tips!</q>
	</p>
	<?php echo $this->element('button_groups/bar'); ?>
</section>
<?php $this->Js->buffer("setupSplitNarration()"); ?>