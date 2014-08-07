<div class="fake_pic">Restrooms</div>

<p>
	You approach the entrance to the restrooms, the most horrifying and dangerous part of the nightclub.
	The introduction of zombies actually didn't change that much.
</p>

<?php if ($gamestate['zhealth_mensrr'] > 0): ?>
	<p>
		You hear loud thumping and enraged commotion coming from the men's room. Either there's a zombie 
		in there that you'll have to beat up, or someone's violently working through some bean-burrito-related issues. 
	</p>
<?php endif; ?>

<?php echo $this->element('button_groups/restrooms'); ?>