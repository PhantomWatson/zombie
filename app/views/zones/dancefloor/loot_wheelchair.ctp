<section>
	<div class="fake_pic">Rifling through the zombie's backpack</div>
	<p>
		You look in the backpack on the back of the zombie's motorized wheelchair and find
		<span class="loot">$<?php echo number_format($loot['money'], 2); ?></span>.
		There's something else in the backpack, too...
	</p>
</section>
<section>
	<div class="fake_pic">Pulling a human head out of the backpack</div>
	<p>
		<q>Ugh!</q> It's <span class="loot">a human head</span>! You hesitantly decide to
		hang onto the head, figuring that you'll either be resourceful with it while fighting
		zombies or that you'll mount it on a stake in your lawn to scare away the neighbor's kids.
		<q>So, did some other zombie tear off the head and put it in his backpack, or did someone get decapitated
		while looking into the backpack?</q> you ask yourself. You try not to think about
		it too much.
	</p>
	<?php echo $this->element('button_groups/dancefloor'); ?>
</section>
<?php $this->Js->buffer("setupSplitNarration()"); ?>