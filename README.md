# php-i18n-class

A simple PHP class to help you easily translate your website from JSON files.

You can define 2 versions of the same phrase : a singular version, and a plural version.

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
```
require 'src/i18n.class.php';
```
**Define your language and create your i18n objects**
```
$lang = 'en';
$l = new i18n($lang, "layout/get");     // $l : translations of the Layout
$u = new i18n($lang, "user/getList");   // $u : translations of the User List
```

**Get the translated version of your phrase with getPhrase**
```
// The dot syntax helps you reach the child of your json parent element.
echo $l->getPhrase('menu.home');        // Get translated phrase from key
echo $l->ph('menu.home');               // Alias for getPhrase

// will both print : 'Homepage';
```

**Get the pluralized translated version of your phrase with getPlural**
```
$nbUsers    = 666;
echo $u->getPlural('totalusers', $nbUsers);    	// Get pluralized translated phrase from key
echo $u->pl('totalusers', $nbUsers);    	// Alias for getPlural

// will both print : 'There are 666 users in the database.';


$nbAdmins   = 1;
echo $u->getPlural('totaladmins', $nbAdmins);   // Get pluralized translated phrase from key
echo $u->pl('totaladmins', $nbAdmins);    	// Alias for getPlural

// will both print : 'There is 1 admin in the database.';
```

## More examples

Feel free to download the zip file.

## Inspiration

Thanks to mgkimsal for his class [mgkimsal/php-i18n-class](https://github.com/mgkimsal/php-i18n-class) which was used as a starting point.
