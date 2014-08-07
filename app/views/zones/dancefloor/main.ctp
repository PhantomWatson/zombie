<?php if (! $gamestate['q_tipjar_found'] && $gamestate['zhealth_hippie'] > 0): ?>

	<div class="fake_pic">
		View of dancefloor (with zombie lurking in it), pool tables,
		and entrance to restrooms
	</div>

	<p>
		Hippie on the danceloor.
	</p>

	<p>
		Well, don't just stand there!
	</p>

	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'dancefloor')); ?>
	<?php echo $this->Form->hidden('action', array('value' => 'combat_hippie')); ?>
	<?php echo $this->Form->end('Bust a move! (into the zombie\'s face)'); ?>

	<hr class="here_elsewhere" />

<?php elseif ($gamestate['q_tipjar_found'] && $gamestate['zhealth_wheelchair'] > 0): ?>

	<div class="fake_pic">
		View of dancefloor (with dead zombie lying face-down), pool tables,
		and entrance to restrooms, with zombie in wheelchair blocking the way
	</div>

	<p>
		As you try to walk across the dancefloor, a motorized wheelchair carrying another
		zombie appears out of nowhere and maneuvers directly in front of you. You reflexively
		apologize and try to sidestep him, but he moves into your path. You try to move around
		him in the other direction and he blocks your way again. As you stand there, wondering
		if you could just climb straight over him to avoid having to fight him, he rolls directly
		into you and bashes your shin. As you stumble, he grabs your shirt and tries to pull you down
		toward his snapping teeth. You barely manage to wrestle from his grasp. <q>Oh, it's on.</q>
	</p>

	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'dancefloor')); ?>
	<?php echo $this->Form->hidden('action', array('value' => 'combat_wheelchair')); ?>
	<?php echo $this->Form->submit('Beat up the disabled guy', array('id' => 'beat_up_disabled_guy')); ?>
	<?php echo $this->Form->end(); ?>
	<div id="you_monster">You monster.</div>

	<?php $this->Js->buffer("
		$('beat_up_disabled_guy').onmouseover = function() {
			$('you_monster').style.visibility = 'visible';
		}
		$('beat_up_disabled_guy').onmouseout = function() {
			$('you_monster').style.visibility = 'hidden';
		}
		$('beat_up_disabled_guy').onfocus = function() {
			$('you_monster').style.visibility = 'visible';
		}
		$('beat_up_disabled_guy').onblur = function() {
			$('you_monster').style.visibility = 'hidden';
		}
	"); ?>

	<hr class="here_elsewhere" />

<?php else: ?>

	<div class="fake_pic">
		View of dancefloor (with dead zombie lying face-down), pool tables, and
		entrance to restrooms
	</div>

	<p>
		The dancefloor is now bereft of the living, who have all fled the bar in terror.
	</p>

<?php endif; ?>

<?php echo $this->element('button_groups/dancefloor'); ?>