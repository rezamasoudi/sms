# SMS - ارسال پیامک در لاراول

این پکیج حاوی درایور‌های مختلف از پنل های مختلف پیامکی هست و به شما کمک می‌کند در پروژه لاراول خود پیامک ارسال کنید

## نصب و راه اندازی

```shell
composer require masoudi/sms
```

```shell
php artisan vendor:publish --tag=masoudi-sms-config
```

### نحوه استفاده

وارد فایل کانفیگ پکیج در ادرس `config/sms.php` شوید و درایور پیشفرض خود را مشخص کنید

```php
// sms.php
[
    "default" => "kavenegar",
]
```

حتما دقت کنید تنظیمات درایور درست باشد میتوانید در همان فایل کانفیگ تنظیمات مربوط به هر سروریس پیامکی را پیدا کنید

```php
// sms.php
[
    "kavenegar" => [
        "token" => "xxxxxx"
    ]
]
```

برای ارسال پیامک باید از فساد `SMS` استفاده نمایید

```php
use Masoudi\SMS\Facade\SMS;
use Masoudi\SMS\Drivers\Kavenegar;

 SMS::driver(function (Kavenegar $kavenegar) {
    $kavenegar->lookup('09123456789', 'verify', ['%token' => '1234']);
 });

```

یا به این صورت

```php
use Masoudi\SMS\Facade\SMS;
use Masoudi\SMS\Drivers\Kavenegar;

 SMS::driver()->lookup('09123456789', 'verify', ['%token' => '1234']);
```

### ایجاد درایور جدید
شما میتوانید اختصاصی خودتان را بنویسید، برای ایجاد داریور جدید ابتدا کلاس جدیدی ایجاد کنید و آن را از `BaseSmsDriver` گسترش دهید

```php
use Masoudi\SMS\Contracts\BaseSmsDriver;

class MeliPayamek extends BaseSmsDriver {

    // متد های درایور خود را اضافه کنید
    public function send(string $from, string $to, string $text): void {
        // ارسال پیام...
    }

}

```
در آخر درایور خود را در سرویس پرووایدر رجیستر کنید

```php
// AppServiceProvider.php

use Masoudi\SMS\Facade\SMS;

public function boot() {

    SMS::register('melipayamak', MeliPayamek::class);
    
}
```

> تنظیمات مربوط به درایور خود را باید در فایل کانفیگ `sms.php` قراردهید و باید هم نام با اسم درایور باشد

تنظیمات درایور
```php
// sms.php
...
    "melipayamak" => [
        "api_url" => "https://xxxxx"
    ],
...
```