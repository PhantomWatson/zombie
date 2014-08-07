<div id="combat_wrapper">
	<?php if (isset($begin_combat)): ?>

		<div id="combat_part_1" style="display: none;">
			<?php if (isset($begin_combat['pic'])): ?>
				<img src="/img/photos/<?php echo $begin_combat['pic']; ?>" />
			<?php endif; ?>
			<p><?php echo $begin_combat['message']; ?></p>
			<?php echo $this->element('combat_panel', compact('attacks', 'zone', 'combat_action')); ?>
		</div>

	<?php elseif (isset($zombie_already_dead_pic)): ?>

		<div id="combat_part_1" style="display: none;">
			<img src="/img/photos/<?php echo $zombie_already_dead_pic; ?>" />
			<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
			<?php echo $this->Form->hidden('zone', array('value' => $zone)); ?>
			<?php echo $this->Form->hidden('action', array('value' => $loot_action)); ?>
			<?php echo $this->Form->end("$loot_button_value"); ?>
		</div>

	<?php else: ?>

		<div id="combat_part_1" style="display: none;">
			<?php if ($player_attack_result['pic']): ?>
				<img src="/img/photos/<?php echo $player_attack_result['pic']; ?>" />
			<?php endif; ?>
			<p><?php echo $player_attack_result['message']; ?></p>

			<div id="combat_next_button_wrapper" style="display: none;">
				<input type="button" value="Continue..." />
			</div>
		</div>

		<div id="combat_part_2" style="display: none;">
			<?php if ($player_attack_result['zombie_killed_message']): ?>
				<img src="/img/photos/<?php echo $player_attack_result['zombie_killed_pic']; ?>" />
				<p><?php echo $player_attack_result['zombie_killed_message']; ?></p>
				<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
				<?php echo $this->Form->hidden('zone', array('value' => $zone)); ?>
				<?php echo $this->Form->hidden('action', array('value' => $loot_action)); ?>
				<?php echo $this->Form->end("$loot_button_value"); ?>

			<?php else: ?>

				<?php if ($zombie_attack_result['pic']): ?>
					<img src="/img/photos/<?php echo $zombie_attack_result['pic']; ?>" />
				<?php endif; ?>
				<p><?php echo $zombie_attack_result['message']; ?></p>
				<?php if ($zombie_attack_result['player_killed']): ?>
					<p class="player_killed">Oh no, you dead!</p>
					<?php echo $this->Form->create('Game', array('url' => '/game/restart')); ?>
					<?php echo $this->Form->end("Start a new game"); ?>
				<?php else: ?>
					<?php echo $this->element('combat_panel', compact('attacks', 'zone', 'combat_action')); ?>
				<?php endif; ?>

			<?php endif; ?>
		</div>

	<?php endif; ?>
</div>

<?php $this->Js->buffer("
	// Set 'before' health values
	var ph_before = $player_health_before;
	var ph_after = $player_health_after;
	var ph_msg_before = \"$player_health_msg_before\";
	var ph_msg_after = \"$player_health_msg_after\";
	var ph_max = $player_max_health;
	var zh_before = $zombie_health_before;
	var zh_after = $zombie_health_after;
	var zh_msg_before = \"".(isset($zombie_health_msg_before) ? $zombie_health_msg_before : '')."\";
	var zh_msg_after = \"".(isset($zombie_health_msg_after) ? $zombie_health_msg_after : '')."\";
	var zh_max = $zombie_max_health;
	var p_hb_width = Math.round((ph_before / ph_max) * 100);
	var z_hb_width = Math.round((zh_before / zh_max) * 100);
	$('player_health_bar').setStyle({width: p_hb_width + '%'});
	$('zombie_health_bar').setStyle({width: z_hb_width + '%'});
	$('player_health_remaining').update(ph_before);
	$('zombie_health_remaining').update(zh_before);

	// Set up and show 'continue' button
	var combat_next_button_wrapper = $('combat_next_button_wrapper');
	if (combat_next_button_wrapper) {
		var combat_next_button = combat_next_button_wrapper.down('input');
		combat_next_button.onclick = function() {
			showCombatPart2(ph_before, ph_after, ph_max, ph_msg_before, ph_msg_after);
		};
		if (combat_next_button_wrapper) {
			combat_next_button_wrapper.show();
		}
	}

	// Fade in first part of combat
	var combat_part_1 = $('combat_part_1');
	if (combat_part_1) {
		new Effect.Appear(combat_part_1, {
			delay: 0.3,
			duration: 1,
			afterFinish: function() {
				if (zh_before != zh_after) {
					adjustZombieHealthDisplay(zh_after, zh_max, zh_msg_before, zh_msg_after);
				}
			}
		});
	}
"); ?>