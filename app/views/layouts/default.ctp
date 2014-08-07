<?php
	header('Content-type: text/html; charset=UTF-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" class="<?php echo $enabled_options; ?>">
	<head>
		<title>
			Zombie Nightclub Hoedown
		</title>
		<meta name="description" content="Punch zombie faces! Drink beer! Save the nightclub from a zombie infestation!" />
		<meta name="keywords" content="zombie nightclub hoedown doc's music hall muncie indiana graham phantom watson facepunching hullabaloo" />
		<meta name="language" content="en" />
		<link href="/img/favicon.ico" rel="icon" type="image/x-icon" />
		<link rel="stylesheet" type="text/css" href="/css/main.css" />
		<link href="http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:extralight,light,regular,bold" rel="stylesheet" type="text/css" />
		<link href="http://fonts.googleapis.com/css?family=Walter+Turncoat" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=IM+Fell+DW+Pica+SC' rel='stylesheet' type='text/css' />
		<?php
			echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js');
			echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/scriptaculous/1.8.3/scriptaculous.js?load=effects');
		?>
		<script src="/js/effects.js.php" type="text/javascript"></script>
		<?php
			//echo $this->Html->script('effects.js');
			//echo $this->Html->script('effects.js.php');
			echo $scripts_for_layout;
			echo $this->Html->charset('utf-8');
		?>
	</head>
	<body id="site_body" class="<?php echo isset($drunk_text_class) ? $drunk_text_class : ''; ?>">
		<div id="header">
			<div class="inner">
				<div id="masthead">
					Zombie Nightclub Hoedown
				</div>
			</div>
		</div>

		<?php if (isset($debug_messages) && ! empty($debug_messages)): ?>
			<div>
				<ul>
					<?php foreach ($debug_messages as $dmsg): ?>
						<li><?php echo $dmsg; ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<div id="wrapper">
			<div id="wrapper_tilt" class="<?php echo isset($drunk_tilt_class) ? $drunk_tilt_class : ''; ?>">
				<div id="wrapper_scale">
					<div id="content">
						<?php echo $content_for_layout ?>
					</div>
					<?php if ($is_game_page): ?>
						<?php echo $this->element('sidebar'); ?>
					<?php endif; ?>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>

		<?php
			if (isset($js_start_wobblies) && $js_start_wobblies) {
				$this->Js->buffer("startWobblies($drunk_level);");
			}
			echo $this->Js->writeBuffer();
		?>

		<?php echo $this->Html->link(
			'Restart',
			'/restart',
			array('style' => 'position: fixed; bottom: 0; left: 0;'),
			'Are you sure you want to restart the game? All progress will be lost.'
		); ?>
		<br />

		<?php if (Configure::read('debug')): ?>
			<a href="#" onclick="$('debug').toggle()" style="position: fixed; bottom: 0; right: 0;">Debug data</a>
			<div id="debug" style="clear: both; display: none;">
				<hr />
				Debugging stuff:
				<div id="debug_readout">

					<div>
						<?php echo '$this->data: <pre>'.print_r($this->data, true).'</pre>'; ?>
					</div>
					<div>
						Gamestate (cookie):
						<?php echo '<pre>'.print_r($gamestate, true).'</pre>'; ?>
						<br />Serialized:
						<?php echo serialize($gamestate); ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</body>
</html>