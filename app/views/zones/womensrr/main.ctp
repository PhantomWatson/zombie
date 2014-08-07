<?php if ($gamestate['zhealth_womensrr'] > 0): ?>
	<div class="fake_pic">Inside of women's restroom with zombie</div>
	<p>
		A confused lady zombie (or "she-z") is eerily shuffling about in the women's restroom, making it difficult for 
		still-living girlies to use it to take a leak with six of their friends.
	</p>
	<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
	<?php echo $this->Form->hidden('zone', array('value' => 'womensrr')); ?>
	<?php echo $this->Form->hidden('action', array('value' => 'combat')); ?>
	<?php echo $this->Form->end('Off the heezy fo sheezy*'); ?>
	<?php echo $this->element('button_groups/restrooms'); ?>
	<p class="footnote">* Kill the zombie</p>
<?php else: ?>
	<div class="fake_pic">Inside of women's restroom with dead zombie on floor</div>
	<?php if ($gamestate['burpies']): ?>
		<p>
			<q>Urp...</q> Ah! A toilet! Time to pray to the porcelain gods.
		</p>
		<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
		<?php echo $this->Form->hidden('zone', array('value' => 'womensrr')); ?>
		<?php echo $this->Form->hidden('action', array('value' => 'vomit')); ?>
		<?php echo $this->Form->end('Puke your guts out'); ?>
		
	<?php else: ?>
		<p>
			You step over the incapacitated zombie and obsessive-compulsively wash your hands six times.
		</p>
	<?php endif; ?>
	
	<?php echo $this->element('button_groups/restrooms'); ?>
<?php endif; ?>