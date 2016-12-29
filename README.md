# TextMagic Notifications Channel for Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/textmagic.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/textmagic)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/textmagic/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/textmagic)
[![StyleCI](https://styleci.io/repos/:style_ci_id/shield)](https://styleci.io/repos/:style_ci_id)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/:sensio_labs_id.svg?style=flat-square)](https://insight.sensiolabs.com/projects/:sensio_labs_id)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/textmagic.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/textmagic)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/laravel-notification-channels/textmagic/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/textmagic/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/textmagic.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/textmagic)

This package makes it easy to send notifications using [textmagic](https://www.textmagic.com/docs/api/) with Laravel 5.3.

## Contents

- [Installation](#installation)
	- [Setting up the TextMagic service](#setting-up-the-textmagic-service)
- [Usage](#usage)
	- [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation


You can install the package via composer:

``` bash
composer require laravel-notification-channels/textmagic
```

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\TextMagic\TextMagicServiceProvider::class,
],
```

### Setting up the TextMagic service

Create account in[TextMagic](https://my.textmagic.com/register/) and than create api key.

Then, configure your TextMagic api key and username:

```php
// config/services.php
...
'textmagic' => [
        'api_key' => env('TEXTMAGIC_API_KEY'),
        'username' => env('TEXTMAGIC_USERNAME'),
],
...
```

## Usage

You can now use the channel in your `via()` method inside the Notification class.
```php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\TextMagic\TextMagicChannel;
use NotificationChannels\TextMagic\TextMagicMessage;
 

class InvoicePaid extends Notification
{
 
  
    public function via($notifiable)
    {
        return [TextMagicChannel::class];
    }
  
   
 
    public function toTextMagic($notifiable)
    {
        return (new TextMagicMessage())
            ->content('One of your invoices has been paid!');
    }

}
```
After message sent `MessageWasSent` event fired.

### Routing a message

You can either send the notification by providing with the chat id of the recipient to the `to($phoneNumber)` method like shown in the above example or add a `routeNotificationForTextMagic()` method in your notifiable model:

``` php
...
/**
 * Route notifications for the TextMagic channel.
 *
 * @return string
 */
public function routeNotificationForTextMagic()
{
    return $this->phone_number;
}
...
```

### Available methods

- `to($phoneNumber)`: (string|array) Recipient's phone numbers.
- `content('')`: (string) Notification (sms) message.
- `from($phoneNumber)`: (string) phone number or alphanumeric sender ID

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email balunjozef@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Jozef Balun](https://github.com/jozefbalun)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
