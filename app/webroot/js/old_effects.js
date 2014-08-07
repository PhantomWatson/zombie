function startWobblies(level) {
	$('wobblies_disable_button').show();
	$('wobblies_enable_button').hide();
	
	var delay = 500 + (Math.random() * 5000);
	setTimeout('switchDrunkTilt(' + level +')', delay);
	
	var delay = 500 + (Math.random() * 3000);
	setTimeout('switchDrunkScale(' + level + ')', delay);
	
	setGamestateValue('enable_wobblies', 1);
}

function stopWobblies() {
	$('wobblies_disable_button').hide();
	$('wobblies_enable_button').show();
	
	// Clear tilt
	if (window.wobblies_tilt) {
		clearTimeout(window.wobblies_tilt);
	}
	$('wrapper_tilt').className = 'stop_wobblies';
	
	// Clear scale
	if (window.wobblies_scale) {
		clearTimeout(window.wobblies_scale);
	}
	$('wrapper_scale').className = 'stop_wobblies';
	
	setGamestateValue('enable_wobblies', 0);
}

function setGamestateValue(varname, value) {
	var url = '/set/'+varname+'/'+value;
	new Ajax.Request(url, {
		method: 'get',
		onSuccess: function(transport) {
			if (transport.responseText == '1') {
				alert('set!');
				return true;
			} else {
				alert("FUCK!\n"+transport.responseText);
				return false;
			}
		}
	});
}

function switchDrunkTilt(level) {
	var wrapper = $('wrapper_tilt');
	var class_a = 'drunk_tilt_' + level + 'a';
	var class_b = 'drunk_tilt_' + level + 'b';
	if (wrapper.hasClassName(class_a)) {
		wrapper.removeClassName(class_a);
		wrapper.addClassName(class_b);
	} else {
		wrapper.removeClassName(class_b);
		wrapper.addClassName(class_a);
	}
	var delay = 8000 + (Math.random() * 5000);
	window.wobblies_tilt = setTimeout('switchDrunkTilt(' + level + ')', delay);
}

function switchDrunkScale(level) {
	var wrapper = $('wrapper_scale');
	
	var max_scale_level = Math.floor(level / 2) - 1;
	var scale_level = randomFromTo(0, max_scale_level); 
	var negative = (Math.random() < .5);
	var new_class = 'drunk_scale_';
	if (negative && scale_level > 0) {
		new_class += 'n';
	}
	new_class += scale_level;
	wrapper.className = new_class;
	var delay = 5000 + (Math.random() * 8000);
	window.wobblies_scale = setTimeout('switchDrunkScale(' + level + ')', delay);
}


/* Abandoned idea
function runDynamicDrunkTextShadow() {
	var body = $('site_body'); 
	var shadow_style_value = body.getStyle('text-shadow');
	var shadow_parts = shadow_style_value.split(' ');
	// for each shadow, get the blur radius
	// at each interval, change the blur radius to a value between a minimum and the original radius
	
	//rgb(255, 255, 255) 2px 2px 21.6px, rgb(167, 223, 153) 10px -10px 2.4px, rgb(167, 223, 153) -20px -100px 12px
	
	//alert(dump(shadows));
	// Iterate through radii
	for (var i = 5, l = shadow_parts.length; i < l; i = i + 6) {
		var radius = shadow_parts[i];
		radius = radius.match(/\d+/);
		var last = i == shadow_parts.length - 1;
		shadow_parts[i] = 1 + 'px';
		if (! last) {
			shadow_parts[i] += ',';
		}
	}
	var new_style_value = shadow_parts.join(' ');
	body.setStyle({
		textShadow: new_style_value
	});
}
*/

function showDrinkPanel() {
	Effect.SlideUp('order_a_drink', {
		duration: 0.5,
		afterFinish: function() {
			Effect.SlideDown('drinks', {
				duration: 0.5
			});
		}
	});
}

function toggleOptions() {
	Effect.toggle('options_inner', 'slide', {
		duration: 0.5,
		queue: {limit: 1, scope: 'options'}
	});
}

function showCombatPart2(player_health_before, player_health_after, player_max_health, player_health_msg_before, player_health_msg_after) {
	// Hide button
	$('combat_next_button_wrapper').hide();
			
	// Fade first part out
	new Effect.Fade('combat_part_1', {
		duration: 0.3,
		afterFinish: function() {
			// Indicate damage taken
			if (player_health_before != player_health_after) {
				indicateDamageTaken();
				adjustPlayerHealthDisplay(player_health_after, player_max_health, player_health_msg_before, player_health_msg_after);
			}
			Effect.Appear('combat_part_2', {
				duration: 1
			});
		}
	});
	return false;
}

function indicateDamageTaken() {
	var body = $('site_body');
	var normal_bg_color = body.getStyle('backgroundColor');
	body.setStyle({
		backgroundImage: "url('/img/ow_bg.png')"
	});
	new Effect.Morph(body, {
		queue: {position: 'end', limit: 1, scope: 'ow'},
		style: 'background:#f00;',
		duration: 0.1,
		delay: 0,
		afterFinish: function () {
			new Effect.Morph(body, {
				queue: {position: 'end', limit: 1, scope: 'ow'},
				style: 'background:' + normal_bg_color + ';',
				duration: 0.5,
				afterFinish: function() {
					body.setStyle({
						backgroundImage: "none"
					});
				}
			});
		}
	});
}

function adjustPlayerHealthDisplay(health_remaining, max_health, msg_before, msg_after) {
	// Update numbers
	$('player_health_remaining').update(health_remaining);
	
	// Adjust health bar
	var player_health_bar = $('player_health_bar');
	player_health_bar.setStyle({background: '#f00'});
	var new_width = Math.round((health_remaining / max_health) * 100) + '%';
	new Effect.Morph(player_health_bar, {
		style: 'background:#fff; width:' + new_width + ';',
		duration: 1,
		transition: Effect.Transitions.sinoidal
	});
	
	// Fade border to red and back
	var player_health = $('player_health');
	var border_color = player_health.getStyle('border-left-color');
	player_health.setStyle({
		borderColor: '#f00'
	});
	new Effect.Morph(player_health, {
		style: 'border: ' + border_color + ';',
		duration: 1,
		transition: Effect.Transitions.sinoidal
	});
	
	// Change message
	if (msg_before != msg_after) {
		var msg_wrapper = player_health.down('.message_wrapper');
		var msg = player_health.down('.message');
		msg_wrapper.setStyle({height: msg.getHeight() +'px'});
		new Effect.Morph(msg, {
			style: 'opacity:0;',
			duration: 1,
			afterFinish: function() {
				msg.update(stripslashes(msg_after));
				msg_wrapper.setStyle({height: msg.getHeight() +'px'});
				new Effect.Morph(msg, {
					style: 'opacity:1;',
					duration: 1
				});
			}
		});
	}
}

function adjustZombieHealthDisplay(health_remaining, max_health, msg_before, msg_after) {
	// Update numbers
	$('zombie_health_remaining').update(health_remaining);
	
	// Adjust health bar
	var zombie_health_bar = $('zombie_health_bar');
	zombie_health_bar.setStyle({background: '#f00'});
	var new_width = Math.round((health_remaining / max_health) * 100) + '%';
	new Effect.Morph(zombie_health_bar, {
		style: 'background:#fff; width:' + new_width + ';',
		duration: 1,
		transition: Effect.Transitions.sinoidal
	});
	
	// Fade border to red and back
	var zombie_health = $('zombie_health');
	var border_color = zombie_health.getStyle('border-left-color');
	zombie_health.setStyle({
		borderColor: '#f00'
	});
	new Effect.Morph(zombie_health, {
		style: 'border: ' + border_color + ';',
		duration: 1,
		transition: Effect.Transitions.sinoidal
	});
	
	// Change message
	if (msg_before != msg_after) {
		var msg_wrapper = zombie_health.down('.message_wrapper');
		var msg = zombie_health.down('.message');
		msg_wrapper.setStyle({height: msg.getHeight() +'px'});
		new Effect.Morph(msg, {
			style: 'opacity:0;',
			duration: 1,
			afterFinish: function() {
				msg.update(stripslashes(msg_after));
				msg_wrapper.setStyle({height: msg.getHeight() +'px'});
				new Effect.Morph(msg, {
					style: 'opacity:1;',
					duration: 1
				});
			}
		});
	}
}

function updateBacDescriptor(i) {
	i++;
	if (i >= bac_descriptors.length) {
		i = 0;
	}
	var bac_descriptor_wrapper = $('bac_descriptor_wrapper');
	var bac_descriptor = $('bac_descriptor');
	// Set explicit height
	bac_descriptor_wrapper.setStyle({height: bac_descriptor.getHeight() + 'px'});
	
	var bac_descriptor = $('bac_descriptor');
	new Effect.Morph(bac_descriptor, {
		style: 'opacity:0;',
		duration: 0.5,
		afterFinish: function() {
			bac_descriptor.update(bac_descriptors[i]);
			new Effect.Morph(bac_descriptor_wrapper, {
				style: 'height: ' + bac_descriptor.getHeight() + 'px',
				duration: 0.5,
				afterFinish: function() {
					new Effect.Morph(bac_descriptor, {
						style: 'opacity:1;',
						duration: 0.5
					});
				}
			});
		}
	});
	window.setTimeout(function(){updateBacDescriptor(i)}, 8000);
}

function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;

	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";

	if(typeof(arr) == 'object') { //Array/Hashes/Objects
		for(var item in arr) {
			var value = arr[item];
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}

function randomFromTo(from, to) {
	return Math.floor(Math.random() * (to - from + 1) + from);
}

function stripslashes(str) {    
	return (str + '').replace(/\\(.?)/g, function (s, n1) {
        switch (n1) {
	        case '\\':
	            return '\\';
	        case '0':            return '\u0000';
	        case '':
	            return '';
	        default:
	            return n1;
        }
    });
}

function updateBAC(new_value, new_status) {
	var bac_value = $('bac_value');
	new Effect.Morph(bac_value, {
		style: 'opacity:0;',
		duration: 0.5,
		afterFinish: function() {
			bac_value.update(new_value);
			new Effect.Morph(bac_value, {
				style: 'opacity:1;',
				duration: 0.5
			});
		}
	});
	
	var bac_status = $('bac_status');
	new Effect.Morph(bac_status, {
		style: 'opacity:0;',
		duration: 0.5,
		afterFinish: function() {
		bac_status.update(new_status);
			new Effect.Morph(bac_status, {
				style: 'opacity:1;',
				duration: 0.5
			});
		}
	});
}