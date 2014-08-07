<?php if ($can_afford): ?>
	<div class="fake_pic">Bartender gratefully receiving a $1 bill</div>
	<p>
		<q>Thanks!</q> the bartender exclaims while giving you a thumbs-up and winking.
		It's a little unsettling.
	</p>
	<?php echo $this->element('button_groups/bar'); ?>
<?php else: ?>
	<section>
		<div class="fake_pic">Bartender waiting for a tip</div>
		<?php $nontips = array(
			"Don't play leapfrog with unicorns!",
			"Don't eat the yellow snow!",
			"Don't spit into the wind!",
			"Get a better job!",
			"Never take wooden nickles!",
			"Don't take candy from strangers!"
		); ?>
		<p>
			You rummage around in your pockets looking for a dollar, but can't scrounge one up.
			The bartender looks at you, expectantly. <q>Uh... Here's your tip,</q> you say.
			<q><?php echo array_rand(array_flip($nontips)); ?></q>
		</p>
	</section>
	<section>
		<div class="fake_pic">Bartender glaring and flipping you off</div>
		<?php echo $this->element('button_groups/bar'); ?>
	</section>
	<?php $this->Js->buffer("setupSplitNarration()"); ?>
<?php endif; ?>