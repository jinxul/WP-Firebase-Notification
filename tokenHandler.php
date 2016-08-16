<?php 
add_action('parse_request', 'tokenHandler');

function tokenHandler() {
   if($_SERVER["REQUEST_URI"] == '/app/tokenHandler.php') {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if($_SERVER['REQUEST_METHOD'] == 'POST' && preg_match('/android|iphone|ipad|ipod/i', $user_agent)){
		global $wpdb;
		$token=$_POST["token"];
		$wpdb->query( $wpdb->prepare("INSERT INTO firebase_users (token, agent) VALUES ( %s, %s ) ON DUPLICATE KEY UPDATE token = %s;", $token, $user_agent, $token));
			
	}
      exit();
   }
}
?>