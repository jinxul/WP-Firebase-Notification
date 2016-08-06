WP Firebase Notification
=================

sends notification to android/ios app via Firebase API after new post has been submited.


TODO List
=======

- Protect Against Malicious POST Requests
- Admin Page
- Auto Mysql Table Creator


REQUIREMENTS
=======

- you need to put your Authorization key in send_notification method (instead of AUTHORIZATION_KEY).
- also dont forget to import/create mysql tables (provided in mysql_tables.sql).

Credits
=======

All credits goes to [Filip Vujovic](https://github.com/miskoajkula) for [FireBase Cloud Messaging Push Notifications](https://github.com/miskoajkula/Fcm)


License
=======

```license
Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
```