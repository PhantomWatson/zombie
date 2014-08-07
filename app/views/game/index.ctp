<p>
	A game in development. Not at all ready for public consumption (none of the photos/videos
	have been shot yet), but feel free to play around with it. Please let me know if you notice
	any problems or if you have any suggestions.
</p>
<p>
	This game requries cookies and Javascript enabled in a modern, standards-compliant browser.
	<a href="http://www.mozilla.com/en-US/firefox/new/">Firefox</a>,
	<a href="http://www.google.com/chrome/">Chrome</a>,
	<a href="http://www.opera.com/download/">Opera</a>, and
	<a href="http://www.apple.com/safari/download/">Safari</a>
	should work, but Internet Explorer is not recommended. This game has only been
	tested in Firefox and hasn't been tested on any mobile devices yet.
</p>

<?php echo $this->Form->create('Game', array('url' => '/play')); ?>
<?php echo $this->Form->hidden('zone', array('value' => 'begin')); ?>
<?php if ($gamestate['q_started']): ?>
	<?php echo $this->Form->end('Continue game'); ?>
<?php else: ?>
	<?php echo $this->Form->end('Begin'); ?>
<?php endif; ?>