<?php
add_action('parse_request', 'request_handler');

function request_handler(){
    if ($_SERVER["REQUEST_URI"] == '/app/tokenHandler.php') {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && preg_match('/android|iphone|ipad|ipod/i', $user_agent)) {
            global $wpdb;
            $token = $_POST["token"];
            $wpdb->query($wpdb->prepare("INSERT INTO firebase_users (token, agent) VALUES ( %s, %s ) ON DUPLICATE KEY UPDATE token = %s;", $token, $user_agent, $token));

        }
        exit();
    }

    if ($_SERVER["REQUEST_URI"] == '/app/send_notification.php' && current_user_can('administrator')) {
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['sendToAll'] == 'true') {
                global $wpdb;
                $tokens = get_token($wpdb);
            } else
                $tokens = explode(",", $_POST['tokens']);

            if (isset($_POST['title'])) {
                $type = 'notification';
                $message = array('title' => $_POST['title'],
                    'body' => $_POST['body']);
            } else {
                $type = 'data';
                foreach ($_POST as $key => $value) {
                    if (preg_match("/key-(\d+)/", $key, $match)) {
                        $message[$value] = $_POST['value-' . $match[1]];
                    }
                }
            }
            send_notification($tokens, $message, $type);
            header('location: ../wp-admin/admin.php?page=firebase_notification-plugin');

        };
        exit();
    }
}

?>