<?php if (! $gamestate['q_mop_closet_key']): ?>

	<div class="fake_pic">Player tugs at mop closet's locked doorknob</div>
	<p>
		You try to open the mop closet, but find it locked. <q>Consarned and dag-blast it!</q> you exclaim,
		channeling the spirit of a displeased 1840s gold prospector.
	</p>
	<p>
		Whatever. You didn't feel like mopping anything anyway.
	</p>

	<?php echo $this->element('button_groups/restrooms'); ?>

<?php elseif (isset($releasing_mop_closet_zombie)): ?>

	<section>
		<div class="fake_pic">Player unlocks door</div>
		<p>
			You unlock the door to the mop closet.
		</p>
	</section>

	<section>
		<div class="fake_pic">Player reaching into mop closet, feeling for a light switch</div>
		<p>
			You reach your hand inside, feeling around on the wall for a light switch.
		</p>
	</section>

	<section>
		<div class="fake_pic">OH SHIT ZOMBIE CHILD JUMPED OUT AND LATCHED ONTO YOUR LEG</div>
		<p>
			<q>CRAP.</q>
		</p>
		<p>
			You try to shake the zombie child off of your leg, but she quickly sinks her claws into you in a death grip.
		</p>
	</section>

	<section>
		<div class="fake_pic">OH SHIT ZOMBIE CHILD BITING YOUR KNEE</div>
		<p>
			The zombie chomps on your knee as you flail around, screaming.
		</p>
	</section>

	<section>
		<div class="fake_pic">Swinging your leg up and into the wall, bashing the attached zombie</div>
		<p>
			You swing your leg up and bash the zombie into a nearby wall. She loses her grip and falls to the floor.
		</p>
	</section>

	<section>
		<div class="fake_pic">Zombie on floor has can of air freshener in her hand</div>
		<p>
			You spot the can of air freshener in the zombie's hand as she stumbles to her feet.
		</p>
	</section>

	<section>
		<div class="fake_pic">Zombie with can of air freshener running to backstage area</div>
		<p>
			You try to grab the air freshener from the zombie, but she dashes away from you and runs to the
			back stage area. Hey, these things are supposed to chase <em>you</em>, not the other way around.
		</p>

		<?php echo $this->element('button_groups/restrooms'); ?>
	</section>

	<?php $this->Js->buffer("setupSplitNarration()"); ?>

<?php else: ?>

	<div class="fake_pic">Looking into mop closet</div>
	<p>
		You poke around in the mop closet and find nothing particularly relevant to the plot.
		<?php if (! $gamestate['q_air_freshener_found']): ?>
			Especially not any convenient extra cans of air freshener. Looks like that little creep
			ran backstage with the last one.
		<?php endif; ?>
	</p>

	<?php echo $this->element('button_groups/restrooms'); ?>

<?php endif; ?>