<script type="text/javascript">
	function runDrunkTilt_test(level) {
		var delay = 500 + (Math.random() * 8000);
		setTimeout('switchDrunkTilt_test(' + level +')', delay);
	}
	
	function switchDrunkTilt_test(level) {
		var wrapper = $('drunk_test_' + level);
		var class_a = 'drunk_tilt_' + level + 'a';
		var class_b = 'drunk_tilt_' + level + 'b';
		if (wrapper.hasClassName(class_a)) {
			wrapper.removeClassName(class_a);
			wrapper.addClassName(class_b);
		} else {
			wrapper.removeClassName(class_b);
			wrapper.addClassName(class_a);
		}
		var delay = 500 + (Math.random() * 8000);
		setTimeout('switchDrunkTilt_test(' + level + ')', delay);
	}
</script>
<style>
.drunk_test {
	transition: transform 3s;
	-moz-transition: -moz-transform 3s;
	-webkit-transition: -webkit-transform 3s;
	-o-transition: -o-transform 3s;
}
</style>
<?php for ($n = 0; $n <= 10; $n++): ?>
	<?php
		if (isset($drunk_level) && $drunk_level > 3) {
			$drunk_tilt_class = "drunk_tilt_$drunk_level".(rand(0,1) ? 'a' : 'b');	
		} else {
			$drunk_tilt_class = null;
		}
	?>
	<h1>Drunk Level <?php echo $n; ?></h1>
	<p class="drunk_test drunk_text_<?php echo $n; ?> <?php echo $drunk_tilt_class; ?>" id="drunk_test_<?php echo $n; ?>">
		Fusce nec massa nunc, sed varius nisi. Fusce mollis mauris nec velit interdum ultrices. Nunc cursus feugiat tincidunt. Curabitur sit amet nisl sed ante mattis posuere. Cras lorem augue; ultrices porttitor dignissim varius, consequat vitae dui. Suspendisse quis nibh libero. Nullam hendrerit augue quis leo dapibus interdum. Donec augue massa, lobortis a tincidunt a, aliquet eget nisi? Sed vel dignissim urna. Sed vulputate; urna faucibus tincidunt mollis, velit elit elementum felis, eget commodo metus lectus nec leo. Sed euismod metus ac magna convallis ac auctor libero fermentum. Quisque rutrum dignissim erat, a scelerisque lacus euismod eget. Sed auctor risus vel sapien hendrerit varius.
	</p>
	<hr style="margin-bottom: 300px;" />
	<?php if ($n > 3): ?>
		<script type="text/javascript">
			runDrunkTilt_test(<?php echo $n; ?>);
		</script>
	<?php endif; ?>
<?php endfor; ?>

<div style="height: 500px;"></div>