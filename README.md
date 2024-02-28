# Index

* [What is CI3-AdminLTE](#what-is-ci3-adminlte-codeigiter-3113--adminlte-320)
* [Can I use it with other Admin Template?](#can-i-use-it-with-other-admin-template)
* [Server Requirements](#server-requirements)
* [Installation](#installations)
* [Template Library Usage](#template-library-usage)
  * [Details](#details)
  * [Load The Template](#details)
  * [Set Page Type](#set-page-type)
  * [Set Page Title](#set-page-title)
  * [Use Plugins](#use-plugins)
  * [Set Custom Class](#set-custom-class)
  * [Add Custom Page CSS](#add-custom-page-css)
  * [Add Custom Page JS](#add-custom-page-js)
  * [Hide Toolbar Content](#hide-toolbar-content)
  * [Hide Breadcrums](#hide-breadcrums)
  * [Hide Footer](#hide-footer)
  * [Hides a couple things](#hides-a-couple-things)
  * [Examples](#examples)
* [Model Usage](#core-my_model-usage)
  * [Details](#details-1)
  * [Public Variables](#public-variables)
  * [Examples Creating Model extends MY_Model](#examples-creating-model-extends-my_model)
  * [Examples Model Usage](#examples-model-usage)
* [Resources](#resources)

----

# What is CI3-AdminLTE (Codeigiter 3.1.13 + AdminLTE 3.2.0)

The journey began when I sought the optimal method to seamlessly integrate an Admin Template with CodeIgniter 3. Exploring various approaches, including Core, Helper, and Library implementations, I experimented with each method. Ultimately, I discovered that the choice between these approaches is subjective, dependent on personal preference. Any method can be employed, as long as it aligns with your ease of understanding and accomplishes your objectives. In this repository, I adopted the Library approach, finding it notably more convenient for maintenance compared to alternative methods. 

In this repo I use `CodeIgniter 3.1.13` and `AdminLTE 3.2.0` for the admin template.

So if you are looking for a ready to use CodeIgniter 3 with AdminLTE Template, feel free to clone this repo and tweak it according to your needs. 

This repo also come with `Datatables` example usage and different concept of using `Model` and `Core Model` and also `Dynamic Menus`. That might gonna need a tweak here and there depend on your personal preference.

# Can I use it with other Admin Template?

If what you mean by use is using the concept? Then yes, you can use the concept of templating in this repo with another Admin Template that you want. 
You could still use this template library by adjusting a couple things like:
- On `application/views/template/default` folder, adjust all the file base on the Admin Template that you use. Like header, sidebar, content, and footer, you can adjust it to your need.
- Tweaking a couple things in `application/libraries/Template.php` file specially the `load` function. Set the view to what ever file that you already set up.
- For other functions, you can also tweak it or even delete it according to your need.

But I suggest you to create your own template library file base on your Admin Template, and implement the concept of this repo template library. Because every admin template have their own unique points, fitures, and structures that might not fit with the template library that I create in here which is solely based on `AdminLTE 3.2.0`.

# Server Requirements

- PHP version 7 or newer (It has to be 7+ because I use `??` in some of the code)
- MySQL Server (Testing in MariaDB 10.5.4)
- Composer

# Installations

- Clone this to your php server, you could use XAMPP or any kind of PHP server.
- Import the demo database `demo_database_cignadlte.sql` to MySQL database server that you have.
- Rename `.env-test` in `application` folder to `.env`, and populate the data according to your database config.
- In cli/bash run `composer install` it will install dependency from `composer.json`.
- That's it. You are good to go, just open your browser and go to <http://localhost/yourappname>.
- Have fun.

# Template Library Usage

### Details
- Location: `application/libraries`
- filename: `Template.php`

### Load the template

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

----

### Set Page Type

There are 2 page type that currently exist in this application.
1. `default` page, which is gonna include all default AdminLTE like header, menus, sidebar, and footer.
2. `blank` page, which is a literally blank page with no header, menus, sidebar, and footer. for example, login page will use this type of page because  it contains no header, menus, and else.

By default, the page type value is `default`. so you dont have to call this methode if you are using the default page.

```php
$this->template->page_type("blank");
```

----

### Set Page Title

```php
$this->template->page_title("Welcome Page");
```

----

### Use Plugins

Update your list of 3rd parties plugins that you use for your app in `application/configs/plugins.php`

```php
$this->template->plugins("datatables"); 
```

You could also set the parameter as an array

```php
$this->template->plugins(["datatables"]);
```

----

### Set Custom Class

This methode is use if you want to add a custom or additional class to some specific tags. Access the tag classes data in view by calling `$classes` variable.

```php
$this->template->tag_class("body", "hold-transition login-page");
```

----

### Add Custom Page CSS

```php
$this->template->page_css("assets/dist/css/pages/demo.css");
```

You could also set the parameter as an array if you have multiple custom js file for one page

```php
$this->template->page_css([
  "assets/dist/css/pages/demo1.css", 
  "assets/dist/css/pages/demo2.css"
]);
```

----

### Add Custom Page JS

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

----

### Hide Toolbar Content

```php
$this->template->hide_content_toolbar(); // no parameter needed
```

----

### Hide Breadcrums

```php
$this->template->hide_breadcrums(); // no parameter needed
```

----

### Hide Footer

```php
$this->template->hide_footer(); // no parameter needed
```

----

### Hides a couple things

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

----

### Examples

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

Other example

```php
$this->template
  ->page_type('blank')
  ->page_title('Login page')
  ->tag_class('body', 'hold-transition login-page')
  ->load('login');
```

---

# Core MY_Model Usage

Honestly I hate to repeat my self to type the same function again and again across all model file, like insert update delete. Thats why I made this custom core model called `MY_Model`. All the function in this core model, I made it base on what I need in most of my App, like insert, update, delete, and a couple other functions so I don't have to copy and paste it across all Model, which could be not fit with you. So, feel free to not use it if you don't want it and if you don't use it, don't forget to tweak the `Template Library` for the menu part and also the `datatables` example controller.

## Details
- Location: `application/core`
- filename: `MY_Model.php`

## Public Variables

<table>
	<tr>
		<td>Name</td>
		<td>Default</td>
		<td>Description</td>
	</tr>
	<tr>
		<td><code>$db_group</code></td>
		<td>default</td>
		<td>This a database group that had been you set on the config database file, by default the group name is <code>default</code>, but if you have multiple database connection with different group name you can set the group name in here</td>
	</tr>
  <tr>
    <td><code>$db_name</code></td>
    <td><i>NULL</i></td>
    <td>This database name is used only if you want to access different database within the same database group</td>
  </tr>
  <tr>
    <td><code>$table</code> *</td>
    <td></td>
    <td>Current table name that used by the model, this is mandatory</td>
  </tr>
  <tr>
    <td><code>$alias</code></td>
    <td><i>NULL</i></td>
    <td>If you want to set an alias for your table, you can set it here</td>
  </tr>
  <tr>
    <td><code>$id_column_name</code></td>
    <td>id</td>
    <td>We do know that most of table has their own primary id, and usually the column name is <code>id</code>, but if somehow you decided to name the column differently like <code>not_id</code> maybe, then you better set this to that name</td>
  </tr>
  <tr>
    <td><code>$allow_columns</code></td>
    <td><i>NULL</i></td>
    <td>List of allowed column for the table, make sure its in array, once again it must be an array</td>
  </tr>
</table>

## Examples Creating Model extends MY_Model

```php
  // Location: application/models
  // Filename: Users.php

  class Users extends MY_Model {
    public $table = "users";
    public $alias = "u";

    // this is not mandatory, this allowed columns checker will only be running 
    // when its not empty and only when you are calling insert and update function
    public $allowed_columns = [
      'id', 
      'fullname', 
      'username', 
      'password',
      'email', 
      'is_active'
    ];
  }
```

or if you use different database name within the same group connection

```php
  class Users extends MY_Model {
    public $db_name = "finance";
    public $table = "users";
    public $alias = "usr";
  }
```

of if you want to declare a model with different group connection

```php
  class Users extends MY_Model {
    public $db_group = "db_conn_group_2";
    public $table = "users";
    public $alias = "usr";
  }
```

----

## Core Model Fiturs

### Insert Data

Just like the method name, this method is use to insert / create new data to the table. 
This method accept one `array` parameter which should contain at least one of the index below

<table>
  <tr>
    <td>Index</td>
    <td>Type</td>
    <td>Description</td>
  </tr>
  <tr>
    <td><code>data</code></td>
    <td><code>array</code></td>
    <td>Most of the time you will use this index to store the data</td>
  </tr>
  <tr>
    <td><code>data_false</code></td>
    <td><code>array</code></td>
    <td>Use this parameter to prevent data form being escaped</td>
  </tr>
</table>

#### Example

```php
// load the model
$this->load->model('users');

// set all the data
$params = [
  'data' => [
    'fullname' => 'John Doe',
    'email' => 'john_doe@mail.com'
  ],
  'data_false' => [
    'invoice_date' => 'CURDATE()'
  ]
];

// this will be converted to
/**
 * $this->db->set(data)
 *          ->set(data_false, '', false)
 *          ->insert(table_name)
 **/

// calling insert method
$query = $this->users->insert($params);

// check the query status
if(!$query->status) {
  // do something here if its false
} else {
  // do something here if its true
}
```

### Update Data

This update method also only accept one `array` parameter, which contain index below.

**There are no index checker, so becareful with it.**

<table>
  <tr>
    <td>Index</td>
    <td>Type</td>
    <td>Description</td>
  </tr>
  <tr>
    <td><code>data</code></td>
    <td><code>array</code></td>
    <td>Most of the time you will use this index for the data</td>
  </tr>
  <tr>
    <td><code>data_false</code></td>
    <td><code>array</code></td>
    <td>Use this parameter to prevent data form being escaped</td>
  </tr>
  <tr>
    <td><code>where</code></td>
    <td><code>array | string</code></td>
    <td>Most of the time you will use this index to filter the data</td>
  </tr>
  <tr>
    <td><code>where_false</code></td>
    <td><code>array</code></td>
    <td>Use this filter to prevent data from being escaped</td>
  </tr>
  <tr>
    <td><code>where_in</code></td>
    <td><code>array</code></td>
    <td>Generates a WHERE field IN</td>
  </tr>
  <tr>
    <td colspan="3">
      <b>PS: You can add more index variant if you want according to your need</b>
    </td>
  </tr>
</table>

#### Example

````php
// load a model
$this->load->model('users');

// set the method parameter
$params = [
  'data' => [
    'fullname' => 'John Doe',
    'email' => 'john_doe@mail.com'
  ],
  'data_false' => [
    'invoice_date' => 'CURDATE()'
  ],
  'where' => [
    'id' => 1
  ],
  'where_in' => [
    ['column' => 'invoice_type', 'value' => [1, 2, 3]],
    ['column' => 'payment_type', 'value' => [1, 2]],
  ]
];

// this will be converted to
/**
 * $this->db->set(data)
 *          ->set(data_false, '', false)
 *          ->where(where)
 *          ->where_in(1st_where_in_column, 1st_where_in_value)
 *          ->where_in(2st_where_in_column, 2st_where_in_value)   // if you have more where in
 *          ->where_in(n_where_in_column, n_where_in_value)       // if you have more where in
 *          ->update(table)
 **/

// calling the update method
$query = $this->users->update($params);

// check the query status
if(!$query->status) {
  // do something here if its false
} else {
  // do something here if its true
}
````

### Delete Data

This update method also only accept one `array` parameter, which contain index below.

**There are no index checker, so becareful with it.**

<table>
  <tr>
    <td>Index</td>
    <td>Type</td>
    <td>Description</td>
  </tr>
  <tr>
    <td><code>where</code></td>
    <td><code>array</code></td>
    <td>Most of the time you will use this index to filter the data</td>
  </tr>
  <tr>
    <td><code>where_false</code></td>
    <td><code>array</code></td>
    <td>Use this filter to prevent data from being escaped</td>
  </tr>
  <tr>
    <td><code>where_in</code></td>
    <td><code>array</code></td>
    <td>Generates a WHERE field IN</td>
  </tr>
  <tr>
    <td colspan="3">
      <b>PS: You can add more index variant if you want according to your need</b>
    </td>
  </tr>
</table>

#### Example

````php
// load a model
$this->load->model('users');

// set the method parameter
$params = [
  'where' => [
    'group_access' => 1
  ],
  'where_in' => [
    ['column' => 'id', 'value' => [1, 2, 3]],
  ]
];

// this will be converted to
/**
 * $this->db->where(where)
 *          ->where_in(1st_where_in_column, 1st_where_in_value)
 *          ->where_in(n_where_in_column, n_where_in_value)     // if you have more where in
 *          ->update(table)
 **/

// calling the method
$query = $this->users->delete($params);

// check the query status
if(!$query->status) {
  // do something here if its false
} else {
  // do something here if its true
}
````

# Resources

-  Codeigniter <https://codeigniter.com/docs>
-  AdminLTE <https://github.com/ColorlibHQ/AdminLTE>
