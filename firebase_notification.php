<?php 
/*
Plugin Name: Firebase Notification
Description: sends notification to android app via Firebase API after new post has been submited.
Version:     1.1
Author:      Ahmad Givekesh
Author URI:  baboon.ir
License:     Apache v2.0
License URI: http://www.apache.org/licenses/LICENSE-2.0
*/

include 'utils.php';
include 'admin/index.php';

add_action( 'save_post', 'prepare_notification', 13, 2);
function prepare_notification( $post_id, $post) {

	// If this is just a draft dont send notification
	if ( $post->post_status  != "publish")
		return;

	global $wpdb;

	if(shouldSendNotification($wpdb, $post_id)){
		$tokens = get_token($wpdb);
		$post_title = $post->post_title;
		$message = array('body' => $post_title,
			'title' => 'پست جدید');
		send_notification($tokens, $message, 'notification');
		add_to_db($wpdb, $post_id, $post_title);
	} 
}

function shouldSendNotification($wpdb, $id){
	$result = $wpdb->get_results( $wpdb->prepare("SELECT id FROM notification_list WHERE id = %d;", $id));
	return empty($result);
}
	
function get_token($wpdb){
	$result = $wpdb->get_results("SELECT token FROM firebase_users;");
	$tokens = array();
	foreach($result as $row){
		$tokens[] = $row->token;
	}
	return $tokens;
}

function add_to_db($wpdb, $id, $title){
	$wpdb->query( $wpdb->prepare("INSERT INTO notification_list(id, title) VALUES(%d, %s);", $id, $title));
}

function send_notification ($tokens, $message, $type){
		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
			 'registration_ids' => $tokens,
			 $type => $message
			);
		$headers = array(
			'Authorization:key = AUTHORIZATION_KEY ',
			'Content-Type: application/json'
			);
			
	   $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_POST, true);
       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
       $result = curl_exec($ch);           
       if ($result === FALSE) {
           die('Curl failed: ' . curl_error($ch));
       }
       curl_close($ch);

       return $result;
}