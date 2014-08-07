<?php
$basic_attacks = $advanced_attacks = array();
foreach ($attacks as $a_name => $a_details) {
	switch ($a_name) {
		case 'twbmsw':
			$advanced_attacks[$a_name] = $a_details;
			break;
		default:
			$basic_attacks[$a_name] = $a_details;
	}
}
echo $this->Form->create('Game', array('url' => '/play'));
echo $this->Form->hidden('zone', array('value' => $zone));
echo $this->Form->hidden('action', array('value' => $combat_action)); 
?>

<table class="button_panel">
	<thead>
		<tr>
			<td>Attack</td>
			<td>Damage</td>
			<td>Chance of success</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($basic_attacks as $attack): ?>
			<tr>
				<td>
					<?php echo $this->Form->submit($attack['label'], array('name' => 'data[Game][attack]')); ?>
					<?php //echo $this->Js->submit($attack['label'].' (async)', array('update' => '#content', 'evalScripts' => true, 'buffer' => false)); ?>
				</td>
				<td>
					<?php echo $attack['damage'].'pt'.($attack['damage'] > 1 ? 's' : ''); ?>
				</td>
				<td>
					<?php echo $attack['chance']; ?>%
				</td>
			</tr>
		<?php endforeach; ?>
		<?php if (isset($advanced_attacks['twbmsw'])): ?>
			<tr>
				<td>
					<?php echo $this->Form->submit(
						$advanced_attacks['twbmsw']['label'], 
						array(
							'name' => 'data[Game][attack]',
							'disabled' => ($gamestate['bac'] < 0.125),
							'title' => 'Two-Wheeler Backwards Midnight Shin-Whack'
						)); ?>
				</td>
				<td>
					<?php echo $advanced_attacks['twbmsw']['damage'].'pt'.($advanced_attacks['twbmsw']['damage'] > 1 ? 's' : ''); ?>
				</td>
				<td>
					<?php if ($gamestate['bac'] < 0.125): ?>
						0%<br /><span style="font-size: 50%;">(not buzzed enough)</span>
					<?php else: ?>
						<?php echo $advanced_attacks['twbmsw']['chance']; ?>%
						<?php if ($advanced_attacks['twbmsw']['chance'] == 0): ?>
							<br /><span style="font-size: 50%;">(too drunk)</span>
						<?php endif; ?>
					<?php endif; ?>
				</td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>
<?php echo $this->Form->end(); ?>