<?php
include_once('Fkc.class.php');

// Login settings
$email = 'eridem@gmail.com';
$password = 'v';

// Creating a new instance of FKC API, logining and getting friends.
$fkc = new Fkc();
$fkc->login($email, $password);
$user = $fkc->getUser();
$friends = $user->get('Friends');
$guestbook = $user->get('Guestbook');
$photos = $user->get('photos');

?>

<html>
	<head><title>Friendly Korea Community API</title></head>
	<body>
		<h1>Example 01 (Debug)</h1>
		<h2>Personal information</h2>
		<table width="100%" border="0">
		<tr>
			<td width="30%"><img src="<? echo $user->get('Photo'); ?>" width="200"></td>
			<td width="70%">
				<table width="100%" border="0">
					<tr><td width="35%"><b>Id:</b></td><td><?php echo $user->get('Id'); ?></td></tr>
					<tr><td width="35%"><b>Name:</b></td><td><?php echo $user->get('Name'); ?></td></tr>
					<tr><td width="35%"><b>Surname:</b></td><td><?php echo $user->get('FamilyName'); ?></td></tr>
					<tr><td width="35%"><b>Email:</b></td><td><?php echo $user->get('Email'); ?></td></tr>
					<tr><td width="35%"><b>Gender:</b></td><td><?php echo $user->get('Gender'); ?></td></tr>
					<tr><td width="35%"><b>Born Date:</b></td><td><?php echo $user->get('BornDate'); ?></td></tr>
					<tr><td width="35%"><b>Country:</b></td><td><?php echo $user->get('Country'); ?></td></tr>
					<tr><td width="35%"><b>Residential Country:</b></td><td><?php echo $user->get('ResidentialCountry'); ?></td></tr>
					<tr><td width="35%"><b>Residential City:</b></td><td><?php echo $user->get('ResidentialCity'); ?></td></tr>
					<tr><td width="35%"><b>Profession:</b></td><td><?php echo $user->get('Profession'); ?></td></tr>
					<tr><td width="35%"><b>Interests:</b></td><td><?php echo $user->get('Interests'); ?></td></tr>
					<tr><td width="35%"><b>About:</b></td><td><?php echo $user->get('About'); ?></td></tr>
					<tr><td width="35%"><b>Favorite Movie:</b></td><td><?php echo $user->get('FavoriteMovie'); ?></td></tr>
					<tr><td width="35%"><b>Favorite Entertainent:</b></td><td><?php echo $user->get('FavoriteEntertainent'); ?></td></tr>
					<tr><td width="35%"><b>Favorite Drama:</b></td><td><?php echo $user->get('FavoriteDrama'); ?></td></tr>
					<tr><td width="35%"><b>Favorite Place:</b></td><td><?php echo $user->get('FavoritePlace'); ?></td></tr>
					<tr><td width="35%"><b>Favorite Food:</b></td><td><?php echo $user->get('FavoriteFood'); ?></td></tr>
				</table>
			</td>
		</table>

<table width="100%" border="1">
<?php foreach ($guestbook as $message) : ?>
<tr><td width="20%"><?php echo $message->getUserId(); ?></td><td width="20%"><?php echo $message->getDate(); ?></td><td width="60%"><?php echo $message->getText(); ?></td></tr>
<?php endforeach; ?>
</table>

<table width="100%" border="1">
<?php foreach ($photos as $photo) : ?>
<tr><td><img src="<?php echo $photo->getPhotoUrl();?>" width="50" /><br /><div align="center"><?php echo $photo->getDate(); ?></div></td></tr>
<?php endforeach; ?>
</table>

		<h2>Friends</h2>
		<table width="100%" border="1">
			<tr><td width="30%">Information</td><td width="70%">Photo</td></tr>
			<?php $friend = $friends[0]; ?>
			<?php //foreach ($friends as $friend) : ?>
			<tr>
				<td width="70%" valign="top">
				<table width="100%" border="0">
					<tr><td width="35%"><b>Id:</b></td><td><?php echo $friend->get('Id'); ?></td></tr>
					<tr><td width="35%"><b>Name:</b></td><td><?php echo $friend->get('Name'); ?></td></tr>
					<tr><td width="35%"><b>Surname:</b></td><td><?php echo $friend->get('FamilyName'); ?></td></tr>
					<tr><td width="35%"><b>Email:</b></td><td><?php echo $friend->get('Email'); ?></td></tr>
					<tr><td width="35%"><b>Gender:</b></td><td><?php echo $friend->get('Gender'); ?></td></tr>
					<tr><td width="35%"><b>Born Date:</b></td><td><?php echo $friend->get('BornDate'); ?></td></tr>
					<tr><td width="35%"><b>Country:</b></td><td><?php echo $friend->get('Country'); ?></td></tr>
					<tr><td width="35%"><b>Residential Country:</b></td><td><?php echo $friend->get('ResidentialCountry'); ?></td></tr>
					<tr><td width="35%"><b>Residential City:</b></td><td><?php echo $friend->get('ResidentialCity'); ?></td></tr>
					<tr><td width="35%"><b>Profession:</b></td><td><?php echo $friend->get('Profession'); ?></td></tr>
					<tr><td width="35%"><b>Interests:</b></td><td><?php echo $friend->get('Interests'); ?></td></tr>
					<tr><td width="35%"><b>About:</b></td><td><?php echo $friend->get('About'); ?></td></tr>
					<tr><td width="35%"><b>Favorite Movie:</b></td><td><?php echo $friend->get('FavoriteMovie'); ?></td></tr>
					<tr><td width="35%"><b>Favorite Entertainent:</b></td><td><?php echo $friend->get('FavoriteEntertainent'); ?></td></tr>
					<tr><td width="35%"><b>Favorite Drama:</b></td><td><?php echo $friend->get('FavoriteDrama'); ?></td></tr>
					<tr><td width="35%"><b>Favorite Place:</b></td><td><?php echo $friend->get('FavoritePlace'); ?></td></tr>
					<tr><td width="35%"><b>Favorite Food:</b></td><td><?php echo $friend->get('FavoriteFood'); ?></td></tr>
					<tr><td width="35%"><b>Guestbook:</b></td><td>
						<table width="100%" border="1">
						<?php
						$guestbook = $friend->get('Guestbook');
						foreach ($guestbook as $message) : ?>
						<tr><td width="20%"><?php echo $message->getUserId(); ?></td><td width="20%"><?php echo $message->getDate(); ?></td><td width="60%"><?php echo $message->getText(); ?></td></tr>
						<?php endforeach; ?>
						</table>
					</td></tr>
				</table>
				</td>
				<td width="30%"><img src="<?php echo $friend->get('Photo'); ?>" width="200"></td>
			</tr>
			<?php// endforeach; ?>
		</table>
		<p><? echo html_entity_decode($fkc->getHtmlLicence()); ?></p>
	</body>
</html>
