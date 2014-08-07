<?php if ($gamestate['zhealth_mensrr'] > 0): ?>
	<section>
		<div class="fake_pic">Zombie is partially visible thrashing around in restroom</div>
		<p>
			You open the door a crack and peek inside the men's restroom. You see a zombie thrashing around, apparently
			unable to open the door himself. He looks like when he was alive, he was an expert at working knobs. But now that
			he's a zombie, all he knows how to do is decay and be irritating.
		</p>
		<p>
			You spot in the corner of the room the <span class="loot">bartender's stolen tip jar</span>! You remember
			the bartender telling you that he'd split that money with you if you retrieved it for him. You briefly consider
			just stealing the whole thing, but decide that you're just not that kind of zombie-hunter.
		</p>
	</section>

	<?php if (isset($stank_first_encountered)): ?>
		<section>
			<div class="fake_pic">Zombie is partially visible thrashing around in restroom</div>
			<p>
				<q>Hurk...</q> A waft of restroom air hits your nostrils and you puke in your mouth a little.
				<q>What even <em>makes</em> a smell like that?!</q> It's like an Indian restaurant's septic tank
				ruptured into a Long John Silver's dumpster. The smell is so overpowering, you're literally
				incapable of setting foot in there.
			</p>
			<?php echo $this->element('button_groups/restrooms'); ?>
		</section>
	<?php elseif (! $gamestate['q_air_freshener_found']): ?>
		<section>
			<div class="fake_pic">Zombie is partially visible thrashing around in restroom</div>
			<p>
				It still smells so god-awful in the men's room that you can't bring yourself to set food in there.
				It smells like a sack of expired Long John Silver's food after being passed through a very old dog.
				<?php if (! $gamestate['q_mop_closet_key']): ?>
					Maybe the bartender has a gallon of Febreeze or a full set of scuba equipment that he can lend you.
				<?php else: ?>
					Maybe you should get that last can of air freshener like the bartender suggested.
				<?php endif; ?>
			</p>
			<?php echo $this->element('button_groups/restrooms'); ?>
		</section>
	<?php elseif (isset($using_air_freshener)): ?>
		<section>
			<div class="fake_pic">Zombie is partially visible thrashing around in restroom</div>
			<p>
				You take a whiff of the air circulating around the men's room and barely avoid puking your pants.
				<q>Hurk...</q> The foulest stench is in the air, the funk of forty thousand years
				(since a janitor last set foot in there).
				As you're blasted by the overpowering smell of rancid men's room stank, you remember the
				<span class="loot">can of air freshener</span> that you swiped earlier.
			</p>
		</section>
		<section>
			<div class="fake_pic">Player sprays air freshener into the restroom</div>
			<p>
				You stick the can in the crack in the door and spend a minute emptying it out, much to the
				disapproval of the zombie inside.
			</p>
		</section>
	<?php endif; ?>

	<?php if ($gamestate['q_air_freshener_used']): ?>
		<section>
			<div class="fake_pic">Zombie is partially visible thrashing around in restroom</div>
			<p>
				You put your nose up to the crack in the door and cautiously take another whiff. You breathe a
				sigh of relief, as the room smells less like a rotten sack of buttholes and more like an
				air freshener tanker truck accident. Unfortunately, there's still a zombie in there that you'll have
				to whomp on.
			</p>
			<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
			<?php echo $this->Form->hidden('zone', array('value' => 'mensrr')); ?>
			<?php echo $this->Form->hidden('action', array('value' => 'combat')); ?>
			<?php echo $this->Form->end('Hit the (zombie) head'); ?>
			<?php echo $this->element('button_groups/restrooms'); ?>
		</section>
	<?php endif; ?>

	<?php $this->Js->buffer("setupSplitNarration()"); ?>

<?php else: ?>
	<?php if ($gamestate['burpies']): ?>
		<div class="fake_pic">Inside of men's restroom, with zombie dead</div>
		<p>
			<q>Urp...</q> According to your watch, it's puke o'clock.
		</p>
		<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
		<?php echo $this->Form->hidden('zone', array('value' => 'mensrr')); ?>
		<?php echo $this->Form->hidden('action', array('value' => 'vomit')); ?>
		<?php echo $this->Form->end('Hurl'); ?>
	<?php else: ?>
		<div class="fake_pic">Inside of men's restroom, with zombie dead</div>
		<p>
			You pull out a permanent marker and add to the collection of dicks drawn on the wall.
		</p>
		<div class="fake_pic">Player draws a dick on the wall</div>
		<p>
			You congratulate yourself for being outrageously clever and funny, then add a dick to the zombie's face for good measure.
		</p>
		<div class="fake_pic">Dick drawn on zombie's face</div>
	<?php endif; ?>
	<?php echo $this->element('button_groups/restrooms'); ?>
<?php endif; ?>