<section>
	<div class="fake_pic">Panicked bartender gets your attention from behind the bar</div>
	<p>
		You walk into your favorite nightclub in downtown Muncie, IN to discover a panicked bartender barricading
		himself behind the bar. You glance around the building and realize that the hustle and/or bustle of the normal
		crowd has been replaced by the uncanny shambling of the cannibalistic walking dead! You and the bartender seem
		to be the only living people in sight. <q>Hey!</q> he yells to you. <q>Do me a solid and kill all these goddamn
		zombies!</q> You shake off a momentary feeling of fear and see your opportunity to be a hero.
	</p>

	<p>
		<q>Don't worry!</q> you reassure the bartender, <q>Watch me do a solid <em>all over</em> this bar!</q> You immediately
		regret your choice of words. <q>But I've never had to kill a zombie before. Don't I need a gun or a chainsaw or
		Ving Rhames or something?</q>
	</p>
</section>

<section>
	<div class="fake_pic">Bartender talking</div>
	<p>
		<q>Hell if I know. Use whatever you can in the bar to survive and toe-tag all of these jerks.</q> The bartender
		glances around nervously. <q>Just remember that to kill a zombie, you need to remove its head or destroy
		its brain,</q> he explains.
	</p>

	<p>
		You shudder at the thought. <q>Okay. But I don't know h-</q>
	</p>

	<p>
		<q>Or, like, just beat the shit out of it. Yeah.</q>
	</p>

	<p>
		<q>Okay, I can do that,</q> you assure the bartender.
	</p>
</section>

<section>
	<div class="fake_pic">A zombie shambles up to the bar</div>

	<p>
		All of a sudden, a zombie shambles up to the bar and starts trying to grab the bartender.
		<q>Fuckballs! Help me kill this thing!</q> he pleads. <q>By which I mean <em>kill this thing!</em></q>
	</p>

	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'bar')); ?>
	<?php echo $this->Form->hidden('action', array('value' => 'combat')); ?>
	<?php echo $this->Form->end('Commence to asswhooping'); ?>
</section>

<?php $this->Js->buffer("setupSplitNarration()"); ?>