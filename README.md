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
  * [Core Model Fiturs](#core-model-fiturs)
    * [Query SQL](#query-sql)
      * [Example](#example)
    * [Insert Data](#insert-data)
      * [Example](#example-1)
    * [Update Data](#update-data)
      * [Example](#example-2)
    * [Delete Data](#delete-data)
      * [Example](#example-3)
    * [Get All Data](#get-all-data)
      * [Example](#example-4)
    * [Find By ID](#find-by-id)
      * [Example](#example-5)
    * [Find By](#find-by)
      * [Example](#example-6)
    * [Find Data](#find-data)
      * [Example](#example-7)
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

### Query SQL

Well it just literaly an sql query. LOL

#### Example

````php
// load model
$this->load->model('users');

// sql query
$sql = "SELECT id, fullname FROM users WHERE is_active = 1";

// call the method
$query = $this->users->query($sql);

// check the query status
if(!$query->status) {
  // do something here if its false
} else {
  // do something here if its true
}
````

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
 *          ->insert(table)
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

----

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
  'where_false' => [
    'YEAR(invoice_date)' => 2024
  ],
  'where_in' => [
    ['invoice_type', [1, 2, 3]],                     // index 0 as column and index 1 as value
    ['column' => 'payment_type', 'value' => [1, 2]], // you can also declare it with column and value key
    // it will prioritize index 0 and 1 first rather than column and value key
  ]
];

// this will be converted to
/**
 * $this->db->set(data)
 *          ->set(data_false, '', false)
 *          ->where(where_value)
 *          ->where(where_false_value, '', false)
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

----

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
  'where_false' => [
    'YEAR(birthdate)' => 1989
  ],
  'where_in' => [
    ['id', [1, 2, 3]],                          // index 0 as column and index 1 as value
    ['column' => 'id', 'value' => [1, 2, 3]],   // you can also declare it with column and value key
    // it will prioritize index 0 and 1 first rather than column and value key
  ]
];

// this will be converted to
/**
 * $this->db->where(where_value)
 *          ->where(where_false_value, ''. false)
 *          ->where_in(1st_where_in_column, 1st_where_in_value)
 *          ->where_in(n_where_in_column, n_where_in_value)     // if you have more where in
 *          ->delete(table)
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

----

### Get All Data

This method is use to get all the data in the table without any filter and no LIMIT, with below parameter

**Do not use it on the table with huge amount of data in it**

<table>
  <tr>
    <td>Variable</td>
    <td>Type</td>
    <td>Default</td>
    <td>Description</td>
  </tr>
  <tr>
    <td><code>$column</code></td>
    <td><code>string | array</code></td>
    <td><code>*</code></td>
    <td>List column to show</td>
  </tr>
  <tr>
    <td><code>$escape</code></td>
    <td><code>boolean | NULL</code></td>
    <td><code>NULL</code></td>
    <td>Escape string</td>
  </tr>
</table>

#### Example

````php
// load a model
$this->load->model('users');

// calling the method
$query = $this->users->get_all();

// this will be converted to
/**
 * $this->db->select('*', NULL)
 *          ->from(users)
 *          ->get()
 **/

// check the query status
if(!$query->status) {
  // do something here if its false
} else {
  // do something here if its true
}
````

----

### Find By ID

This method is use to get data by primary key id column, with below parameter

<table>
  <tr>
    <td>Variable</td>
    <td>Type</td>
    <td>Default</td>
    <td>Description</td>
  </tr>
  <tr>
    <td><code>$value</code> *</td>
    <td><code>integer | string</code></td>
    <td></td>
    <td>Well its literally the value of the ID of course</td>
  </tr>
  <tr>
    <td><code>$column_name</code></td>
    <td><code>string</code></td>
    <td><code>id</code></td>
    <td>Primary key id column name</td>
  </tr>
  <tr>
    <td><code>$select</code></td>
    <td><code>array|string</code></td>
    <td><code>*</code></td>
    <td>List of column to show</td>
  </tr>
  <tr>
    <td><code>$escape</code></td>
    <td><code>boolean | NULL</code></td>
    <td><code>NULL</code></td>
    <td>Escape String for select</td>
  </tr>
  <tr>
    <td><code>$distinct</code></td>
    <td><code>boolean</code></td>
    <td><code>FALSE</code></td>
    <td>Distinct the result, somehow I need this parameter.</td>
  </tr>
</table>

#### Example

````php
// load a model
$this->load->model('users');

// calling the method
$query = $this->users->find_by_id(13);

// this will be converted to
/**
 * $this->db->select('*', NULL)
 *          ->from('users')
 *          ->where('id', 13)
 *          ->get()
 **/

// check the query status
if(!$query->status) {
  // do something here if its false
} else {
  // do something here if its true
}
````

----

### Find By

This method is use to get data by custom column, with below parameter

<table>
  <tr>
    <td>Variable</td>
    <td>Type</td>
    <td>Default</td>
    <td>Description</td>
  </tr>
  <tr>
    <td><code>$column_name</code> *</td>
    <td><code>string</code></td>
    <td></td>
    <td>Column name</td>
  </tr>
  <tr>
    <td><code>$value</code> *</td>
    <td><code>integer|string</code></td>
    <td></td>
    <td>Primary key id column name</td>
  </tr>
  <tr>
    <td><code>$select</code></td>
    <td><code>array|string</code></td>
    <td><code>*</code></td>
    <td>List of column to show</td>
  </tr>
  <tr>
    <td><code>$escape</code></td>
    <td><code>boolean | NULL</code></td>
    <td><code>NULL</code></td>
    <td>Escape String for select</td>
  </tr>
</table>

#### Example

````php
// load a model
$this->load->model('users');

// calling the method
$query = $this->users->find_by('is_active', 1);

// this will be converted to
/**
 * $this->db->select('*', NULL)
 *          ->from('users')
 *          ->where('is_active', 1)
 *          ->get()
 **/

// check the query status
if(!$query->status) {
  // do something here if its false
} else {
  // do something here if its true
}
````

----

### Find Data

This update method only accept 2 parameter: 

1. `$configs` type `array`,
2. `$last_query` type `boolean` default `false`

With `$configs` contain index below:

**There are no index checker, so becareful with it.**

<table>
  <tr>
    <td>Index</td>
    <td>Type</td>
    <td>Default</td>
    <td>Description</td>
  </tr>
  <tr>
    <td><code>select</code></td>
    <td><code>array|string</code></td>
    <td><code>id_column_name</code></td>
    <td>List of column to show using select query builder, if you didn't declare it, it will fill with primary key id that been declare on the model</td>
  </tr>
  <tr>
    <td><code>distinct</code></td>
    <td><code>boolean</code></td>
    <td><code>false</code></td>
    <td>Using distinct query builder</td>
  </tr>
  <tr>
    <td><code>escape</code></td>
    <td><code>boolean | NULL</code></td>
    <td><code>NULL</code></td>
    <td>prevent escape string for selected column</td>
  </tr>
  <tr>
    <td><code>join</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>Using join quiery builder, with only one table</td>
  </tr>
  <tr>
    <td><code>joins</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>using join query builder, with multiple table</td>
  </tr>
  <tr>
    <td><code>where</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>Using where query builder</td>
  </tr>
  <tr>
    <td><code>where_false</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>Using where query builder with escape string as FALSE</td>
  </tr>
  <tr>
    <td><code>where_in</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>Using where_in query builder</td>
  </tr>
  <tr>
    <td><code>where_not_in</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>Using where_not_in query builder</td>
  </tr>
  <tr>
    <td><code>or_where</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>Using or_where query builder</td>
  </tr>
  <tr>
    <td><code>or_where_in</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>Using or_where_in query builder</td>
  </tr>
  <tr>
    <td><code>or_where_not_in</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>Using or_where_not_in query builder</td>
  </tr>
  <tr>
    <td><code>like</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>Using like query builder</td>
  </tr>
  <tr>
    <td><code>or_like</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>Using or_like query builder</td>
  </tr>
  <tr>
    <td><code>like_array</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>Using like query builder but passing array as data</td>
  </tr>
  <tr>
    <td><code>or_like_array</code></td>
    <td><code>array</code></td>
    <td></td>
    <td>Using or_like query builder but passing array as data</td>
  </tr>
  <tr>
    <td><code>order_by</code></td>
    <td><code>string | array</code></td>
    <td></td>
    <td>Using order_by query builder with string value</td>
  </tr>
  <tr>
    <td><code>group_by</code></td>
    <td><code>array | string</code></td>
    <td></td>
    <td>Using group_by query builder</td>
  </tr>
  <tr>
    <td><code>limit</code></td>
    <td><code>integer | array</code></td>
    <td></td>
    <td>Using limit query builder</td>
  </tr>
  <tr>
    <td><code>table_alias</code></td>
    <td><code>string</code></td>
    <td></td>
    <td>Using different table alias</td>
  </tr>
  <tr>
    <td><code>table</code></td>
    <td><code>string</code></td>
    <td></td>
    <td>Using other table as pivot</td>
  </tr>
  <tr>
    <td><code>compile_select</code></td>
    <td><code>boolean</code></td>
    <td></td>
    <td>Using get_compiled_select query builder</td>
  </tr>
  <tr>
    <td><code>count_all_results</code></td>
    <td><code>boolean</code></td>
    <td></td>
    <td>To return count all result value</td>
  </tr>
  <tr>
    <td><code>count_all</code></td>
    <td><code>boolean</code></td>
    <td></td>
    <td>To return count all value</td>
  </tr>
  <tr>
    <td colspan="4">
      <b>PS: You can add more index variant if you want according to your need</b>
    </td>
  </tr>
</table>

#### Example

````php
// load a model
$this->load->model('users');

// set the configs parameter
// remember you don't have to use all of it, use it according to your need
$configs = [
  'select' => ['id', 'name', 'email'],
  // or
  'select' => 'id, name, email',

  'distinct' => true, // or false - default false
  'escape' => false, // or NULL - default false

  // joining with one table
  'join' => [
    'user_privilege as up',
    'up.user_id = u.id',
    'inner',
    FALSE // or NULL or TRUE or just exclude it
  ],
  // or
  'join' => [
    'table' => 'user_privilege as up',
    'on' => 'up.user_id = u.id',
    'type' => 'inner',
    'escape' => FALSE // or NULL or TRUE or just exclude it
  ],

  // joining multiple table
  'joins' => [
    [
      'user_privilege as up',
      'up.user_id = u.id',
      'inner',
    ],
    [
      'table' => 'user_invoice as ui',
      'on' => 'ui.user_id = u.id',
      'type' => 'inner',
    ]
  ],

  'where' => [
    'id' => 2
  ],

  'where_false' => [
    'YEAR(u.birthdate)' => 1998
  ],

  'where_in' => [
    [
      'id',       // column
      [1, 2, 3],  // value
      NULL,       // escape, you can exclude this
    ],
    [
      'column' => 'invoice_type',
      'value' => 3,
      'escape' => NULL, // you can exclude this
    ]
  ],

  'where_not_in' => [
    [
      'id',       // column
      [1, 2, 3],  // value
      NULL,       // escape, you can exclude this
    ],
    [
      'column' => 'invoice_type',
      'value' => 3,
      'escape' => NULL, // you can exclude this
    ]
  ],

  'or_where' => [
    'id' => 2
  ],

  'or_where_false' => [
    'YEAR(u.birthdate)' => 1998
  ],

  'or_where_in' => [
    [
      'id',       // column
      [1, 2, 3],  // value
      NULL,       // escape, you can exclude this
    ],
    [
      'column' => 'invoice_type',
      'value' => 3,
      'escape' => NULL, // you can exclude this
    ]
  ],

  'or_where_not_in' => [
    [
      'id',       // column
      [1, 2, 3],  // value
      NULL,       // escape, you can exclude this
    ],
    [
      'column' => 'invoice_type',
      'value' => 3,
      'escape' => NULL, // you can exclude this
    ]
  ],

  'like' => [
    [
      'username', 
      'john', 
      'both' // you can exclude this
    ],
    [
      'column' => 'email',
      'keyword' => 'doe',
      'type' => 'both', // you can exclude this
    ]
  ],

  'or_like' => [
    [
      'username', 
      'john', 
      'both' // you can exclude this
    ],
    [
      'column' => 'email',
      'keyword' => 'doe',
      'type' => 'both', // you can exclude this
    ]
  ],

  'like_array' => [
    'username' => 'john',
    'email' => 'doe'
  ],

  'or_like_array' => [
    'username' => 'john',
    'email' => 'doe'
  ],

  'order_by' => 'username ASC, email DESC',
  // or
  'order_by' => [
    [
      'username', // column
      'ASC'       // direction
    ],
    [
      'column' => 'email',
      'dir' => 'DESC'
    ]
  ],

  'group_by' => 'id',
  // or
  'group_by' => ['id', 'username'],

  'limit' => 10,
  // or
  'limit' => [
    10, // length
    20  // start / offset
  ],
  // or
  'limit' => [
    'length' => 10,
    'start' => 20
  ],

  'table_alias' => 'usr', // make sure if you set this up then use this alias

  'table' => 'settings as s', // its kinda rare to use it. I use it when I'm lazy to load the model its self so I just using the existing model that had been loaded but overide the table name

  'compile_select' => true, // you can exclude this, default is false,

  'count_all_result' => true, // will return integer

  'count_all' => true, // will return integer
];

// calling the method
$query = $this->users->find($configs);

// check the query status
// if query is fail or num_rows is 0, status value will be false
if(!$query->status) {
  // do something here if its false
} else {
  // do something here if its true
}
````

# Resources

-  Codeigniter <https://codeigniter.com/docs>
-  AdminLTE <https://github.com/ColorlibHQ/AdminLTE>
