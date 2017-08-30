# SMSC

### Simple library for sending SMS and other messages

An API for sending short messages with the SMSC services.

Supported gateways:

- https://smsc.ua 
- https://smsc.ru 
- https://smsc.kz 
- https://smsc.tj 
- https://smscentre.com


## Installing

SMSC library can be installed directly from **Composer**.

```
composer require awd-studio/smsc
```


## How to use:

### Send messages
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

// Send SMS
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
$arr = $senders->results();
```

### More examples
```php
<?php

use \Smsc\Settings;
use \Smsc\SmscMessage;

// Create new settings item
$settings = new Settings($MY_LOGIN, $MY_PASSWORD);
$sms = new SmscMessage($settings, $phones, $message, $options);

// Send MMS
$sms->mms($theme = 'My message theme');
$sms->send();

// Send E-mail
$sms->email($theme = 'My message theme');
$sms->send();

// Send Viber
$sms->viber();
$sms->send();

// Send HLR
$sms->hlr();
$sms->send();

// Send Flash-SMS
$sms->flash();
$sms->send();

// Send Ping-SMS
$sms->ping();
$sms->send();

// Voice message
$sms->call('w3'); // Voice call with women alternative voice #2.
$sms->send();

// Set additional options
$options = [
    'id'      => 123,        // Set SMS ID
    'time'    => $timestamp, // Set SMS sending time
    'valid'   => 10,         // Set SMS live time for 100 hours
    'tinyurl' => true,       // Automate short URL's
];
$sms = new SmscMessage($settings, $phones, $message, $options);
$sms->send();
```
*More information [here](https://smsc.ua/api/http/send/sms).*
