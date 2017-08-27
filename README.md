# SMSC

### Simple library for sending SMS and Viber messages

An API for sending short messages with the SMSC services.

Supported gateways:

- https://smsc.ua 
- https://smsc.ru 
- https://smsc.kz 
- https://smsc.tj 
- https://smscentre.com


## Installing

SMSC library can be installed directly from Composer.

```
composer require awd-studio/smsc
```


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

// Get response data
$response = $smsc->getData()->getResponse();
// Or get processed results
$response = $smsc->results();
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

### Get Sender-IDs
```php
<?php

use \Smsc\Settings;
use \Smsc\SmscSenders;

// Create new settings item
$settings = new Settings($MY_LOGIN, $MY_PASSWORD);

// Create new balance
$senders = new SmscSenders($settings);
$senders->getSenders();

// Send request
$senders->send();

// Manage Sender IDs
$arr = $smsc->results();
```
