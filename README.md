# SMSC

### Simple library for sending SMS and Viber messages

An API for sending short messages with the https://smsc.ua / https://smsc.ru / https://smsc.kz / https://smsc.tj / https://smscentre.com services.

## How to use:

```php
<?php

use \Smsc\Settings;
use \Smsc\SmscMessage;

// Create new settings item
$settings = new Settings($MY_LOGIN, $MY_PASSWORD);

// Create new message
$sms = new SmscMessage($settings, $phones, $message, $options);

// Send message
$sms->send();
```
