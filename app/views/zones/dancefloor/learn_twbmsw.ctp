<section>
	<div class="fake_pic">Derby girl explaining</div>
	<p>
		<q>Well, to perform the Two-Wheeler Backwards Midnight Shin-Whack, the most powerful
		roller derby move ever devised, you have to get a running start, drop into a cartwheel
		while twisting your arms
		<span class="trailing_off">
			so the torque of your wheels matches the Coriolis effect of
			<span class="trailing_off">
				your arms as you're pulling them in and landing on the Heisenberg compensator
				<span class="trailing_off">
					of your	left skate so you can adjust your
					<span class="trailing_off">
						yaw and strike with your tibia...
					</span>
				</span>
			</span>
		</span>
		</q>
	</p>

	<p>
		You nod politely as she continues describing the physics of her fancy attack and you
		continue not understanding a word of it. When it sounds like she's done, you ask
		<q>Does it matter that I don't have rollerskates?</q>
	</p>
</section>

<section>
	<div class="fake_pic">Derby girl explaining</div>
	<p>
		<q>Oh, that's fine. You just have to compensate by stutter-stepping into a reverse
		Buddha-blowout before the shimmy-jazzhands transition.</q>
	</p>

	<p>
		<q>Look, I have no idea what you're saying. Could you just do it again so I can watch?</q>
	</p>

	<p>
		<q>Sure!</q> She steps back a few feet, then spins around really fast while doing something
		with her arms, then a little backflip and then what looks like a short set of breakdancing
		windmills on the floor. The takeaway is that she flails around and her legs destroy whatever
		is in their path.
	</p>

	<p>
		<q>Alright, lemme give this a shot...</q> you step back so you can get a running start.
	</p>
</section>

<section>
	<div class="fake_pic">Derby girl being all like, "Hang on!"</div>
	<p>
		<q>Hang on!</q> she says. <q>Are you drunk?</q>
	</p>

	<?php if ($gamestate['bac'] == 0): // sober ?>
		<p><q>Nope.</q></p>
	<?php elseif ($gamestate['bac'] < 0.055): // basically sober ?>
		<p><q>Not really.</q></p>
	<?php elseif ($gamestate['bac'] < 0.16): // drunk ?>
		<p><q>Yep!</q></p>
	<?php elseif ($gamestate['bac'] < 0.29): // really drunk ?>
		<p><q>Quite!</q></p>
	<?php else: // fantastically drunk ?>
		<p><q>I'm not as drunk as you drunk I am! Wait, I did that wrong.</q> You puke a little on your shirt.</p>
	<?php endif; ?>

	<?php if ($gamestate['bac'] < 0.055): ?>
		<p>
			<q>Well, that's no good. Just like bowling and threesomes, there's no way
			you'll be able to do this right sober. Take this shot before you give it
			a try.</q> She produces a shot of whiskey from behind her back and hands
			it to you.
		</p>
	<?php else: ?>
		<p>
			<q>Great. Just like bowling and threesomes, there's no way you'd be able
			to do this right sober.	Have another shot to loosen you up a bit more
			before you try.</q> She produces a shot of whiskey from behind her
			back and hands it to you.
		</p>
	<?php endif; ?>
</section>

<section>
	<div class="fake_pic">Player taking shot</div>
	<p>
		You take the shot and feel it kick in. With magical drunk-confidence coursing through your veins, you
		spin around, flail enthusiastically, and slice a mighty kick through the air that would cleave a tree in half.
		Then you fall on your ass. <q>Crap.</q>
	</p>

	<p>
		<q>You did it!</q> she exclaims.
	</p>

	<p>
		<q>I did?</q> You feel a bit dizzy.
	</p>

	<p>
		<q>You did it perfectly!</q>
	</p>

	<p>
		<q>You're sure? Because it felt like I just flailed around and kicked.</q>
	</p>

	<p>
		<q>Yeah, that's how you do it!</q>
	</p>
</section>

<section>
	<div class="fake_pic">Derby girl helping you up</div>
	<p>
		<q>Oh... Okay.</q> The derby girl helps you to your feet and the feeling
		of dizziness passes. You notice that you feel a bit more sober all
		of a sudden, as if you never took that last shot.
	</p>

	<p>
		The derby girl looks at you and says, <q>You look like you're noticing that you feel a bit more sober all of a
		sudden, as if you never took that last shot.</q> You nod. <q>You'll find that when you perform the Two-Wheeler
		Backwards Midnight Shin-Whack, you'll actually sober up a bit. As you spin around, the blood rushes through your
		liver so quickly that it immediately filters a bunch of the alcohol out of your bloodstream, equivalent to about
		a shot.</q>
	</p>

	<p>
		<q>That sounds absolutely plausible and not at all like convoluted video game mechanics!</q> you tell her.
	</p>

	<p>
		<q>Yep! Just remember that you need to be buzzed to pull off the move, but it gets
		harder to do the drunker you get. Now go forth and kick zombies with your
		mighty drunken legs of justice!</q> she says as she skates off into the sunset.
	</p>

	<?php echo $this->element('button_groups/dancefloor'); ?>
</section>

<?php $this->Js->buffer("setupSplitNarration()"); ?>