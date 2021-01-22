<p align="left"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# Notes for Laravel development

Here you'll find useful notes and resources for developing web applications using
Laravel.

If all else fails, check the documentation [here](https://laravel.com/docs/8.x/).

# Menu

 - [Notes for Laravel development](#notes-for-laravel-development)

   - [Best Practices](#best-practices)

   - [Setup](#setup)

       - [Installing Laravel/Starting A Project](#installing-laravelstarting-a-project)

       - [Laravel Debug Bar](#laravel-debug-bar)

       - [Laravel Breeze](#laravel-breeze)

       - [Installing Tailwind](#installing-tailwind)

       - [So Many Directories...](#so-many-directories)

   - [Database](#database)

       - [Eloquent](#eloquent)

       - [Models](#models)

       - [Migrations](#migrations)

       - [Avoiding N + 1](#avoiding-n--1)

       - [Soft Deleting](#soft-deleting)

   - [Security](#security)

       - [Policies](#policies)

       - [CRSF Protection](#crsf-protection)

       - [SQL Injection Attacks](#sql-injection-attacks)

   - [Routing](#routing)

       - [Route Model Binding](#route-model-binding)

   - [Methods](#methods)

       - [Method Spoofing](#method-spoofing)

       - [Facades](#facades)

   - [Tools](#tools)

       - [Tinker](#tinker)

   - [Web](#web)

       - [Blade](#blade)

       - [Blade Components](#blade-components)

   - [Testing](#testing)

       - [Email](#email)

         - [Setting Up Mailtrap](#setting-up-mailtrap)

   - [Debugging](#debugging)

   - [Misc.](#misc)

## Best Practices
Information on best practices in Laravel can be found [here](https://www.laravelbestpractices.com/).

## Setup

#### Installing Laravel/Starting A Project
- Instructions can be found [here](https://laravel.com/docs/8.x/installation#the-laravel-installer)
- Configure the application to use the database client of your choice in `.env` (Alternatively you may create a file that will define the database connection you wish to use. [more info](https://laravel.com/docs/8.x/database))

#### Laravel Debug Bar
This is a package to integrate PHP Debug Bar with Laravel. It includes a ServiceProvider to register the debugbar and attach it to the output. You can publish assets and configure it through Laravel. It [bootstraps](https://stackoverflow.com/questions/1254542/what-is-bootstrapping) some Collectors to work with Laravel and implements a couple custom DataCollectors, specific for Laravel. It is configured to display Redirects and (jQuery) Ajax Requests. [more info](https://github.com/barryvdh/laravel-debugbar)

#### Laravel Breeze
Very useful for getting an app up and running quickly [more info](https://laravel.com/docs/8.x/starter-kits#laravel-breeze)

#### Installing Tailwind
Laravel comes pre-packaged with [Laravel Mix](https://laravel-mix.com/docs/6.0/what-is-mix), a powerful [module bundler](https://www.freecodecamp.org/news/lets-learn-how-module-bundlers-work-and-then-write-one-ourselves-b2e3fe6c88ae/).
1. `npm install tailwindcss`
2. `npm install`
3. `npm run dev`
4. navigate to webpack.mix.js and add the following code `require('tailwindcss')`
5. `npm run dev`
6. navigate to resources > css > app.css and add the following code:
    ```
    @tailwind base;
    @tailwind components;
    @tailwind utilities;
    ```
7. `npm run dev`
8. check your app.css file to make sure tailwind has installed successfully

Documentation:
- [Tailwind](https://tailwindcss.com/docs/installation)
- [Laravel Mix](https://laravel-mix.com/docs/6.0/what-is-mix)

#### So Many Directories...
Yep.

Here's a list of important directories:
- [Controllers](/app/Http/Controllers)
- [Policies](/app/Http/Policies)
- [Models](/app/Models)
- [Routes](/routes)
- [Views](/resources/views)
- [Database](/database)

## Database

#### Eloquent
Laravel includes Eloquent, an object-relational mapper [(ORM)](https://blog.bitsrc.io/what-is-an-orm-and-why-you-should-use-it-b2b6f75f5e2a) that makes it enjoyable to interact with your database. When using Eloquent, each database table has a corresponding "Model" that is used to interact with that table. In addition to retrieving records from the database table, Eloquent models allow you to insert, update, and delete records from the table as well. [more info](https://laravel.com/docs/8.x/facades)

#### Models
Models can be generated via the command line using [Eloquent](https://laravel.com/docs/8.x/eloquent). You can also generate a controller and factory for them as well. [more info](https://laravel.com/docs/8.x/eloquent#generating-model-classes)
- `php artisan make:model Product -mfc` (migrate, factory, & controller)

#### Migrations
Migrations are like version control for your database, allowing your team to define and share the application's database schema definition. [more info](https://laravel.com/docs/8.x/migrations)

#### Avoiding N + 1
[What is N + 1?](https://secure.phabricator.com/book/phabcontrib/article/n_plus_one/)

When accessing Eloquent relationships as properties, the related models are ["lazy loaded"](https://developer.mozilla.org/en-US/docs/Web/Performance/Lazy_loading). Laravel allows you to [eager load](https://laravel.com/docs/8.x/eloquent-relationships#eager-loading) relationships.

Instead of doing one query for every iteration, eager loading bundles these queries into a single query.

#### Soft Deleting
Normally when you run a DELETE statement in a database, the data's gone.

With the soft delete design pattern, you add a bit column like IsDeleted, IsActive, or IsArchived to the table, and instead of deleting rows, you flip the bit column. [more info](https://www.brentozar.com/archive/2020/02/what-are-soft-deletes-and-how-are-they-implemented/)

## Security

#### Policies
Policies are classes that organize authorization logic around a particular model or resource (who can do what with what). For example, if your application is a blog, you may have a App\Models\Post model and a corresponding App\Policies\PostPolicy to authorize user actions such as creating or updating posts. [more info](https://laravel.com/docs/8.x/authorization#creating-policies)

#### CRSF Protection
Cross-site request forgeries are a type of malicious exploit whereby unauthorized commands are performed on behalf of an authenticated user. Thankfully, Laravel makes it easy to protect your application from [cross-site request forgery](https://en.wikipedia.org/wiki/Cross-site_request_forgery) (CSRF) attacks. [more info](https://laravel.com/docs/8.x/csrf)

For example, a button is configured to log the user out and makes a call to a controller. Without CSRF protection, malicious users can force users to log out by interacting with the controller via code they have written and injected into the webpage.

#### SQL Injection Attacks
As long as you use the tools([Eloquent](https://laravel.com/docs/8.x/eloquent), [Query Builder](https://laravel.com/docs/8.x/queries)) provided by Laravel to build queries there should be nothing to worry about.

If you go rogue and write your own queries, then there can be issues. You can find examples of common SQL Injection vulnerabilities [here](https://cyberpanda.la/blog/laravel-sql-injections).


## Routing
Routes allow you to route application requests to the appropriate controller. [more info](https://laravel.com/docs/8.x/routing)

#### Route Model Binding
When injecting a model ID to a route or controller action, you will often query the database to retrieve the model that corresponds to that ID. Laravel route model binding provides a convenient way to automatically inject the model instances directly into your routes. For example, instead of injecting a user's ID, you can inject the entire User model instance that matches the given ID. [more info](https://laravel.com/docs/8.x/routing#route-model-binding)

## Methods

#### Method Spoofing
HTML forms do not support PUT, PATCH or DELETE actions. So, when defining PUT, PATCH or DELETE routes that are called from an HTML form, you will need to add a hidden _method field to the form. The value sent with the _method field will be used as the HTTP request method. [more info](https://laravel.com/docs/8.x/routing#form-method-spoofing)

#### Facades
Facades provide a "static" interface to classes that are available in the application's service container. Laravel ships with many facades which provide access to almost all of Laravel's features.

## Tools

#### Tinker
Tinker is a powerful tool for interacting with code within a Laravel application. For example, you can insert dummy data into the database using a factory method using the Tinker Powershell like so:
- `php artisan tinker` > `App\Models\Post::factory()->times(200)->create(['user_id => 2']);`

The command above translates to: "Start the Tinker Shell > Using the post factory method, create 200 Post model records using a user_id of 2".

More info on Tinker can be found [here](https://laravel.com/docs/8.x/artisan#tinker).

## Web

#### Blade
Blade is the simple, yet powerful templating engine that is included with Laravel. [more info](https://laravel.com/docs/8.x/blade)

#### Blade Components
Components and slots provide similar benefits to sections, layouts, and includes; however, some may find the mental model of components and slots easier to understand. [more info](https://laravel.com/docs/8.x/blade#components)

## Testing
Laravel is built with testing in mind. In fact, support for testing with [PHPUnit](https://phpunit.de/index.html) is included out of the box and a phpunit.xml file is already set up for your application. The framework also ships with convenient helper methods that allow you to expressively test your applications. [more info](https://laravel.com/docs/8.x/testing)

#### Email
Laravel provides a way to send emails through SwiftMailer. [more info](https://laravel.com/docs/8.x/mail)

[Mailtrap](https://mailtrap.io/) can be used to test email functionality.

##### Setting Up Mailtrap
1. Sign up to Mailtrap
2. Find your SMTP Settings
3. Go to your `.env` file
4. Fill in the values defined in your Mailtrap SMTP settings
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=<your_username>
MAIL_PASSWORD=<your_password>
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=<your_email>
MAIL_FROM_NAME="${APP_NAME}"
```

## Debugging
Here's a list of things you can check if you're getting errors, it's normally easier than you think (trust me).
- Do you you have all necessary `use` statements?
- Is there a missing semicolon anywhere?
- Is something misspelled?

## Misc.
