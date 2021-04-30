## About
Add and manager email template for Laravel

### Features
- [x] Email template table
- [x] Add/Edit/Manager email template
- [x] Mail list send history
- [x] Send mail with cronjob

## Install
- Install package
```
composer require tadcms/laravel-email-template
```

- Migration
```
php artisan migrate
```

- Setup The Scheduler: Add command to your server
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

View more: [Starting The Scheduler](https://laravel.com/docs/6.x/scheduling#introduction)

## Usage
### Make Email Template
```
use Tadcms\EmailTemplate\Models\EmailTemplate;

EmailTemplate::create([
    'code' => 'test_mail',
    'subject' => 'Send email test for {name}',
    'body' => '<p>Hello {name},</p>
               <p>This is the test email</p>',
    'params' => [
        'name' => 'Your Name',
    ],
]);
```

### Send email with template
```
use Tadcms\EmailTemplate\EmailService;

EmailService::make()
    ->withTemplate('test_mail')
    ->setEmails('test@example.com')
    ->setParams([
        'name' => 'The Anh',
    ])
    ->send();
```

## License

The package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
