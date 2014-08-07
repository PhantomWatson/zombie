<?php if ($gamestate['q_free_shot_taken']): ?>
	<div id="order_a_drink">
		<input type="button" value="Order <?php echo (isset($ordered_a_drink)) ? 'another' : 'a'; ?> drink" onclick="showDrinkPanel()" />
	</div>
	<div id="drinks" style="display: none; height: 284px;">
		<div>
			<p>
				<q>If you're looking to get your drunk on, your choices are cheap beer and well liquor,</q>
				the bartender explains. <q>If you're looking to get your drunk <em>off</em>, you could
				get a cup of black coffee and it'll sober you up a little bit, despite what any so-called
				'medical doctors' might say.</q>
			</p>

			<table class="button_panel">
				<thead>
					<tr>
						<td>Drink</td>
						<td>Cost</td>
						<td>Effect</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
							<?php echo $this->Form->hidden('zone', array('value' => 'bar')); ?>
							<?php echo $this->Form->hidden('action', array('value' => 'buy_shot')); ?>
							<?php echo $this->Form->end('A shot'); ?>
						</td>
						<td>
							$3
						</td>
						<td>
							+5 Health
						</td>
					</tr>
					<tr>
						<td>
							<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
							<?php echo $this->Form->hidden('zone', array('value' => 'bar')); ?>
							<?php echo $this->Form->hidden('action', array('value' => 'buy_beer')); ?>
							<?php echo $this->Form->end('A beer'); ?>
						</td>
						<td>
							$2.50
						</td>
						<td>
							+4 Health
						</td>
					</tr>
					<tr>
						<td>
							<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
							<?php echo $this->Form->hidden('zone', array('value' => 'bar')); ?>
							<?php echo $this->Form->hidden('action', array('value' => 'buy_coffee')); ?>
							<?php echo $this->Form->end('Coffee'); ?>
						</td>
						<td>
							$1.00
						</td>
						<td>
							-0.02 BAC
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
<?php else: ?>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'bar')); ?>
	<?php echo $this->Form->hidden('action', array('value' => 'free_shot')); ?>
	<?php echo $this->Form->end('Drink the free shot'); ?>
<?php endif; ?>