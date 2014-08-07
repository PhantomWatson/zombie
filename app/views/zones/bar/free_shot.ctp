<section>
	<div class="fake_pic">Player picks up shotglass</div>
	<p>
		You pick the shot up off of the bar.
	</p>
	<p>
		<q>Careful!</q> the bartender warns. <q>It's got a real... <em>kick</em> to it.</q>
		You eye the bartender suspiciously, then swallow the shot.
	</p>
</section>

<section>
	<div class="fake_pic">Player takes a shot</div>
	<p>
		All of a sudden one of your legs spasms and you involuntarily kick over a barstool.
		<q>Woah, save it for the zombies,</q> the bartender says. You nod and make a mental
		note to try <span class="new_attack">kicking some zombies</span> instead of only
		punching them so you don't scuff your manicure.
	</p>
</section>

<section>
	<div class="fake_pic">Looking into empty shotglass</div>
	<p>
		As the booze settles in your stomach, you feel some of the wounds inflicted by that last zombie
		healing up. <q>What the... Oh, yeah.</q> You remember reading a Trivial Pursuit card last week
		that said that alcohol instantly heals zombie-fighting injuries. Which makes perfect sense.
		<q>Hey, if I get beaten up while I'm saving this place from its inexplicable zombie infestation,
		can I come back to the bar and get more magical wound-curing booze?</q>
	</p>
	<p>
		<q>Of course. Just come back here if you get hurt and I'll pour you something that'll fix you right up.</q>
	</p>
	<p>
		<q>Awesome! For free?</q> you ask.
	</p>
	<p>
		<q>Ha ha ha! Of course not.</q>
	</p>
</section>

<section>
	<div class="fake_pic">Bartender glaring at you</div>
	<?php echo $this->element('buttons/tip'); ?>
	<?php echo $this->element('button_groups/bar'); ?>
</section>

<?php $this->Js->buffer("setupSplitNarration()"); ?>