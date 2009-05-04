<?php
include_once('Fkc.class.php');

// Login settings
$email = 'eridem@gmail.com';
$password = 'v';

// Creating a new instance of FKC API, logining and getting friends.
$fkc = new Fkc();
$fkc->login($email, $password);
$user = $fkc->getUser();
$friends = $fkc->getFriends();
?>

<html>
	<head><title>Friendly Korea Community API</title></head>
	<body>
		<p><? echo html_entity_decode($fkc->getHtmlLicence()); ?></p>
		<h1>Example 01 (Debug)</h1>
		<h2>Personal information</h2>
		<p>Email: <? echo $email; ?></p>
		<p>Name: <? echo $user->getName(); ?></p>
		<p>Family name: <? echo $user->getFamilyName(); ?></p>
		<p>Gender: <? echo $user->getGender(); ?></p>
		<p>Country: <? echo $user->getCountry(); ?></p>
		<p>City: <? echo $user->getCity(); ?></p>
		<p>Photo: <img src="<? echo $user->getPhoto(); ?>" width="200" /></p>
		<h2>Friends</h2>
		<p>
			<table width="100%" border="1">
				<tr><td width="30%">Name</td><td width="70%">Photo</td></tr>
				<?php foreach ($friends as $friend) : ?>
				<tr>
					<td width="30%"><?php echo $friend->getFullName(); ?></td>
					<td width="30%"><img src="<?php echo $friend->getPhoto(); ?>" width="200"></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</p>
	</body>
</html>
