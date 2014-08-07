<div id="sidebar">
	<?php if (isset($player_health_remaining) && isset($player_max_health)): ?>
		<div id="player_health" class="health">
			<div class="header">
				Health:
				<div class="bar">
					<div id="player_health_bar" class="remaining" style="width: <?php echo round(($player_health_remaining / $player_max_health) * 100); ?>%;"></div>
				</div>
			</div>
			<span class="numbers">
				(<span id="player_health_remaining"><?php echo $player_health_remaining; ?></span>/<?php echo $player_max_health; ?>)
			</span>
			<div class="message_wrapper">
				<div class="message">
					<?php echo isset($player_health_msg_before) ? $player_health_msg_before : $gamestate['player_health_msg']; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<?php if (isset($zombie_health_remaining) && isset($zombie_max_health)): ?>
		<div id="zombie_health" class="health">
			<div class="header">
				Zombie:
				<div class="bar">
					<div id="zombie_health_bar" class="remaining" style="width: <?php echo round(($zombie_health_remaining / $zombie_max_health) * 100); ?>%;"></div>
				</div>
			</div>
			<span class="numbers">
				(<span id="zombie_health_remaining"><?php echo $zombie_health_remaining; ?></span>/<?php echo $zombie_max_health; ?>)
			</span>
			<div class="message_wrapper">
				<div class="message">
					<?php echo isset($zombie_health_msg_before) ? $zombie_health_msg_before : $gamestate['zombie_health_msg']; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>
	
	<div id="bac">
		<div class="header">
			<acronym title="Blood Alcohol Concentration">BAC</acronym>:
			<span id="bac_value"><?php echo number_format($gamestate['bac'], 3); ?></span>
			<span id="bac_status">(<?php echo $bac_status_msg; ?>)</span>
		</div>
		<?php if (isset($bac_status_msg)): ?>
			
		<?php endif; ?>
		<?php if (isset($bac_descriptors)): ?>
			<div id="bac_descriptor_wrapper">
				<div id="bac_descriptor">
				</div>
			</div>
			<script type="text/javascript">
				<?php
					foreach ($bac_descriptors as &$bd) $bd = '"'.addslashes($bd).'"';
				?>
				var bac_descriptors = [<?php echo implode(', ', $bac_descriptors); ?>];
				var i = 0;
				$('bac_descriptor').update(bac_descriptors[0]);
				window.setTimeout(function(){updateBacDescriptor(i)}, 8000);
			</script>
		<?php endif; ?>
	</div>
	
	<?php if (isset($inventory)): ?>
		<div id="inventory">
			<div class="header">Stuff you are carrying:</div>
			<ul>
				<?php foreach ($inventory as $inventory_item): ?>
					<li><?php echo $inventory_item; ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	
	<div id="options">
		<div class="header" onclick="toggleOptions()">Options</div>
		<div id="options_inner" style="display: none;">
			<table>
				<tr>
					<td>Drunk Wobblies:</td>
					<td> 
						<input 
							type="button" 
							onclick="stopWobblies()" 
							value="On" 
							id="wobblies_disable_button" 
							<?php echo $gamestate['enable_wobblies'] ? '' : 'style="display: none;"'; ?> 
						/>
						<input 
							type="button" 
							onclick="startWobblies(<?php echo $drunk_level; ?>, true);" 
							value="Off" 
							id="wobblies_enable_button" 
							<?php echo $gamestate['enable_wobblies'] ? 'style="display: none;"' : ''; ?> 
						/>
					</td>
				</tr>
				
				<tr>
					<td>Drunk Blurries:</td>
					<td> 
						<input 
							type="button" 
							onclick="disableBlurries()" 
							value="On" 
							id="blurries_disable_button" 
							<?php echo $gamestate['enable_blurries'] ? '' : 'style="display: none;"'; ?> 
						/>
						<input 
							type="button" 
							onclick="enableBlurries()" 
							value="Off" 
							id="blurries_enable_button" 
							<?php echo $gamestate['enable_blurries'] ? 'style="display: none;"' : ''; ?> 
						/>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>