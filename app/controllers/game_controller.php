<?php
class GameController extends AppController {

	var $name = 'Game';
	var $uses = array('Game', 'Zone');
	var $debug = false;
	var $debug_messages = array();
	var $gamestate = array();
	var $hide_health = false;
	var $hide_inventory = false;
	var $zone = null;
	var $action = null;
	var $encrypt_cookie = false;
	var $is_game_page = false; // true if game is being played, false if on an info page

	function beforeFilter() {
		parent::beforeFilter();

		// Get gamestate
		$default_gamestate = $this->Game->getDefaultGamestate();
		$this->gamestate = $this->getGamestate();

		//$this->debug_messages[] = '$default_gamestate = <pre>'.print_r($default_gamestate, true).'</pre>';
		//$this->debug_messages[] = '$this->gamestate = <pre>'.print_r($this->gamestate, true).'</pre>';

		// Start new game if gamestate not found in cookie
		if (! is_array($this->gamestate)) {
			$this->debug_messages[] = 'New game starting; $this->Cookie->read(\'gamestate\') evaluated to false.';
			$this->gamestate = $default_gamestate;
			$this->saveGamestate();
		}

		// Fill in missing values with defaults
		$this->gamestate = array_merge($default_gamestate, $this->gamestate);

		// Entire gamestate override (Uncomment to override entire gamestate)
		$serialized_gamestate = 'a:58:{s:15:"attack_fireball";s:0:"";s:11:"attack_kick";s:1:"1";s:11:"attack_kill";s:1:"1";s:12:"attack_punch";s:1:"1";s:13:"attack_twbmsw";s:1:"1";s:11:"auto_action";N;s:9:"auto_zone";s:9:"backstage";s:3:"bac";s:4:"0.03";s:7:"burpies";s:1:"0";s:11:"drank_beers";s:1:"0";s:13:"drank_coffees";s:1:"0";s:11:"drank_shots";s:1:"1";s:15:"enable_blurries";s:1:"1";s:15:"enable_wobblies";s:1:"1";s:11:"last_action";N;s:9:"last_zone";s:9:"backstage";s:13:"looted_barfly";s:0:"";s:12:"looted_child";s:0:"";s:15:"looted_comedian";s:0:"";s:17:"looted_dancefloor";s:0:"";s:12:"looted_derby";s:1:"1";s:13:"looted_hippie";s:1:"1";s:13:"looted_mensrr";s:0:"";s:17:"looted_soundbooth";s:1:"1";s:17:"looted_wheelchair";s:0:"";s:15:"looted_womensrr";s:0:"";s:5:"money";s:3:"103";s:13:"player_health";s:2:"20";s:17:"player_health_msg";s:7:"Healthy";s:17:"player_max_health";s:2:"20";s:21:"q_air_freshener_found";s:0:"";s:20:"q_air_freshener_used";s:0:"";s:20:"q_backstage_too_dark";s:1:"1";s:22:"q_derby_girls_released";s:1:"1";s:20:"q_first_combat_round";s:0:"";s:18:"q_flashlight_found";s:1:"1";s:17:"q_free_shot_taken";s:1:"1";s:26:"q_mensrr_stank_encountered";s:1:"1";s:11:"q_mk_beaten";s:0:"";s:16:"q_mop_closet_key";s:1:"1";s:19:"q_mop_closet_opened";s:1:"1";s:9:"q_started";s:0:"";s:17:"q_tables_searched";s:0:"";s:14:"q_tipjar_found";s:0:"";s:14:"q_tipjar_given";s:0:"";s:6:"tipped";s:1:"0";s:14:"zhealth_barfly";s:1:"3";s:13:"zhealth_child";s:1:"7";s:16:"zhealth_comedian";s:1:"7";s:18:"zhealth_dancefloor";s:1:"5";s:13:"zhealth_derby";s:1:"0";s:14:"zhealth_hippie";s:1:"0";s:14:"zhealth_mensrr";s:1:"7";s:18:"zhealth_soundbooth";s:1:"0";s:18:"zhealth_wheelchair";s:1:"6";s:16:"zhealth_womensrr";s:1:"7";s:17:"zombie_health_msg";s:15:"Extra-deadified";s:18:"zombie_last_fought";s:10:"soundbooth";}';
		//$this->gamestate = unserialize($serialized_gamestate);
	}

	function beforeRender() {
		parent::beforeRender();

		// Update 'last zone' and 'last action'
		$this->gamestate['last_zone'] = $this->zone;
		$this->gamestate['last_action'] = $this->action;

		// Save gamestate to Cookie
		$this->saveGamestate();

		// Make $gamestate variable available in views
		$this->set('gamestate', $this->gamestate);

		// Display health info, inventory, and drunk messages / effects
		if ($this->is_game_page) {
			$this->set(array(
				'player_health_remaining' => $this->gamestate['player_health'],
				'player_max_health' => $this->gamestate['player_max_health'],
				'inventory' => $this->Game->getInventory($this->gamestate)
			));
			$this->setDrunkEffects();
		}

		// Inform the view of whether this is a game page (game being
		// played) or an info page (e.g. the front page)
		$this->set('is_game_page', $this->is_game_page);
		$this->setOptions();

		// Debug messages
		if (Configure::read('debug') && ! empty($this->debug_messages)) {
			$this->set('debug_messages', $this->debug_messages);
		}
	}

	function getGamestate() {
		$gamestate = array();
		if ($saved_gamestate = $this->Cookie->read('gamestate')) {
			foreach ($saved_gamestate as $var => $val) {
				$gamestate[$var] = urldecode($val);
			}
		}
		return $gamestate;
	}

	function restart() {
		$this->Cookie->destroy();
		$this->redirect('/');
	}

	function error() {
		echo 'error!';
	}

	function index() {
		$game_in_progress = null;
	}

	function play() {
		$this->is_game_page = true;
		if (isset($this->data)) {
			$this->zone = isset($this->data['Game']['zone']) ? $this->data['Game']['zone'] : null;
			$this->action = isset($this->data['Game']['action']) ? $this->data['Game']['action'] : null;

			// If the 'begin' button on the front page has been clicked
			// (this is likely needlessly complicated)
			if ($this->zone == 'begin') {
				if ($this->gamestate['q_started']) {
					$this->zone = $this->gamestate['auto_zone'];
					$this->action = $this->gamestate['auto_action'];
				} else {
					$this->gamestate['q_started'] = true;
					$this->zone = 'bar';
					$this->action = 'begin';
				}
			}

			$this->setAutoZone($this->zone, $this->action);
		} else {
			$this->zone = $this->gamestate['auto_zone'];
			$this->action = $this->gamestate['auto_action'];
		}

		if (method_exists($this, 'zone_'.$this->zone)) {
			$this->{'zone_'.$this->zone}();
		} else {
			$this->error();
		}
	}

	// Sets the $enabled_options variable, which is printed into the HTML tag's class attribute
	function setOptions() {
		$enabled_options = '';
		if ($this->gamestate['enable_blurries']) $enabled_options .= 'blurries_enabled ';
		if ($this->gamestate['enable_wobblies']) $enabled_options .= 'wobblies_enabled ';
		$this->set(compact('enabled_options'));
	}

	function setDrunkEffects() {
		$drunk_level = $this->Game->getDrunkLevel($this->gamestate['bac']);
		$this->set(array(
			'bac_status_msg' => $this->Game->getBacStatusMessage($this->gamestate['bac']),
			'bac_descriptors' => $this->Game->getBacDescriptors($this->gamestate['bac']),
			'drunk_level' => $drunk_level,
			'drunk_tilt_class' => $drunk_level > 3 ? "drunk_tilt_$drunk_level".(rand(0,1) ? 'a' : 'b') : null,
			'drunk_text_class' => 'drunk_text_'.$drunk_level,
			'js_start_wobblies' => $this->gamestate['enable_wobblies'] && $drunk_level > 3
		));
	}

	function setGamestateValue($var, $val) {
		if (isset($this->gamestate[$var])) {
			$this->gamestate[$var] = $val;
			$this->saveGamestate();
			$this->set('result', true);
		} else {
			$this->set('result', false);
		}
		$this->layout = 'ajax';
		$this->render('set_gs_value');
	}

	function saveGamestate() {
		$encoded_gamestate = array();
		foreach ($this->gamestate as $var => $val) {
			$encoded_gamestate[$var] = urlencode($val);
		}
		return $this->Cookie->write('gamestate', $encoded_gamestate, $this->encrypt_cookie);
	}

	function getBacDescriptors() {
		$this->Game->getBacDescriptors($this->gamestate['bac']);
	}

	function gotoZone($zone, $action = null) {
		$this->zone = $zone;
		$this->action = null;
		$this->setAutoZone($this->zone, $this->action);
		if (method_exists($this, 'zone_'.$this->zone)) {
			$this->{'zone_'.$this->zone}();
		} else {
			$this->error();
		}
	}

	// Sets zone and action automatically used in the next request if no POST data is sent
	// May be overrided later on
	function setAutoZone($zone, $action = null) {
		$this->gamestate['auto_zone'] = $zone;
		$this->gamestate['auto_action'] = $action;
	}

	function combat($enemy) {
		$player_health_before = $this->gamestate['player_health'];
		$player_health_msg_before = $this->gamestate['player_health_msg'];
		$zombie_health_before = $this->gamestate["zhealth_$enemy"];
		$enemy_details = $this->Game->getEnemyDetails($enemy);
		$attacks = $this->Game->getAttacks($this->gamestate);
		$attack = isset($this->data['Game']['attack']) ? $this->data['Game']['attack'] : null;
		$this->setNewCombatVariables($enemy);

		// If zombie is dead
		if ($zombie_health_before == 0) { // If zombie is already dead
			$this->set('zombie_already_dead_pic', $this->Game->getZombieDeathPic($enemy));

		// If player is attacking
		} elseif ($attack) {
			$player_attack_result = $this->getPlayerAttackResult($attack, $enemy, $enemy_details, $attacks);
			$this->set('player_attack_result', $player_attack_result);

			// Update zombie health message
			if ($player_attack_result['damage'] > 0) {
				$zombie_health_msg_before = $this->gamestate['zombie_health_msg'];
				$this->updateZombieHealthMessage($this->gamestate["zhealth_$enemy"], $enemy_details['max_health']);
				$zombie_health_msg_after = $this->gamestate['zombie_health_msg'];
				$this->set(compact('zombie_health_msg_before', 'zombie_health_msg_after'));
			}

			// If zombie is attacking
			if (! $player_attack_result['zombie_killed_message']) {
				$zombie_attack_result = $this->getZombieAttackResult($enemy, $enemy_details);
				if ($zombie_attack_result['damage'] > 0) {
					$this->updatePlayerHealthMessage();
				}
				$this->set('zombie_attack_result', $zombie_attack_result);
			}

		// If waiting for player to attack
		} else {
			$this->set('begin_combat', $this->Game->getCombatIntro($enemy));
		}

		/* $player_health_remaining (set in beforeRender) and $zombie_health_remaining
		 * initially set the displayed health values, but if the player has Javascript
		 * enabled, $(player or zombie)_health_(before or after) are used to produce
		 * the animation. */
		$this->set(array(
			'zone' => $this->zone,
			'attacks' => $attacks,
			'player_health_before' => $player_health_before,
			'player_health_after' => $this->gamestate['player_health'],
			'player_health_msg_before' => $player_health_msg_before,
			'player_health_msg_after' => $this->gamestate['player_health_msg'],
			'zombie_health_before' => $zombie_health_before,
			'zombie_health_after' => $this->gamestate["zhealth_$enemy"],
			'zombie_health_remaining' => $this->gamestate["zhealth_$enemy"],
			'zombie_max_health' => $enemy_details['max_health'],
			'his' => $enemy_details['sex'] == 'm' ? 'his' : 'her',
			'loot_button_value' => $enemy_details['loot_button_value'],
			'loot_action' => "loot_$enemy",
			'combat_action' => $this->action
		));
		$this->render('/game/combat');
	}

	// Checks to see if the current combat is the beginning of a new combat
	// and sets appropriate variables
	function setNewCombatVariables($enemy) {
		// If not a new combat (i.e. continuation of a combat), return
		if ($this->gamestate['zombie_last_fought'] == $enemy) {
			return;
		}

		$this->gamestate['zombie_last_fought'] = $enemy;

		// Update health message
		$enemy_details = $this->Game->getEnemyDetails($enemy);
		$this->updateZombieHealthMessage($this->gamestate["zhealth_$enemy"], $enemy_details['max_health']);
	}

	function updateZombieHealthMessage($health, $max_health) {
		$this->gamestate['zombie_health_msg'] = $this->Game->getZombieStatusMessage($health, $max_health);
	}

	function updatePlayerHealthMessage() {
		$this->gamestate['player_health_msg'] = $this->Game->getHealthStatusMessage($this->gamestate);
	}

	/* Returns array with values:
	 * 'damage' => amount of damage dealt to zombie,
	 * 'message' => message describing to success/failure of attack,
	 * 'zombie_killed_message' => message describing zombie death (or FALSE),
	 * 'zombie_killed_pic' => filename of zombie death pic (or FALSE),
	 * 'pic' => picture of the result of the player's attempt to attack the zombie */
	function getPlayerAttackResult($attack, $enemy, $enemy_details, $attacks) {
		$him = $enemy_details['sex'] == 'm' ? 'him' : 'her';
		$his = $enemy_details['sex'] == 'm' ? 'his' : 'her';
		$he = $enemy_details['sex'] == 'm' ? 'he' : 'she';
		$bastard = $enemy_details['sex'] == 'm' ? 'bastard' : 'bitch';

		// Attack may be replaced by an interception
		if ($results = $this->Game->combatInterception($enemy, $attack, $this->gamestate)) {
			return $results;
		}

		// Attack may be replaced with vomiting
		if ($results = $this->Game->combatVomit($this->gamestate, $attack, $enemy)) {
			$this->vomit();
			return $results;
		}

		// Attack may be replaced with zombie performing a special block
		if ($results = $this->Game->combatSpecialZBlock($enemy, $attack, $this->gamestate)) {
			return $results;
		}

		// Results (hit or miss) for specific attacks
		if ($attack == 'Punch') {
			$results = $this->attackPunch($enemy, $enemy_details['sex']);
		} elseif ($attack == 'Kick') {
			$results = $this->attackKick($enemy, $enemy_details['sex']);
		} elseif ($attack == 'TWBMSW') {
			$results = $this->attackWhack($enemy, $enemy_details['sex']);
		} elseif ($attack == 'Kill') {
			$results = $this->attackKill($enemy, $enemy_details['sex']);
		}
		$this->gamestate["zhealth_$enemy"] = max(($this->gamestate["zhealth_$enemy"] - $results['damage']), 0);
		$zombie_killed = $this->gamestate["zhealth_$enemy"] == 0;
		$results['zombie_killed_message'] = $zombie_killed ? $this->Game->getZombieDeathMessage($enemy) : false;
		$results['zombie_killed_pic'] = $zombie_killed ? $this->Game->getZombieDeathPic($enemy) : false;
		$results['pic'] = $this->Game->getPlayerAttackPic($enemy, $attack, ($results['damage'] > 0));
		return $results;
	}

	function attackPunch($enemy, $sex) {
		$attacks = $this->Game->getAttacks($this->gamestate);
		$results = array();
		if (rand(1, 100) <= $attacks['punch']['chance']) {
			$results['damage'] = $attacks['punch']['damage'];
			$him = $sex == 'm' ? 'him' : 'her';
			$his = $sex == 'm' ? 'his' : 'her';
			$results['message'] = rand(0, 1)
				? "You punch the zombie in $his face, knocking $him back and scattering rotten teeth."
				: "You slam into the zombie's face with your fist. Normally that would really hurt your hand, but the zombie's decomposing skull makes it feel like you're punching a Jello mold full of bone shards.";
			$exclamation = array_rand(array_flip(array('Pow!', 'Bam!', 'Sock!')));
			$results['message'] = "<span class=\"damage_dealt\">$exclamation</span> ".$results['message'];
		} else {
			$results['damage'] = 0;
			$he = $sex == 'm' ? 'he' : 'she';
			$results['message'] = "You try to punch the zombie, but $he stumbles out of the way and you miss.";
		}
		return $results;
	}

	function attackKick($enemy, $sex) {
		$attacks = $this->Game->getAttacks($this->gamestate);
		$results = array();
		if (rand(1, 100) <= $attacks['kick']['chance']) {
			$results['damage'] = $attacks['kick']['damage'];
			$him = $sex == 'm' ? 'him' : 'her';
			$his = $sex == 'm' ? 'his' : 'her';
			$results['message'] = rand(0, 1)
				? "You kick the zombie in $his stomach. You hear sickening zombie-goo sloshing around inside $him and hope you don't get any on your shoes."
				: "With a loud <q>HI-YAH!</q> you kick the zombie in the chest. You hear $his ribs cracking like a cadaver pi&ntilde;ata full of gross.";
			$exclamation = array_rand(array_flip(array('Thud!', 'Punt!', 'Thunk!')));
			$results['message'] = "<span class=\"damage_dealt\">$exclamation</span> ".$results['message'];
		} else {
			$results['damage'] = 0;
			$bastard = $sex == 'm' ? 'bastard' : 'bitch';
			$results['message'] = "You try to kick the zombie, but the slippery $bastard abruptly lurches out of the way.";
		}
		return $results;
	}

	function attackWhack($enemy, $sex) {
		$attacks = $this->Game->getAttacks($this->gamestate);
		$results = array();
		if (rand(1, 100) <= $attacks['twbmsw']['chance']) {
			$results['damage'] = $attacks['twbmsw']['damage'];
			$He = $sex == 'm' ? 'He' : 'She';
			$results['message'] = rand(0, 1)
				? "With a mighty roar, you spin around and channel your Viking fury into a Two-Wheeler Backwards Midnight Shin-Whack. $He coughs up some bone shards and staggers."
				: "You deliver a Two-Wheeler Backwards Midnight Shin-Whack into the zombie with so much force that it sets off a car alarm outside. $He coughs up some bone shards and staggers.";
			$results['message'] .= ' You feel a little more sober.';
			$exclamation = array_rand(array_flip(array('Kapow!', 'Skiddoosh!', 'Booyah!', 'Boom goes the dynamite!')));
			$results['message'] = "<span class=\"damage_dealt\">$exclamation</span> ".$results['message'];
			$this->gamestate['burpies'] = 0;
			$this->gamestate['bac'] = max($this->gamestate['bac'] - 0.03, 0);
		} else {
			$results['damage'] = 0;
			$bastard = $sex == 'm' ? 'bastard' : 'bitch';
			$results['message'] = rand(0, 1)
				? "You try to shin-whack the zombie, but the slippery $bastard abruptly lurches out of the way."
				: "You try to pull off the Two-Wheeler Backwards Midnight Shin-Whack, but you just get confused halfway through and trip over your feet.";
		}
		return $results;
	}

	function attackKill($enemy, $sex) {
		$attacks = $this->Game->getAttacks($this->gamestate);
		$results = array();
		$results['damage'] = $attacks['kill']['damage'];
		$him = $sex == 'm' ? 'him' : 'her';
		$results['message'] = "<span class=\"damage_dealt\">Shazam!</span> You magically insta-kill $him.";
		return $results;
	}

	function getZombieAttackResult($enemy, $enemy_details) {
		$his = $enemy_details['sex'] == 'm' ? 'his' : 'her';
		$him = $enemy_details['sex'] == 'm' ? 'him' : 'her';
		$he = $enemy_details['sex'] == 'm' ? 'he' : 'she';
		$results = array();
		$auto_success = $this->gamestate['q_first_combat_round'];

		// Results for specific attacks
		// Claw attempted (1pt, 50%, 0.5 avg)
		if (rand(0, 1)) {
			$attack = 'claw';
			if (rand(1, 100) < 50 || $auto_success) {
				$results['damage'] = 1;
				$exclamation = array_rand(array_flip(array('Ow!', 'Damn!', 'Ouch!', 'Shit!')));
				$results['message'] = "The zombie swipes at you with $his ragged nails, giving you a nasty gash.";
			} else {
				$results['damage'] = 0;
				$results['message'] = "The zombie reaches forward and tries to grab you, but you dodge out of the way just in time.";
			}

		// Bite attempted (3pt, 25%, .75avg)
		} else {
			$attack = 'bite';
			if (rand(1, 100) < 25 || $auto_success) {
				$results['damage'] = 3;
				$exclamation = array_rand(array_flip(array('Fuck!', 'Aaaauuugh!', 'Eeeeek!')));
				$results['message'] = "The zombie lunges forward and bites you, taking a small chunk of skin with $him.";
			} else {
				$results['damage'] = 0;
				$results['message'] = "The zombie snaps $his hungry jaws at you, but you shove $him back before $he can bite you.";
			}
		}

		if ($auto_success) {
			$this->gamestate['q_first_combat_round'] = false;
		}

		if (isset($exclamation)) {
			$results['message'] = "<span class=\"damage_taken\">$exclamation</span> ".$results['message'];
		}
		$this->gamestate['player_health'] = max(($this->gamestate['player_health'] - $results['damage']), 0);
		$results['player_killed'] = ($this->gamestate['player_health'] == 0);
		$results['pic'] = $this->Game->getZombieAttackPic($enemy, $attack, ($results['damage'] > 0));
		return $results;
	}

	function gainMoney($amount) {
		$this->gamestate['money'] += $amount;
	}

	function getLoot($enemy) {
		// Already looted
		if ($this->gamestate["looted_$enemy"]) {
			return;
		}
		$loot = $this->Game->getLoot($enemy);
		if (isset($loot['money'])) {
			$this->gainMoney($loot['money']);
		}
		$this->set('loot', $loot);
	}

	function drink($drink) {
		switch($drink) {
			case 'shot':
				$points_healed = 5;
				$this->gamestate['player_health'] = min($this->gamestate['player_health'] + $points_healed, $this->gamestate['player_max_health']);
				$this->gamestate['drank_shots']++;
				$this->gamestate['bac'] += 0.03;
				$this->burpiesCheck();
				$this->updatePlayerHealthMessage();
				break;
			case 'beer':
				$points_healed = 4;
				$this->gamestate['player_health'] = min($this->gamestate['player_health'] + $points_healed, $this->gamestate['player_max_health']);
				$this->gamestate['drank_beers']++;
				$this->gamestate['bac'] += 0.025;
				$this->burpiesCheck();
				$this->updatePlayerHealthMessage();
				break;
			case 'coffee':
				$this->gamestate['bac'] = max($this->gamestate['bac'] - 0.02, 0);
				$this->gamestate['drank_coffees']++;
				break;
		}
		$this->set('ordered_a_drink', true);
	}

	/* Percentage chance of needing to puke is (BAC * 200) if BAC >= 0.3
	 * So 60% at BAC 0.3, 80% at BAC 0.4, 100% at BAC 0.5 */
	function burpiesCheck() {
		if (
			$this->gamestate['burpies'] == 0
			&& $this->gamestate['bac'] >= 0.3
			&& rand(1, 100) <= ($this->gamestate['bac'] * 200)
		) {
			$this->set('burpies_acquired', true);
			$this->gamestate['burpies'] = 1;
		}
	}

	function lootingAttempt($zone, $enemy) {
		if ($this->gamestate["looted_$enemy"]) {
			$this->gotoZone($zone);
			return;
		}
		$this->getLoot($enemy);
		$this->gamestate["looted_$enemy"] = true;
		$this->render("/zones/$zone/loot_$enemy");
	}

	// Vomiting reduces BAC by 0.05 and temporarily cures burpies
	function vomit() {
		// If player does not have burpies, vomit message may still be displayed,
		// but BAC is not effected
		if ($this->gamestate['burpies']) {
			$this->gamestate['bac'] = max(0, $this->gamestate['bac'] - 0.05);
			$this->gamestate['burpies'] = 0;
		}
	}

	function zone_bar() {
		switch ($this->action) {
			case 'begin':
				$this->render('/zones/bar/intro');
				break;
			case 'combat':
				$this->setAutoZone('bar', 'combat');
				$this->combat('barfly');
				break;
			case 'loot_barfly':
				$this->lootingAttempt('bar', 'barfly');
				break;
			case 'free_shot':
				if ($this->gamestate['q_free_shot_taken']) {
					$this->gotoZone('bar');
					break;
				}
				$this->gamestate['q_free_shot_taken'] = true;
				$this->gamestate['attack_kick'] = true;
				$this->drink('shot');
				$this->setAutoZone('bar');
				$this->render('/zones/bar/free_shot');
				break;
			case 'talk':
				if ($this->data['Game']['question'] == 'destankify') {
					if ($this->gamestate['q_mop_closet_key']) {
						$this->set('already_have_mop_closet_key', true);
					} else {
						$this->gamestate['q_mop_closet_key'] = true;
					}
				}
				$this->set('question', $this->data['Game']['question']);
				$this->render('/zones/bar/talk');
				break;
			case 'buy_shot':
				if ($can_afford = $this->gamestate['money'] >= 3) {
					if ($can_drink = ! $this->gamestate['burpies']) {
						$this->drink('shot');
						$this->gamestate['money'] -= 3;
					}
				}
				$this->set(compact('can_afford', 'can_drink'));
				$this->render('/zones/bar/buy_shot');
				break;
			case 'buy_beer':
				if ($can_afford = $this->gamestate['money'] >= 2.5) {
					if ($can_drink = ! $this->gamestate['burpies']) {
						$this->drink('beer');
						$this->gamestate['money'] -= 2.5;
					}
				}
				$this->set(compact('can_afford', 'can_drink'));
				$this->render('/zones/bar/buy_beer');
				break;
			case 'buy_coffee':
				if ($can_afford = $this->gamestate['money'] >= 1) {
					$this->drink('coffee');
					$this->gamestate['money'] -= 1;
				}
				$this->set(compact('can_afford'));
				$this->render('/zones/bar/buy_coffee');
				break;
			case 'tip':
				if ($can_afford = $this->gamestate['money'] >= 1) {
					$this->gamestate['tipped']++;
					$this->gamestate['money'] -= 1;
				}
				$this->set(compact('can_afford'));
				$this->set('ordered_a_drink', true);
				$this->render('/zones/bar/tip');
				break;
			default:
				if ($this->gamestate['q_tipjar_found'] && ! $this->gamestate['q_tipjar_given']) {
					$this->gamestate['q_tipjar_given'] = true;
					$this->gainMoney(20);
					$this->render('/zones/bar/tipjar');
					break;
				}
				$this->render('/zones/bar/main');
		}
	}

	function zone_soundbooth() {
		switch ($this->action) {
			case 'combat':
				$this->combat('soundbooth');
				break;
			case 'loot_soundbooth':
				$this->gamestate['q_flashlight_found'] = true;
				$this->lootingAttempt('soundbooth', 'soundbooth');
				break;
			default:
				$this->render('/zones/soundbooth/main');
		}
	}

	function zone_dancefloor() {
		switch ($this->action) {
			case 'combat_wheelchair':
				$this->combat('wheelchair');
				break;
			case 'combat_hippie':
				$this->combat('hippie');
				break;
			case 'loot_wheelchair':
				$this->lootingAttempt('dancefloor', 'wheelchair');
				break;
			case 'loot_hippie':
				$this->lootingAttempt('dancefloor', 'hippie');
				break;
			case 'derby_fight':
				$this->render('/zones/dancefloor/derby_fight');
				break;
			case 'combat_derby':
				$this->combat('derby');
				break;
			case 'loot_derby':
				$this->lootingAttempt('dancefloor', 'derby');
				break;
			case 'learn_twbmsw':
				$this->gamestate['attack_twbmsw'] = 1;
				$this->render('/zones/dancefloor/learn_twbmsw');
				break;
			case 'combat_child':
				$this->combat('child');
				break;
			case 'loot_child':
				$this->gamestate['q_air_freshener_found'] = true;
				$this->render('/zones/backstage/grab_air_freshener');
				break;
			default:
				$this->render('/zones/dancefloor/main');
		}
	}

	function zone_mortal_kombat() {
		switch ($this->action) {
			default:
				$this->render('/zones/mortal_kombat/main');
		}
	}

	function zone_search_tables() {
		switch ($this->action) {
			default:
				$this->render('/zones/search_tables/main');
		}
	}

	function zone_restrooms() {
		switch ($this->action) {
			case 'closet':
				$this->render('/zones/restrooms/closet');
				break;
			default:
				$this->render('/zones/restrooms/main');
		}
	}

	function zone_womensrr() {
		switch ($this->action) {
			case 'combat':
				$this->combat('womensrr');
				break;
			case 'loot_womensrr':
				$this->lootingAttempt('womensrr', 'womensrr');
				break;
			case 'vomit':
				$this->vomit();
				$this->render('/zones/womensrr/vomit');
				break;
			default:
				$this->render('/zones/womensrr/main');
		}
	}

	function zone_mensrr() {
		switch ($this->action) {
			case 'combat':
				$this->combat('mensrr');
				break;
			case 'loot_mensrr':
				$this->gamestate['q_tipjar_found'] = true;
				$this->lootingAttempt('mensrr', 'mensrr');
				break;
			case 'vomit':
				$this->vomit();
				$this->render('/zones/mensrr/vomit');
				break;
			default:
				if ($this->gamestate['q_mensrr_stank_encountered']) {
					if ($this->gamestate['q_air_freshener_found']) {
						if (! $this->gamestate['q_air_freshener_used']) {
							$this->gamestate['q_air_freshener_used'] = true;
							$this->set('using_air_freshener', true);
						}
					}
				} else {
					$this->gamestate['q_mensrr_stank_encountered'] = true;
					$this->set('stank_first_encountered', true);
				}
				$this->render('/zones/mensrr/main');
		}
	}

	function zone_mop_closet() {
		switch ($this->action) {
			default:
				if ($this->gamestate['q_mop_closet_key'] && ! $this->gamestate['q_mop_closet_opened']) {
					$this->gamestate['q_mop_closet_opened'] = true;
					$this->set('releasing_mop_closet_zombie', true);
				}
				$this->render('/zones/mop_closet/main');
		}
	}

	function zone_front() {
		switch ($this->action) {
			case 'combat':
				$this->combat('comedian');
				break;
			case 'loot_comedian':
				$this->lootingAttempt('front', 'comedian');
				break;
			default:
				$this->render('/zones/front/main');
		}
	}

	function zone_backstage() {
		if (! $this->gamestate['q_derby_girls_released']) {
			$this->gamestate['q_derby_girls_released'] = 1;
			$this->setAutoZone('dancefloor', 'derby_fight');
			$this->render('/zones/dancefloor/derby_fight');
		} elseif (! $this->gamestate['q_flashlight_found']) {
			$this->gamestate['q_backstage_too_dark'] = true;
			$this->render('/zones/backstage/too_dark');
		} elseif ($this->gamestate['q_mop_closet_opened']) {
			if ($this->gamestate['zhealth_child']) {
				$this->render('/zones/backstage/release_child');
			} elseif (! $this->gamestate['q_air_freshener_found']) {
				$this->gamestate['q_air_freshener_found'] = true;
				$this->render('/zones/backstage/grab_air_freshener');
			} else {
				$this->render('/zones/backstage/done');
			}
		} else {
			$this->render('/zones/backstage/done');
		}
	}
}
?>