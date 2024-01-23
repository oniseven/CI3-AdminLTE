## What is Cignadlte

The journey began when I sought the optimal method to seamlessly integrate an Admin Template with CodeIgniter 3. Exploring various approaches, including Core, Helper, and Library implementations, I experimented with each method. Ultimately, I discovered that the choice between these approaches is subjective, dependent on personal preference. Any method can be employed, as long as it aligns with your ease of understanding and accomplishes your objectives. In this repository, I adopted the Library approach, finding it notably more convenient for maintenance compared to alternative methods.

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

To load the template with your content you could just do

```php
$this->template->load("welcome");
// if you have some data you could just simply add $data on the function parameter
$this->template->load("welcome", $data);
```

if you have some data you could just simply pass on the data on the function parameter

```php
$this->template->load("welcome", $data);
```

#### Set page title

```php
$this->template->page_title("Welcome Page");
```

#### Use Plugins

Update you list of 3rd parties plugins that you use in `application/configs/plugins.php`

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
  ->plugins("datatables");
  ->page_js("assets/dist/js/pages/demo.js")
  ->load("welcome", $data);
```

## Resources

-  Codeigniter <https://codeigniter.com/docs>
-  AdminLTE <https://github.com/ColorlibHQ/AdminLTE>
