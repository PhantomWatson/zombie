<?php header('Content-type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>
			Doc's Zombie Hoedown
		</title>
		<meta name="description" content="Save Doc's Music Hall from zombie barflies and whatnot!" />
		<meta name="keywords" content="doc's zombie hoedown muncie indiana" />
		<meta name="language" content="en" />
		<link rel="stylesheet" type="text/css" href="/css/main.css" />
		<link href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:extralight,light,regular,bold" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Walter+Turncoat" rel="stylesheet" type="text/css" />
		<?php 
			echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js');
			echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.3/scriptaculous.js');
			echo $this->Html->script('misc.js');
			echo $scripts_for_layout;
			echo $this->Html->charset('utf-8');
		?>
	</head>
	<body id="site_body">
		<div id="header">
			<div class="inner">
				<div id="masthead">
					Doc's Zombie Hoedown
				</div>
				<?php if (isset($player_health_remaining) && isset($player_max_health)): ?>
					<div id="health">
						<div id="player_health">
							<div class="who">Health:</div>
							<div class="bar">
								<div id="player_health_bar" class="remaining" style="width: <?php echo round(($player_health_remaining / $player_max_health) * 100); ?>%;"></div>
							</div>
							<div class="numbers">
								<span id="player_health_remaining"><?php echo $player_health_remaining; ?></span>/<?php echo $player_max_health; ?>
							</div>
						</div>
						<div id="zombie_health">
							<?php if (isset($zombie_health_remaining) && isset($zombie_max_health)): ?>
								<div class="who">Zombie:</div>
								<div class="bar">
									<div id="zombie_health_bar" class="remaining" style="width: <?php echo round(($zombie_health_remaining / $zombie_max_health) * 100); ?>%;"></div>
								</div>
								<div class="numbers">
									<span id="zombie_health_remaining"><?php echo $zombie_health_remaining; ?></span>/<?php echo $zombie_max_health; ?>
								</div>
							<?php endif; ?>
						</div>
						<br style="clear: both;" />
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div id="wrapper">
			<?php echo $content_for_layout ?>
			
			<?php if (isset($inventory)): ?>
				<div id="inventory">
					<span>Stuff you are carrying:</span>
					<ul>
						<?php foreach ($inventory as $inventory_item): ?>
							<li><?php echo $inventory_item; ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
		
		<?php echo $this->Js->writeBuffer(); ?>
		
		<a href="/restart" style="position: fixed; bottom: 0; left: 0;">Clear all progress and restart game</a><br />
		
		<?php if (Configure::read('debug')): ?>
			<hr />
			Debugging stuff:
			<div id="debug_readout">
				
				<?php echo '$this->data: <pre>'.print_r($this->data, true).'</pre>'; ?>
				Gamestate (cookie):
				<?php echo '<pre>'.print_r($gamestate, true).'</pre>'; ?>
				<br />Serialized:
				<?php echo serialize($gamestate); ?>
			</div>
		<?php endif; ?>
	</body>
</html>