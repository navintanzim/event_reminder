<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

<strong>This app uses php 7.3.5 and laravel 8.</strong> <br>

Steps to run the program locally:

1: Pull the code from the default branch of the repository. <br>
2: Install composer and also run a composer update to be sure. <br>

3: The database credentials can be found in the .env file. Make the database and run the database migration by

php artisan migrate

php artisan db:seed

4: Run the program by the command: php artisan serve <br>
5: Run the console commands for sending email notification by- php artisan schedule:run <br>
6: For individual commands:

php artisan email:queue  - sending emails as notifications from the database
php artisan meeting:notify - create email notifications for daily reminders of a meeting
php artisan meeting:reminder - create email notifications for 20 minute(or whichever time has been fixed) reminders of a meeting

N.B: Users with user_type 1x101 are admin users. They can create events and assign others to those meetings. The users with 5x505 user_type are regular users. They can not create or edit events or other regular users. 

User Creation: The admin users can create new users from the Menu : Users. Go to the User List and press the button New User.

Meeting Creation: The admin users can create new meetings from the Menu : Meeting. Go to the Meeting List and press the button New Meeting.

Regular users can only view the meeetings and cant see the user menu at all.

Data Import Feature: <br>

Only Admin users can access this feature. To use this, press the "Import Excel Data" button. This will bring up a modal. You can upload excel files there. A sample file can be viewed through the modal. A file has also been given at : \public\uploads\finance\2025\03\ReminderBook1.xlsx

Once uploaded, a view will show the reminder table data.

Notifications: The notifications come in two forms. Via email. and via an inbuilt cron that checks for updates every minute. the email service requires internet connection, but as long as the app has access to its cache and database, the internal system will work. The internal system is located at the top right corner of the app. A bell icon shows the pending notification. You can also see a full list of the notifications for your account by clicking on it.

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
