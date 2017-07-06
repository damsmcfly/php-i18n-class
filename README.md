# php-i18n-class

A simple PHP class to help you easily translate your website from JSON files.

You can define 2 translations of the same phrase : a singular version, and a plural version.

## Translation files

The JSON translation files work with key/value pairs.

The value can be a string or an array.

**Example :** Translation of the Layout : locales/en/layout/get.json 
```
{
  "welcomemsg": "Welcome to our website",
  "menu": {
    "home": "Homepage",
    "users": "Users"
  },
  "footer": {
    "privacypolicy": "Privacy policy",
    "contact": "Contact",
    "backtotop": "Back to top"
  }
}
```

The value may contain curly placeholders for variable parts.

**Example :** Translation of the User List : locales/en/user/getList.json 
```
{
  "title": "User list",
  "totalusers": {
    "sing" : "There is {0} user in the database.",
    "plur" : "There are {0} users in the database."
  },
  "totaladmins": {
    "sing" : "There is {0} admin in the database.",
    "plur" : "There are {0} admins in the database."
  }
}
```

## Using the class

**Require the i18n Class**
```php
<?php
require 'src/i18n.class.php';
```
**Define your language and create your i18n objects**
```php
<?php
$lang = 'en';
$l = new i18n($lang, "layout/get");     // $l : translations of the Layout
$u = new i18n($lang, "user/getList");   // $u : translations of the User List
```

**getPhrase : Get the translation of your phrase from its key**
```php
<?php
echo $l->getPhrase('welcomemsg');  // Get translation
echo $l->ph('welcomemsg');         // Alias for getPhrase
// will print : 'Welcome to our website'
```

The dot syntax helps you reach the JSON child node easily, if needed.
```php
<?php
echo $l->ph('menu.home'); 
// will print : 'Homepage';
```

**getPlural : Get the pluralized translation of your phrase from its key**
```php
<?php
$nbUsers = 666;
echo $u->getPlural('totalusers', $nbUsers);   // Get pluralized translation
echo $u->pl('totalusers', $nbUsers);          // Alias for getPlural
// will both print : 'There are 666 users in the database.';


$nbAdmins = 1;
echo $u->getPlural('totaladmins', $nbAdmins);
echo $u->pl('totaladmins', $nbAdmins);
// will both print : 'There is 1 admin in the database.';
```

## More examples

Feel free to [download the zip file](https://github.com/damsmcfly/php-i18n-class/archive/master.zip) or [open the index.php file](https://github.com/damsmcfly/php-i18n-class/blob/master/index.php).

## Inspiration

Thanks to mgkimsal for his class [mgkimsal/php-i18n-class](https://github.com/mgkimsal/php-i18n-class) which was used as a starting point.
