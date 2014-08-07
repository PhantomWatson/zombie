<?php
class Game extends AppModel {
	var $name = 'Game';

	function getState() {

	}

	function getDefaultGamestate() {
		$gamestate = array(
			// Zones, actions, etc.
			'auto_zone' => null,		// Used if page loaded without POST data
			'auto_action' => null,		// (same)
			'last_zone' => null,
			'last_action' => null,
			'zombie_health_msg' => null,
			'zombie_last_fought' => null,

			// Player attributes
			'player_max_health' => 20,
			'player_health' => 20,
			'player_health_msg' => null,
			'money' => 5,
			'bac' => 0,
			'burpies' => 0,
			'enable_wobblies' => 1,
			'enable_blurries' => 1,

			// Attacks learned
			'attack_punch' => true,
			'attack_kick' => false,
			'attack_twbmsw' => false,
			'attack_fireball' => false,

			// Bar spending
			'drank_shots' => 0,
			'drank_beers' => 0,
			'drank_coffees' => 0,
			'tipped' => 0,

			// Quest flags
			'q_started' => false,
			'q_first_combat_round' => true,
			'q_free_shot_taken' => false,
			'q_mensrr_stank_encountered' => false,
			'q_mop_closet_key' => false,
			'q_mop_closet_opened' => false,
			'q_derby_girls_released' => false,
			'q_backstage_too_dark' => false,
			'q_flashlight_found' => false,
			'q_air_freshener_found' => false,
			'q_air_freshener_used' => false,
			'q_tipjar_found' => false,
			'q_tipjar_given' => false,

			'q_mk_beaten' => false,
			'q_tables_searched' => false
		);

		// Debugging
		$gamestate['attack_kill'] = Configure::read('debug') != 0;
		if (Configure::read('debug')) {
			$gamestate['money'] = 100;
		}

		// Default states for all enemies
		$all_enemies = $this->getAllEnemies();
		foreach ($all_enemies as $e_name => $e_details) {
			$gamestate["looted_$e_name"] = false;
			$gamestate["zhealth_$e_name"] = $e_details['max_health'];
		}

		// Random silly starting inventory items (set keys)
		/*
		$random_keys = array_rand($this->getRandomInventoryItems(), 3);
		for ($n = 0; $n <= 2; $n++) {
			$gamestate["rand_inventory_$n"] = $random_keys[$n];
		}
		*/

		$gamestate['player_health_msg'] = $this->getHealthStatusMessage($gamestate);
		$gamestate['zombie_health_msg'] = $this->getZombieStatusMessage(1, 1);

		ksort($gamestate);
		return $gamestate;
	}

	function getRandomInventoryItems() {
		return array(
			'Ballpoint pen (out of ink)',
			'Pocket lint',
			'Condom <span class="sidenote">(past expiration date)</span>',
			"Old Blockbuster gift card with 17&cent; balance",
			'Chuck E. Cheese game token',
			'Handful of Pok&eacute;mon-themed Silly Bandz',
			'Handbill for a concert you don\'t plan on going to',
			'Empty Tic-Tac box',
			'Empty pack of Zig Zag rolling papers',
			'A paperclip',
			'Hello Kitty eraser',
			'Grenade pin',
			'Pack of glucose tablets'
		);
	}

	function getAllEnemies() {
		$enemy_names = array(
			'barfly',
			'soundbooth',
			'womensrr',
			'mensrr',
			'dancefloor',
			'wheelchair',
			'comedian',
			'derby',
			'hippie',
			'child'
		);
		$enemies = array_fill_keys($enemy_names, array());

		// Assign various details to each enemy
		foreach ($enemies as $e_name => &$e_details) {
			// Sex
			switch ($e_name) {
				case 'womensrr':
				case 'derby':
				case 'hippie':
				case 'child':
					$e_details['sex'] = 'f';
					break;
				default:
					$e_details['sex'] = 'm';
			}

			// Health
			switch ($e_name) {
				case 'derby':
					$e_details['max_health'] = 10;
					break;
				case 'mensrr':
				case 'womensrr':
				case 'comedian':
				case 'child':
					$e_details['max_health'] = 7;
					break;
				case 'soundbooth':
				case 'wheelchair':
				case 'hippie':
					$e_details['max_health'] = 6;
					break;
				case 'dancefloor':
					$e_details['max_health'] = 5;
					break;
				case 'barfly':
					$e_details['max_health'] = 3;
					break;
				default:
					$e_details['max_health'] = 5;
					break;
			}

			// Loot button value
			switch ($e_name) {
				case 'womensrr':
				case 'hippie':
					$e_details['loot_button_value'] = "Rifle through her purse";
					break;
				case 'wheelchair':
					$e_details['loot_button_value'] = "Rifle through his backpack";
					break;
				case 'child':
					$e_details['loot_button_value'] = "Go backstage and grab the air freshener";
					break;
				default:
					$his = $e_details['sex'] == 'm' ? 'his' : 'her';
					$e_details['loot_button_value'] = "Rifle through $his pockets";
			}
		}

		return $enemies;
	}

	function getEnemyDetails($enemy) {
		$enemies = $this->getAllEnemies();
		return isset($enemies[$enemy]) ? $enemies[$enemy] : false;
	}

	function getAttacks($gamestate, $all = false) {
		$attacks = array(
			'punch' => array(
				'label' => 'Punch',
				'damage' => 1,
				'chance' => 95		// Average damage: 1
			),
			'kick' => array(
				'label' => 'Kick',
				'damage' => 2,
				'chance' => 75		// Average damage: 1.5
			),
			'twbmsw' => array(
				'label' => 'TWBMSW', //Two-Wheeler Backwards Midnight Shin-Whack
				'damage' => 5,
				'chance' => null
			),
			'fireball' => array(
				'label' => 'Fireball',
				'damage' => 10,
				'chance' => 25		// Average damage: 2.5
			),
			'kill' => array(
				'label' => 'Kill',
				'damage' => 1000,
				'chance' => 100		// Average damage: A bajillion
			)
		);

		// TWBMSW chance is 100% @ .125, 92.5% @ 0.15, 77.5% @ 0.2, 62.5% @ 0.25, 17.5% @ .4, and 0% if >= 0.4583
		$attacks['twbmsw']['chance'] = ($gamestate['bac'] < 0.125) ? 0 : max(0, (100 - ($gamestate['bac'] - 0.125) * 300));

		if ($all) {
			return $attacks;
		}
		$available_attacks = array();
		foreach ($attacks as $a_name => $a_details) {
			if ($gamestate["attack_$a_name"]) {
				$available_attacks[$a_name] = $a_details;
			}
		}
		return $available_attacks;
	}

	function getCombatIntro($enemy) {
		return array(
			'pic' => $this->getCombatIntroPic($enemy),
			'message' => $this->getCombatIntroMessage($enemy)
		);
	}

	function getCombatIntroMessage($enemy) {
		switch ($enemy) {
			case 'barfly':
				return "This creepy barfly lurked at the bar bothering everyone around him when he was alive. Now he's a zombie and... well, not much has changed. Time to punch this mofo out and save the day.";
			case 'soundbooth':
				return "Zombies don't go in soundbooths! Their decomposing eardrums make them mix the music all wrong!";
			case 'dancefloor':
				return "Too bad rigor mortis makes it impossible for the dead to dance, unless the Harlem Shake counts. Turns out Michael Jackson was a goddamn liar. Regardless, you know that if your mother were here, she would encourage you to render this zombie unconscious.";
			case 'womensrr':
				return "The zombie lets out a moan and lunges at you with a combination of hunger for the flesh of the living and outrage that you just totally walked in on her when she was on the can. You hear the dooooor slam and realize there's nowhere left to run.";
			case 'mensrr':
				return "You spot the tip jar in the corner of the room. Unfortunately, this zombie is between you and it. You had this strange feeling when you woke up this morning that at some point today, you would end up getting physical with a strange dude in a restroom for money.";
			case 'wheelchair':
				return "On your quest to rid the nightclub of zombies, you have committed to being an equal-opportunity face-puncher. And you're ready, willing, and handi-capable of de-animating this motorized menace for the public good. If you had absolutely no taste at all, you'd quip something like, <q>Looks like this crip's out for blood!</q> Fortunately, you have the good sense to never make that joke. Ever.";
			case 'comedian':
				return "What's the deal with zombie comedians? <em>Who <strong>are</strong> these undead people?</em>";
			case 'derby':
				return "Damn, that derby damsel is in distress! Don't dally; deftly deck this dead dame in the dome, or be disemboweled and devoured!";
			case 'hippie':
				return "Oh no, a zombie hippie! A... a zippie! Time to send this pinhead back to Dingburg!";
			case 'child':
				return "Your dream has finally come true! You have to beat up a small child! Wait, no. I meant <em>nightmare.</em>";
			default:
				return "Zombie! Kill it!";
		}
	}

	function getCombatIntroPic($enemy) {
		return 'placeholder.jpg';
	}

	function getPlayerAttackPic($enemy, $attack, $success) {
		// $attack is simplified attack name, $success is 1 or 0, $n is 1-3 variations
		// Idea for filenames: $enemy_$attack_$success_$n.jpg
		return 'placeholder.jpg';
	}

	function getPlayerVomitPic($enemy) {
		return 'placeholder.jpg';
	}

	function getPlayerVomitMessage($attack, $him) {
		switch ($attack) {
			case 'Punch':
				$msg = "You cock your fist back, ready to pound $him in the face, then abruptly vomit.";
				break;
			case 'Kick':
				$msg = "You raise your foot to kick $him, then immediately set it back down and puke your guts out.";
				break;
			default:
				$msg = "Just as you're about to attack, you abruptly vomit.";
				break;
		}
		$msg .= ' You immediately feel better and a bit more sober.';
		return $msg;
	}

	function getZombieAttackPic($enemy, $attack, $success) {
		// Idea for filenames: $enemy_$attack_$n.jpg ($n for 1-3 variations)
		return 'placeholder.jpg';
	}

	function getZombieDeathMessage($enemy) {
		switch ($enemy) {
			case 'barfly':
				return "Defeated, the zombie slumps over the bar, knocks over a tip jar, two glasses, and somehow four barstools, and finally falls to the floor, dead. Well, more dead than he was before. Let's just get used to calling zombies that you finish beating up \"dead\" and not think about it too much.";
			case 'soundbooth':
				return "Thoroughly trounced, the zombie resigns himself to corpsehood.";
			case 'dancefloor':
				return "Defeated, the zombie falls down face-first. Stiffened by rigor mortis, he does the worm a few times before collapsing. And not very well. Like, you know how professional breakdancers do the worm? Yeah, not like that. You know how awkward teenage guys do the worm at the prom because they think it'll get them laid? Like that, but with necrotized flesh.";
			case 'womensrr':
				return "The zombie collapses to the floor. Her purse spills over and a disgusting collection of human fingers, ears, and scraps of flesh fall out of it. Women's purses be full of weird stuff, amirite guys?";
			case 'mensrr':
				return "Edgar Allan Poe once said, <q>The boundaries which divide life from death are at best shadowy and vague. Who shall say where the one ends, and where the other begins?</q> On the floor of the Doc's Music Hall men's room, turns out.";
			case 'wheelchair':
				return "Defeated, the zombie slumps over in his ch- ... </p><p>Wait a sec...</p><p>Okay, yeah, he's dead.</p><p>You unplug the battery in his chair, just in case.";
			case 'comedian':
				return "Man, that zombie comedian totally <em>died</em> on stage!</p><p>...</p><p>Um... Because you killed him.</p><p>Yeah...";
			case 'hippie':
				return "From the earth you came, and to the earth you shall return, patchouli-drenched child of Gaia.";
			case 'child':
				return "Ugh. That was awful. You'd make a <em>terrible</em> babysitter. But maybe a decent British nanny.";
			default:
				return "The zombie falls down, finally rendered un-un-dead. Er- wait. That would mean alive, wouldn't it? Then it's un-un-un-... Let's just say it's done being a pain in the ass for tonight.";
		}
	}

	function getZombieDeathPic($enemy) {
		return 'placeholder.jpg';
	}

	function getLoot($enemy) {
		$loot = array();
		switch ($enemy) {
			case 'barfly':
				$loot['money'] = 0.25;
				$loot['message'] = 'You rifle through the zombie\'s pockets and find <span class="loot">a quarter</span>. Hooray?';
				break;
			case 'womensrr':
				$money = rand(100, 300) / 100; // Average: $1.25
				$loot['money'] = $money;
				$loot['message'] = 'You rifle through the zombie\'s blood-spattered purse and find <span class="loot">'.$this->money_format($money).'</span>.';
				break;
			case 'wheelchair':
				$money = rand(150, 350) / 100; // Average: $1.75
				$loot['money'] = $money;
				$loot['message'] = 'You look in the backpack on the back of the zombie\'s motorized wheelchair and find <span class="loot">'.$this->money_format($money).'</span> and a <span class="loot">human head</span>.</p><p><q>So, did some other zombie tear off the head and put it in his backpack, or did someone get decapitated while looking into the backpack?</q> you ask yourself. You try not to think about it too much.';
				break;
			case 'hippie':
				$loot['money'] = 0;
				$loot['message'] = 'You search through her purse and find a baggie full of organic granola and a set of all-natural tampons made out of dreadlocks, but naturally no money.';
				break;
			case 'comedian':
				$money = rand(25, 225) / 100; // Average: $1.25
				$loot['money'] = $money;
				$loot['message'] = 'You rifle through the zombie\'s pockets and find <span class="loot">'.$this->money_format($money).'</span> in loose change, an empty condom wrapper, and a matchbook from an hourly-rate hotel.';
				break;
			case 'soundbooth':
			case 'dancefloor':
			case 'mensrr':
			case 'comedian':
			case 'derby':
			default:
				$money = rand(25, 225) / 100; // Average: $1.25
				$loot['money'] = $money;
				$loot['message'] = 'You rifle through the zombie\'s pockets and find <span class="loot">'.$this->money_format($money).'</span> in loose change.';
		}
		return $loot;
	}

	function money_format($amount) {
		return '$'.number_format($amount, 2);
	}

	// $gs is gamestate
	function getInventory($gs) {
		// Money
		$inventory = array($this->money_format($gs['money']));

		// Acquired items
		if ($gs['q_air_freshener_found'] && ! $gs['q_air_freshener_used']) {
			$inventory[] = 'Can of air freshener';
		}
		if ($gs['q_tipjar_found'] && ! $gs['q_tipjar_given']) {
			$inventory[] = 'Stolen tip jar';
		}
		if ($gs['looted_wheelchair']) {
			$inventory[] = 'Severed head <span class="sidenote">(you sick fuck)</span>';
		}
		if ($gs['looted_derby']) {
			$inventory[] = 'Roller derby helmet';
		}
		if ($gs['q_mop_closet_key']) {
			$inventory[] = 'Mop closet key';
		}
		if ($gs['q_flashlight_found']) {
			$inventory[] = 'Flashlight';
		}

		// Random silly starting inventory items
		/*
		$rand_items = $this->getRandomInventoryItems();
		for ($n = 0; $n <= 2; $n++) {
			$key = $gs["rand_inventory_$n"];
			$inventory[] = $rand_items[$key];
		}
		*/

		// Burpies
		if ($gs['burpies']) {
			$inventory[] = 'A very queasy stomach';
		}

		return $inventory;
	}

	// $gs is gamestate
	function getHealthStatusMessage($gs) {
		$percent = $gs['player_health'] / $gs['player_max_health'];
		if ($percent == 1) {
			return 'Healthy';
		} elseif ($percent > 0.75) {
			$msgs = array('Roughed up', 'Ruffled', 'Perturbed', 'Scuffed', 'Slightly injured');
		} elseif ($percent > 0.5) {
			$msgs = array('Injured', 'Banged up', 'Battered', "Hurtin'", 'Wounded', 'Seen better days');
		} elseif ($percent > 0.25) {
			$msgs = array("Hurtin' bad", 'Mangled', 'Wrecked', 'Effed up', 'Quite wounded', 'Really bashed up');
		} elseif ($percent > 0) {
			$msgs = array('Leaking major organs', 'Bleedin\' out', 'At death\'s door', 'Mostly dead', 'Hope you have insurance', 'One foot in the grave');
		} else {
			return 'Dead';
		}
		return array_rand(array_flip($msgs));
	}

	// $gs is gamestate
	function getZombieStatusMessage($z_health, $z_max_health) {
		$percent = $z_health / $z_max_health;
		if ($percent == 1) {
			$msgs = array('Hungry', 'Ravenous', 'Shambling', 'Decaying', 'Lumbering', 'Rotting', 'Looking pretty decent, for a zombie');
		} elseif ($percent > 0.25) {
			$msgs = array('Angry', 'Enraged', 'Murderous', 'Pissed off', 'Furious', 'Quite upset with you', 'Now justifiably antagonistic');
		} elseif ($percent > 0) {
			$msgs = array('Beaten up', 'Struggling', 'Leaking major organs', 'Almost finished', 'On the ropes', 'Tenderized', 'Weakened');
		} else {
			$msgs = array('Conquered', 'Defeated', 'Put down', 'Extra-deadified', 'Trounced', 'Laid to rest');
		}
		return array_rand(array_flip($msgs));
	}

	function getBacDescriptors($bac) {
		if ($bac < 0.03) {							// 1
			$msgs = array();
		} elseif ($bac >= 0.03 && $bac < 0.055) {	// 4
			$msgs = array('Slight euphoria', 'Mildly relaxed', 'Good to drive', 'Slightly better at beer pong');
		} elseif ($bac >= 0.055 && $bac < 0.08) {	// 3
			$msgs = array('Relaxed', 'Lowered inhibitions', 'Euphoric');
		} elseif ($bac >= 0.08 && $bac < 0.125) {	// 3
			$msgs = array('Slightly impaired reflexes', 'Slightly slurred speech', 'Impaired judgement');
		} elseif ($bac >= 0.125 && $bac < 0.16) {	// 5
			$msgs = array('Significantly impaired coordination', 'Slurred speech', 'Poor reaction time', 'Sluggish', 'Drunk dialing exes');
		} elseif ($bac >= 0.16 && $bac < 0.20) {	// 4
			$msgs = array('Very impaired motor control', 'Blurred vision', 'Dysphoria', 'Severely impaired judgment');
		} elseif ($bac >= 0.20 && $bac < 0.24) {	// 4
			$msgs = array('Nauseous. Or nauseated. I forget which.', 'Sloppy drunk', 'Plastered', 'You think you\'re great at karaoke');
		} elseif ($bac >= 0.24 && $bac < 0.29) {	// 6
			$msgs = array('Disoriented', 'Blacking out', 'Confused', 'Vomiting', 'Pissing on cop cars', '"Daredevil drunk"');
		} elseif ($bac >= 0.29 && $bac < 0.34) {	// 3
			$msgs = array('Nonfunctional', 'Would sleep with Henry Kissinger', 'Insert Charlie Sheen reference here');
		} elseif ($bac >= 0.34 && $bac < 0.39) {	// 6
			$msgs = array('Passing out', 'Oblivious', 'Nearly comatose', 'Impaired bladder control', 'Labored breathing', 'Don\'t fall asleep with your shoes on');
		} else {	// 3
			$msgs = array('Slipping into a coma', 'Onset of alcohol poisoning', 'They\'re going to make a PSA about you.');
		}
		shuffle($msgs);
		return $msgs;
	}

	function getBacStatusMessage($bac) {
		if ($bac < 0.03) {
			$msgs = array('Sober');
		} elseif ($bac >= 0.03 && $bac < 0.055) {
			$msgs = array('A little buzzed');
		} elseif ($bac >= 0.055 && $bac < 0.08) {
			$msgs = array('Buzzed');
		} elseif ($bac >= 0.08 && $bac < 0.125) {
			$msgs = array('A little tipsy', 'Slightly drunk');
		} elseif ($bac >= 0.125 && $bac < 0.16) {
			$msgs = array('Drunk', 'Inebriated', 'Intoxicated');
		} elseif ($bac >= 0.16 && $bac < 0.20) {
			$msgs = array('Really drunk', 'Soused', 'Ripped', 'Sloshed');
		} elseif ($bac >= 0.20 && $bac < 0.24) {
			$msgs = array('Really, really drunk', 'Wasted', 'Hammered', 'Trashed');
		} elseif ($bac >= 0.24 && $bac < 0.29) {
			$msgs = array('Blackout drunk', 'Plastered', 'Obliterated');
		} elseif ($bac >= 0.29 && $bac < 0.34) {
			$msgs = array('Totally ripped');
		} elseif ($bac >= 0.34 && $bac < 0.39) {
			$msgs = array('Drunk as fuck');
		} else {
			$msgs = array('Absolutely wrecked');
		}
		return array_rand(array_flip($msgs));
	}

	// Used to choose the correct "drunk_text_n" CSS class
	function getDrunkLevel($bac) {
		if ($bac < 0.03) {
			return 0;
		} elseif ($bac < 0.06) {
			return 1;
		} elseif ($bac < 0.09) {
			return 2;
		} elseif ($bac < 0.125) {
			return 3;
		} elseif ($bac < 0.16) {
			return 4;
		} elseif ($bac < 0.20) {
			return 5;
		} elseif ($bac < 0.24) {
			return 6;
		} elseif ($bac < 0.29) {
			return 7;
		} elseif ($bac < 0.34) {
			return 8;
		} elseif ($bac < 0.40) {
			return 9;
		} else {
			return 10;
		}
	}

	function combatSpecialZBlock($enemy, $attack, $gamestate) {
		if ($enemy == 'derby') {
			// Chance of roller derby zombie blocking with her helmet is 40% * percentage of player health left
			$chance_of_block = 45 * ($gamestate['player_health'] / $gamestate['player_max_health']);
			if (! rand(1, 100) <= $chance_of_block) {
				return false;
			}
			switch ($attack) {
				case 'punch':
					$message = rand(0, 1)
						? 'You swing your fist around to clock her in the head, but you only connect with her helmet, bruising your knuckles.'
						: 'You try to punch her, but she ducks just in time to absorb the blow with her helmet.';
					$pic = 'placeholder.jpg';
					break;
				case 'kick':
					$message = rand(0, 1)
						? 'You try to kick her in the head, but she ducks just in time and your foot only skids off of her helmet.'
						: 'You attempt to kick her, but she does this half-dodging, half-flailing, half-stumbling maneuver and intercepts your kick with her helmet.';
					$pic = 'placeholder.jpg';
					break;
			}
			$message .= rand(0, 1)
				? 'As if things weren\'t bad enough without the zombies wearing <em>armor!</em>'
				: '<q>Hey, wearing protective gear is totally cheating!</q> you inform her.';
			return array(
				'damage' => 0,
				'message' => $message,
				'zombie_killed_message' => false,
				'zombie_killed_pic' => false,
				'pic' => $pic
			);
		} else {
			return false;
		}
	}

	function combatVomit($gamestate, $attack, $enemy) {
		// Chance of vomiting equals 100% * BAC
		if ($gamestate['burpies'] && rand(1, 100) <= ($gamestate['bac'] * 100)) {
			$enemy_details = $this->getEnemyDetails($enemy);
			$him = $enemy_details['sex'] == 'm' ? 'him' : 'her';
			return array(
				'damage' => 0,
				'message' => $this->getPlayerVomitMessage($attack, $him),
				'zombie_killed_message' => false,
				'zombie_killed_pic' => false,
				'pic' => $this->getPlayerVomitPic($enemy)
			);
		}
		return false;
	}

	function combatInterception($enemy, $attack, $gamestate) {
		if ($enemy == 'derby') {
			$attacks = $this->getAttacks($gamestate, true);
			$shinwhack_damage = $attacks['twbmsw']['damage'];
			if ($gamestate["zhealth_$enemy"] <= $shinwhack_damage) {
				return array(
					'damage' => $shinwhack_damage,
					'message' =>
						"Just as you're about to attack her, the other derby girl suddenly cartwheels in,
						twirls around upside-down, screams <q>HI-KEEBA!</q> and kicks the zombie's legs
						out from under her with a thunderous <span class=\"damage_dealt\">CRACK</span>.
						You watch in astonishment as the zombie's helmet pops off, she does a full flip
						in the air, and she lands hard on her head with a jarring
						<span class=\"damage_dealt\">THUD</span>. Hooray for onomatopoeia!",
					'zombie_killed_message' =>
						"The zombie's limp body crumples into a pile on the dancefloor.",
					'zombie_killed_pic' => 'placeholder.jpg',
					'pic' => 'placeholder.jpg'
				);
			}
		}
		return false;
	}
}
?>