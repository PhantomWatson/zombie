<?php if ($can_afford): ?>
	<?php if ($can_drink): ?>
		<section>
			<div class="fake_pic">Bartender serving a shot</div>
			<p>
				You slap $3 down on the bar. The bartender collects the money and pours you a shot. <q>Here you go.</q>
			</p>
			<p>
				<q>Down the hatch!</q>
			</p>
		</section>
		<section>
			<div class="fake_pic">Taking a shot</div>
			<?php echo $this->element('burpies'); ?>
			<?php echo $this->element('buttons/tip'); ?>
			<?php echo $this->element('button_groups/bar'); ?>
		</section>
	<?php else: ?>
		<section>
			<div class="fake_pic">Bartender serving a shot</div>
			<p>
				<q>Are you sure you can handle more?</q> he asks.
			</p>
			<p>
				You hand the bartender $3. <q>I can handle <em>your mom!</em></q> you shout, laughing.
				The bartender stares at you. <q>But yeah, I'd like a shot.</q> He shrugs and pours you a shot.
			</p>
		</section>
		<section>
			<div class="fake_pic">Holding a shot</div>
			<p>
				You bring the shotglass up to your face and feel your stomach defensively seize up.
				<q>Hurk...</q> You're not going to be able to put any more liquor down there until
				some comes back up first. Maybe you should head to the restroom and take care of that.
			</p>
			<p>
				<q>I'll just hang onto this until you're ready to have some more,</q> the bartender says,
				taking the beer back and sliding your $3 back to you.
			</p>
			<?php echo $this->element('button_groups/bar'); ?>
		</section>
	<?php endif; ?>
<?php else: ?>
	<section>
		<div class="fake_pic">Bartender waiting for money</div>
		<p>
			You rummage around in your pockets, but can't manage to scrounge up $3.
		</p>
	</section>
	<section>
		<div class="fake_pic">Bartender yelling</div>
		<p>
			<q>You have to pay up if you want a shot. I'm not running a soup kitchen here! For... booze soup!</q> he yells.
		</p>
		<p>
			<q>I'm sorr-</q>
		</p>
		<p>
			<q>Because that doesn't make any goddamn sense! You can probably find some cash on the zombies that are
			 still walking around in here. I don't think it counts as stealing if they're dead. It's more like
			 graverobbing, which I don't think you can be prosecuted for if they haven't been buried yet...</q>
		</p>
		<p>
			The bartender continues pondering aloud the potential legal ramifications of stealing money from zombies
			as you slowly back away from the bar.
		</p>
		<?php echo $this->element('button_groups/bar'); ?>
	</section>
<?php endif; ?>
<?php $this->Js->buffer("setupSplitNarration()"); ?>