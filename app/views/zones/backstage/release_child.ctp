<section>
	<div class="fake_pic">
		Backstage
	</div>
	<p>
		<q>Alright, where is she?</q> you slowly scan the backstage area with your flashlight, looking for
		the wee zombie-child that made off with the precious last can of air freshener.
	</p>
</section>
<section>
	<div class="fake_pic">
		VIDEO: Searching around the backstage area with a flashlight. You stumble upon Zombie Child
		with her back turned, perched atop a corpse. Zombie child suddenly turns around and hisses at
		you with a handful of bloody intestines. Startled, you fall to the floor and sort of frantically
		crab-walk backwards as she chases you all the way to the dancefloor.
	</div>
</section>
<section>
	<div class="fake_pic">Zombie Child about to eat your face off</div>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'dancefloor')); ?>
	<?php echo $this->Form->hidden('action', array('value' => 'combat_child')); ?>
	<?php echo $this->Form->submit('Physically assault this small child', array('id' => 'beat_up_child')); ?>
	<?php echo $this->Form->end(); ?>

	<div id="you_monster">Seriously?</div>
</section>
<?php $this->Js->buffer("setupSplitNarration()"); ?>
<?php $this->Js->buffer("
	$('beat_up_child').onmouseover = function() {
		$('you_monster').style.visibility = 'visible';
	}
	$('beat_up_child').onmouseout = function() {
		$('you_monster').style.visibility = 'hidden';
	}
	$('beat_up_child').onfocus = function() {
		$('you_monster').style.visibility = 'visible';
	}
	$('beat_up_child').onblur = function() {
		$('you_monster').style.visibility = 'hidden';
	}
"); ?>