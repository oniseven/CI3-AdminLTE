## What is CI3-AdminLTE (Codeigiter 3.1.13 + AdminLTE 3.2.0)

The journey began when I sought the optimal method to seamlessly integrate an Admin Template with CodeIgniter 3. Exploring various approaches, including Core, Helper, and Library implementations, I experimented with each method. Ultimately, I discovered that the choice between these approaches is subjective, dependent on personal preference. Any method can be employed, as long as it aligns with your ease of understanding and accomplishes your objectives. In this repository, I adopted the Library approach, finding it notably more convenient for maintenance compared to alternative methods. 

In this repo I use `CodeIgniter 3.1.13` and `AdminLTE 3.2.0` for the admin template.

So if you are looking for a ready to use CodeIgniter 3 with AdminLTE Template, feel free to clone this repo and tweak it according to your needs. 

This repo also come with Datatables example usage and different concept of using `Model` and `Core Model`. That might gonna need a tweak here and there depend on your personal preference.

## Can I use it with other Admin Template?

If what you mean by use is using the concept. Then yes, you can use the concept of templating in this repo with another Admin Template that you want. 
You could still use this template library by adjusting a couple things like:
- On `application/views/template/default` folder, adjust all the file base on the Admin Template that you use. Like header, sidebar, content, and footer, you can adjust it to your need.
- Tweaking a couple things in `application/libraries/Template.php` file specially the `load` function. Set the view to what ever file that you already set up.
- For other functions, you can also tweak it or even delete it according to your need.

But I suggest you to create your own template library file base on your Admin Template, and copy the concept of this repo template library. Because every admin template have their own unique points, fitures, and structures that might not fit with the template library that I create in here which is sorely base on AdminLTE.

## Server Requirements

- PHP version 5.6 or newer is recommended. (Testing in PHP 7)
- MySQL Server. (Testing in MariaDB 10.5.4)
- Composer.

## Installations

- Clone this to your php server, you could use XAMPP or any kind of PHP server.
- Import the demo database `demo_database_cignadlte.sql` to MySQL database server that you have.
- Rename `.env-test` in `application` folder to `.env`, and populate the data according to your database config.
- In cli/bash run `composer install` it will install dependency from `composer.json`.
- That's it. You are good to go, just open your browser and go to <http://localhost/cignadlte>.
- Have fun.

## Usage

### Template Library
- Location: `application/libraries`
- filename: `Template.php`

#### Load the template

This function has 2 parameter,
- `$view` (* mandatory): Its your view page files so its mandatory otherwise error will occurred
- `$data`: Data for your page
To load the template with your view content you could just do

```php
$this->template->load("welcome");
```

if you have some data you could just simply pass on the data into the function parameter

```php
$this->template->load("welcome", $data);
```

#### Set page title

```php
$this->template->page_title("Welcome Page");
```

#### Use Plugins

Update your list of 3rd parties plugins that you use for your app in `application/configs/plugins.php`

```php
$this->template->plugins("datatables"); 
```

You could also set the parameter as an array

```php
$this->template->plugins(["datatables"]);
```

#### Set Page JS

```php
$this->template->page_js("assets/dist/js/pages/demo.js");
```

You could also set the parameter as an array if you have multiple custom js file for one page

```php
$this->template->page_js([
  "assets/dist/js/pages/demo1.js", 
  "assets/dist/js/pages/demo2.js"
]);
```

#### Hide Toolbar Content

```php
$this->template->hide_content_toolbar(); // no parameter needed
```

#### Hide Breadcrums

```php
$this->template->hide_breadcrums(); // no parameter needed
```

#### Hide Footer

```php
$this->template->hide_footer(); // no parameter needed
```

#### Hides a couple things

to hides a couple things in one go, you could use this function, for now its only work to hide such as 
- `content_title`
- `breadcrums`
- `footer`

```php
$this->template->hides([
  'content_title',
  'breadcrums',
  'footer'
]);
```

#### Full Example

```php
$this->template->page_title("Welcome Page");
$this->template->plugins("datatables"); 
$this->template->page_js("assets/dist/js/pages/demo.js");
$this->template->load("welcome");
```
or
```php
$data = []; // set your data here
$this->template
  ->page_title("Welcome Page")
  ->plugins("datatables")
  ->page_js("assets/dist/js/pages/demo.js")
  ->load("welcome", $data);
```

## Resources

-  Codeigniter <https://codeigniter.com/docs>
-  AdminLTE <https://github.com/ColorlibHQ/AdminLTE>
