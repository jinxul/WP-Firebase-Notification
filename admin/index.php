<?php
add_action('admin_enqueue_scripts', 'admin_style');
function admin_style($hook){
    if ($hook == 'toplevel_page_firebase_notification-plugin') {
        wp_enqueue_style('admin_style', plugins_url('admin/dist/styles/main.min.css', dirname(__FILE__)));
        wp_enqueue_script('angular_script', plugins_url('admin/dist/scripts/angular.min.js', dirname(__FILE__)));
        wp_enqueue_script('main_script', plugins_url('admin/dist/scripts/main.min.js', dirname(__FILE__)));
        wp_enqueue_script('app_script', plugins_url('admin/app/app.js', dirname(__FILE__)));
    }
}

add_action('admin_menu', 'firebase_notification_setup_menu');
function firebase_notification_setup_menu(){
    add_menu_page('Firebase Notification Admin', 'Firebase Notification', 'manage_options', 'firebase_notification-plugin', 'admin_init');
}

function admin_init(){
    $media_firebase = plugins_url('admin/dist/images/firebase.png', dirname(__FILE__));
    $action_handler = '../app/send_notification.php';
    echo '
    <body ng-app="myApp">

    <div class="container">
        <div ng-controller="mainCtrl">
            <form id="myForms" action="'.$action_handler.'" method="POST" dir="ltr">
                <h3><img src="' . $media_firebase . '" alt="">Compose Message</h3>
                <fieldset ng-init="sendToAll=\'true\'">
                    <input type="radio" name="sendToAll" ng-model="sendToAll" value="true"> All Devices &nbsp&nbsp
                    <input type="radio" name="sendToAll" ng-model="sendToAll" value="false"> Selected Devices<br>
                </fieldset>
                <fieldset>
                    <input placeholder="Title" name="title" type="text" tabindex="1" required autofocus>
                </fieldset>
                <fieldset>
                    <input placeholder="Body" name="body" type="text" tabindex="2" required>
                </fieldset>
                <fieldset ng-show="sendToAll == \'false\'" class="form-group">
                    <textarea name="tokens" placeholder="FCM Registration Tokens (use , to separate them)"
                              ng-required="sendToAll == \'false\'"></textarea>
                </fieldset>
                <hr>
                <fieldset>
                    <button class="btn btn-success" type="submit" id="contact-submit">Send</button>
                </fieldset>
            </form>

            <div ng-controller="itemCtrl">
                <form id="myForms" action="'.$action_handler.'" method="POST" class="customData" dir="ltr">
                    <h3><img src="' . $media_firebase . '" alt="">Custom Data</h3>
                    <fieldset ng-init="sendToAll=\'true\'">
                        <input type="radio" name="sendToAll" ng-model="sendToAll" value="true"> All Devices &nbsp&nbsp
                        <input type="radio" name="sendToAll" ng-model="sendToAll" value="false"> Selected Devices<br>
                    </fieldset>
                    <fieldset ng-repeat="item in items">
                        <input placeholder="Key" name="key-{{item.id}}" type="text" tabindex="{{item.id}}" required
                               autofocus>
                        <input placeholder="Value" name="value-{{item.id}}" type="text" tabindex="{{item.id}}" required>
                        <a type="button" class="btn btn-danger btn-sm" ng-click="removeRecord($index)"><i
                                class="fa fa-times" aria-hidden="true"></i></a>
                    </fieldset>
                    <fieldset ng-show="sendToAll == \'false\'" class="form-group">
                        <textarea name="tokens" placeholder="FCM Registration Tokens (use , to separate them)"
                                  ng-required="sendToAll == \'false\'"></textarea>
                    </fieldset>
                    <hr>
                    <fieldset>
                        <a class="btn btn-info items" id="items" ng-click="addRecord()"><i class="fa fa-plus"
                                                                                           aria-hidden="true"></i> Key /
                            Value</a>
                        <button class="btn btn-success" type="submit" id="contact-submit">Send</button>
                    </fieldset>
                </form>
            </div>

        </div>
    </div>
    </body>
    </html>';
}