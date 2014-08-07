<?php if ($question == 'burpies'): ?>
	<section>
		<div class="fake_pic">Bartender talking</div>
		<p>
			<q>You need to puke? No way that's all the alcohol you've been
			drinking. You probably coincidentally have a stomach virus.</q>
		</p>
	</section>
	<section>
		<div class="fake_pic">Bartender talking and pointing to the restrooms</div>
		<p>
			<q>Now go to the restroom and spew in a toilet, because if you hurl on
			the bar, I'm going to beat the piss out of you and feed you
			to the zombies.</q>
		</p>
		<?php echo $this->element('button_groups/bar'); ?>
	</section>
	<?php $this->Js->buffer("setupSplitNarration()"); ?>
<?php elseif ($question == 'what_now'): ?>
	<?php if (! $gamestate['q_tipjar_given']): ?>
		<div class="fake_pic">Bartender talking</div>
		<p>
			<q>Well, you can start by finding that tipjar. Like I said, I'll give you a cut of the money if you can find it and bring it back here.</q>
		</p>
	<?php elseif ($gamestate['zhealth_soundbooth'] > 0): ?>
		<div class="fake_pic">Bartender talking and pointing to the soundbooth</div>
		<p>
			<q>You can do me a favor and kill that zombie in the soundbooth. I've been hoping that he'd at least play Thriller,
			but it's still that Cranberries song on loop.</q>
		</p>
	<?php elseif ($gamestate['zhealth_comedian'] > 0): ?>
		<div class="fake_pic">Bartender talking and pointing to the Comedy Corner</div>
		<p>
			<q>I've been hearing a bunch of groaning and shrieking over
			in the Comedy Corner. There's either a zombie over there or
			Bobcat Goldthwait. Kill him either way.</q>
		</p>
	<?php elseif (! $gamestate['q_derby_girls_released']): ?>
		<div class="fake_pic">Bartender talking and pointing to the back</div>
		<p>
			<q>I don't know what's going on, but I heard some commotion
			in the back, behind the stage. You'd better take a look.</q>
		</p>

	<?php else: ?>
		<div class="fake_pic">Bartender talking and shrugging</div>
		<p>
			<q>Actually, as far as I can tell, you've killed all of the zombies. But something tells me more zombies and tasks
			are going to be programmed- Er... will appear soon. Only thing left to do right now is drink your ass off
			and check out the wacky 'drunk-vision' special effects that hopefully your browser can render properly.</q>
		</p>
	<?php endif; ?>
	<?php echo $this->element('button_groups/bar'); ?>
<?php elseif ($question == 'destankify'): ?>
	<?php if (isset($already_have_mop_closet_key)): ?>
		<section>
			<div class="fake_pic">Bartender listening</div>
			<p>
				<q>Hey, I found your tip jar, but it's in the men's room, and it smells really, really awful in there,</q>
				you tell the bartender. <q>It's like Satan's gym sock was f-</q>
			</p>
			<p>
				<q>Yeah, you already told me. And I gave you a key to the mop closet. Go open up the mop
				closet and get the last	can of air freshener and spray it around in the restroom.</q>
			</p>
		</section>
		<?php if ($gamestate['q_mop_closet_opened']): ?>
			<?php if ($gamestate['q_air_freshener_found']): ?>
				<section>
					<div class="fake_pic">Bartender listening</div>
					<p>
						<q>Oh, you mean <em>this</em> air freshener?</q> you ask, holding up the can of air freshener.
					</p>
				</section>
				<section>
					<div class="fake_pic">Bartender yelling</div>
					<p>
						<q><em>Why don't you have my tip jar yet?!</em></q>
					</p>
					<?php echo $this->element('button_groups/bar'); ?>
				</section>
			<?php else: ?>
				<section>
					<div class="fake_pic">Bartender listening</div>
					<p>
						<q>But I opened up the mop closet and a tiny demon hellspawn nightmare-child ran out of it
						with the air freshener and ran back behind the stage. Is there another can of air freshener
						somewhere?</q> you ask.
					</p>
					<p>
						<q>No. Now go get that can back and get me my tip jar.</q>
					</p>
					<?php echo $this->element('button_groups/bar'); ?>
				</section>
			<?php endif; ?>
			<?php $this->Js->buffer("setupSplitNarration()"); ?>
		<?php else: ?>
			<?php echo $this->element('button_groups/bar'); ?>
		<?php endif; ?>
	<?php else: ?>
		<section>
			<div class="fake_pic">Bartender listening</div>
			<p>
				<q>Hey, I found your tip jar, but it's in the men's room, and it smells really, really awful in there,</q>
				you tell the bartender. <q>It's like Satan's gym sock was filled with rotten potatoes and used to beat
				the farts out of a frat house futon. Can you think of any way to destankify it?</q>
			</p>
		</section>
		<section>
			<div class="fake_pic">Bartender talking and outraged</div>
			<p>
				<q>The hell? You can't get my tip jar back because the men's room is too stinky?</q>
				You nod. <q>Hold your damn nose!</q>
			</p>
			<p>
				<q>But then I'd have to fight one-handed.</q>
			</p>
			<p>
				<q>Oh, now you're just being a baby,</q> the bartender says with a scowl as he turns to retrieve something from
				behind the bar. His hurtful words cut you deeply. You used to <em>be</em> a baby.
			</p>
		</section>
		<section>
			<div class="fake_pic">Bartender handing you a key</div>
			<p>
				<q>Here,</q> the bartender hands you a key. <q>It's the key to the mop closet between the restrooms. I think
				there's one can of air freshener left. Would that be good enough for your delicate olfactory sensibilities,
				princess?</q>
			</p>
			<?php echo $this->element('button_groups/bar'); ?>
		</section>
		<?php $this->Js->buffer("setupSplitNarration()"); ?>
	<?php endif; ?>
<?php elseif ($question == 'flashlight'): ?>
	<section>
		<div class="fake_pic">Bartender listening</div>
		<p>
			<q>I tried to go backstage, but it's really dark back there. Could you lend me a flashlight?</q> you ask
			the bartender.
		</p>
	</section>
	<section>
		<div class="fake_pic">Bartender talking and pointing to the soundbooth</div>
		<p>
			<q>Yeah, there should be one in the soundbooth.</q>
		</p>
		<?php echo $this->element('button_groups/bar'); ?>
	</section>
	<?php $this->Js->buffer("setupSplitNarration()"); ?>
<?php else: ?>
	<div class="fake_pic">Bartender talking, confused</div>
	<p>
		<q>Huh? Knock off that jibber-jabber.</q>
	</p>
	<?php echo $this->element('button_groups/bar'); ?>
<?php endif; ?>