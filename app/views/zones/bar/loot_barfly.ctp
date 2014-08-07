<section>
	<div class="fake_pic">A quarter!</div>
	<?php echo $this->element('loot', compact('loot')); ?>
</section>

<section>
	<div class="fake_pic">Relieved bartender</div>
	<p>
		<q>Phew!</q> the bartender exclaims. <q>Thanks for punching that zombie repeatedly and saving me! I owe you a shot,</q> the bartender explains as he pours a shot of whiskey.
	</p>
	<p>
		<q>Yeah, it wasn't really that hard. Why didn't you just do it?</q> you ask.
	</p>
</section>

<section>
	<div class="fake_pic">Bartender making a "save me" face</div>
	<p>
		<q>Nevermind that! This whole nightclub is infested with the animated corpses of our regulars.
		You need to continue punching faces and <em>save Doc's Music Hall!</em></q>
	</p>

	<p>
		<q>How did everyone die?</q> you ask.
	</p>
</section>

<section>
	<div class="fake_pic">Bartender talking</div>
	<p>
		<q>Nevermind that! The point is that they need to die <em>even more</em> before they kill us both
		and wreck up the joint and make us lose our security deposit! I'll do what I can to help you out, but
		I need to stay back behind the bar.</q>
	</p>

	<p>
		<q>Why?</q> you ask.
	</p>
</section>

<section>
	<div class="fake_pic">Frightened bartender</div>
	<p>
		<q>Mike will kill me if I abandon my post before my shift is over! But he's a zombie now, so I suppose he'll
		kill me either way. Still, I don't want to chance it.</q>
	</p>

	<p>
		<q>Who's this 'Mike' guy?</q> you ask.
	</p>
</section>

<section>
	<div class="fake_pic">Bartender talking</div>
	<p>
		<q>Mike Martin owns this joint. He's lurking somewhere in this building and god help you when you
		find him. He did <em>not</em> seem happy about being a zombie.</q>
	</p>

	<p>
		<q>So what should I do first?</q> you ask.
	</p>
</section>

<section>
	<div class="fake_pic">Bartender talking</div>
	<p>
		The bartender points to your left, toward the back of the building. <q>A zombie took one
		of my tip jars and
		ran somewhere past the dancefloor with it. He might have gone back to the restrooms. ... For some
		reason. I don't know what a zombie would be doing in the can.</q> The bartender strokes his chin
		thoughtfully. <q>Actually, it makes sense that if zombies spend all their time eating people,
		then they have to start working up a wicked buffet-shit after awhile.</q>
	</p>

	<p>
		<q>Wow. That's... not really addressed in zombie movies,</q> you realize.
	</p>

	<p>
		<q>Yeah. You're welcome for that imagery.</q>
	</p>
</section>
<section>
	<div class="fake_pic">Bartender talking</div>
	<p>
		<q>Anyway, there are probably zombies hiding all over this place, and it's your job to kill all of them.
		And if you can find my tip jar and bring it back here, I'll split that money with you.</q>
	</p>
	<p>
		<q>I'll do my best.</q>
	</p>
	<p>
		<em><q>And remember!</q></em> the bartender points at you emphatically. <q>If you get stuck and don't
		know what to do, you can come back here and I'll tell you what needs done.</q>
	</p>
	<?php echo $this->element('button_groups/bar'); ?>
</section>

<?php $this->Js->buffer("setupSplitNarration()"); ?>