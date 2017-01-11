This is an old application I did when young and learning PHP 👶 I just imported to GitHub 💾

I am not sure if it is working 🤞 or worthy anymore 🗑️😌

More info: <http://eridem.net/friendly-korea-community-api/>

Example of code:

```php
<?php
include_once('Fkc.class.php');
 
// Login settings
$email = '[YOUR_FKC_USER_EMAIL]';
$password = '[YOUR_FKC_USER_PASSWORD]';
 
// Creating a new instance of FKC API
$fkc = new Fkc();
 
// Logining into FKC
if (!$fkc->login($email, $password))
{
  echo "It is a wrong email or password.";
  die();
}
 
// Getting a object of FkcUser that represents our user.
$me = $fkc->getUser();
 
// Getting our friends. It's and array of FkcFriend.
$friends = $me->get('Friends');
 
// Showing our information
echo "<h1>Our information: " . $me->get('Name') . " " . $me->get('FamilyName') . "</h1>" .
  "&nbsp; <b>Id</b>: " . $me->get('Id') . "<br />" .
  "&nbsp; <b>Email</b>: " . $me->get('Email') . "<br />" .
  "&nbsp; <b>Gender</b>: " . $me->get('Gender') . "<br />" .
  "&nbsp; <b>Born Date</b>: " . $me->get('BornDate') . "<br />" .
  "&nbsp; <b>Country</b>: " . $me->get('Country') . "<br />" .
  "&nbsp; <b>Residential Country</b>: " . $me->get('ResidentialCountry') . "<br />" .
  "&nbsp; <b>Residential City</b>: " . $me->get('ResidentialCity') . "<br />" .
  "&nbsp; <b>Profession</b>: " . $me->get('Profession') . "<br />" .
  "&nbsp; <b>Interests</b>: " . $me->get('Interests') . "<br />" .
  "&nbsp; <b>About me</b>: " . $me->get('About') . "<br />" .
  "&nbsp; <b>Favorite Movie</b>: " . $me->get('FavoriteMovie') . "<br />" .
  "&nbsp; <b>Favorite Entertainent</b>: " . $me->get('FavoriteEntertainent') . "<br />" .
  "&nbsp; <b>Favorite Drama</b>: " . $me->get('FavoriteDrama') . "<br />" .
  "&nbsp; <b>Favorite Place</b>: " . $me->get('FavoritePlace') . "<br />" .
  "&nbsp; <b>Favorite Food</b>: " . $me->get('FavoriteFood') . "<br />" .
  "&nbsp; <b>Photo URL</b>: " . $me->get('Photo') . "<br /><br />";
 
// Showing friends information
echo "<h1>My friends</h1><br />";
foreach ($friends as $friend)
{
  echo "<h2>" . $friend->get('Name') . " " . $friend->get('FamilyName') . "</h2>" .
    "&nbsp; <b>Id</b>: " . $friend->get('Id') . "<br />" .
    "&nbsp; <b>Email</b>: " . $friend->get('Email') . "<br />" .
    "&nbsp; <b>Gender</b>: " . $friend->get('Gender') . "<br />" .
    "&nbsp; <b>Born Date</b>: " . $friend->get('BornDate') . "<br />" .
    "&nbsp; <b>Country</b>: " . $friend->get('Country') . "<br />" .
    "&nbsp; <b>Residential Country</b>: " . $friend->get('ResidentialCountry') . "<br />" .
    "&nbsp; <b>Residential City</b>: " . $friend->get('ResidentialCity') . "<br />" .
    "&nbsp; <b>Profession</b>: " . $friend->get('Profession') . "<br />" .
    "&nbsp; <b>Interests</b>: " . $friend->get('Interests') . "<br />" .
    "&nbsp; <b>About me</b>: " . $friend->get('About') . "<br />" .
    "&nbsp; <b>Favorite Movie</b>: " . $friend->get('FavoriteMovie') . "<br />" .
    "&nbsp; <b>Favorite Entertainent</b>: " . $friend->get('FavoriteEntertainent') . "<br />" .
    "&nbsp; <b>Favorite Drama</b>: " . $friend->get('FavoriteDrama') . "<br />" .
    "&nbsp; <b>Favorite Place</b>: " . $friend->get('FavoritePlace') . "<br />" .
    "&nbsp; <b>Favorite Food</b>: " . $friend->get('FavoriteFood') . "<br />" .
    "&nbsp; <b>Photo URL</b>: " . $friend->get('Photo') . "<br /><br />";
}
?>
```