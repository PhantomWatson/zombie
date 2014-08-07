<?php if ($can_afford): ?>
	<div class="fake_pic">Bartender serving a cup of coffee</div>
	<p>
		You hand the bartender a buck. He pours a cup of awful black coffee and scoots it to you across the counter.
	</p>

	<div class="fake_pic">Drinking coffee</div>

	<p>
		You drink the coffee. It's black as midnight, black as pitch, blacker than the foulest witch. It makes you feel like punching a unicorn.
	</p>

	<?php echo $this->element('buttons/tip'); ?>

<?php else: ?>
	<div class="fake_pic">Glaring bartender</div>
	<p>
		You rummage around in your pockets, but can't manage to scrounge up a measly buck.
	</p>

	<p>
		<q>Hey, you need money if you want some coffee. What, do you think coffee just grows on trees?</q>
	</p>

	<p>
		<q>Actually, it-</q>
	</p>

	<p>
		<q>Don't be a wiseacre!</q> the bartender interrupts. <q>You know the drill. Go find more zombies to beat up then and steal their money.</q>
	</p>
<?php endif; ?>

<?php echo $this->element('button_groups/bar'); ?>