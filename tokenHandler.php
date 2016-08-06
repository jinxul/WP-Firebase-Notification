<?php 
add_action('parse_request', 'tokenHandler');

function tokenHandler() {
   if($_SERVER["REQUEST_URI"] == '/app/tokenHandler.php') {
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		global $wpdb;
		$token=$_POST["token"];
		$wpdb->query( $wpdb->prepare("INSERT INTO firebase_users (token) VALUES ( %s ) ON DUPLICATE KEY UPDATE token = %s;", $token, $token));
			
	}
      exit();
   }
}
?>