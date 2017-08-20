# SMSC

### Simple library for sending SMS and Viber messages

An API for sending short messages with the SMSC services.

Supported getaways:

- https://smsc.ua 
- https://smsc.ru 
- https://smsc.kz 
- https://smsc.tj 
- https://smscentre.com


## How to use:

### Send message
```php
<?php

use \Smsc\Settings;
use \Smsc\SmscMessage;

// Create new settings item
$settings = new Settings($MY_LOGIN, $MY_PASSWORD);

// Create new message
$options = [
    'translit' => true, // Set transliteration
];
$sms = new SmscMessage($settings, $phones, $message, $options);

// Send message
$sms->send();
```

### Check balance
```php
<?php

use \Smsc\Settings;
use \Smsc\SmscMessage;

// Create new settings item
$settings = new Settings($MY_LOGIN, $MY_PASSWORD);

// Create new balance
$balance = new SmscBalance($settings);

// Send request
$balance->send();
```
