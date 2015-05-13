<?php
/*===================================================
| PHP URL Shortener | MySQLi OOP Edition
| ###################################################
| This code is released under the DBAD License.
| You are free to use this code wherever you wish
| as long as all credits remain intact. You are
| using this script at your own risk, and the 
| developer is not liable for any damage or loss.
| ###################################################
| Coded by: Chenaho Media for SoShort URL Shortener
| Developer: Liam McGrath (https://chenaho.me)
| https://github.com/MrChenaho/shortphpurls
| https://soshort.me | SoShort URL Shortener
===================================================*/

/* Let's include the SQL Engine! */
require_once('mysqli.php');
error_reporting(1);

/* Let's check if they're wanting to be redirected */
if(!empty($_GET['url']))
{
	/* Quickly filter the input */
	$short = $mysqli->real_escape_string($_GET['url']);
	/* Checks to see if the short URL exists */
	if(CheckShort($short, $mysqli))
	{
		/* The short URL exists, let's redirect them to the full URL! */
		$destination = GrabUrl($short, $mysqli);
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: $destination");
		die();
	} else {
		/* The short URL does NOT exists.. May have been deleted! */
		header("Location: /");
		die();
	}
}

if(isset($_POST['url']))
{
	/* Predefine the variables. */
	$url = $mysqli->real_escape_string($_POST['url']);
	$time = time();
	$ip = $_SERVER['REMOTE_ADDR'];
	/* This will generate a random string for the Short URL! */
	$short = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789$@&'), 0, 6);
	
	/* Checks to see if the generated short URL exists, if so, we're going to have to re-generate the code! */
	if(CheckShort($short, $mysqli))
	{
		$short .= substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789$@&'), 0, 2);
	}
	
	/* Has the URL already been shortened before? */
	if(IsShortened($url, $mysqli))
	{
		/* Why insert a new row? Just grab the existing! */
		$already = GrabAlreadyShortened($url, $mysqli);
		$redirect = ("?new=$already");
		header("Location: $redirect");
		die();
	}
	
	if(filter_var($url, FILTER_VALIDATE_URL))
	{
		/* Run the query! */
		$mysqli->query("INSERT INTO urls (url, timestamp, ip, url_short) VALUES ('" . $url . "', '" . $time . "', '" . $ip . "', '" . $short . "')") or die($mysqli->error);
		$redirect = ("?new=$short");
		header("Location: $redirect");
		die();
		
	} else {
		header("Location: /invalid");
		die();
	}
}

?>
<!-- Powered by PHP URL Shortener 
Coded by: Chenaho Media for SoShort URL Shortener
Developer: Liam McGrath (https://chenaho.me)
https://github.com/MrChenaho/shortphpurls
https://soshort.me | SoShort URL Shortener -->
<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>SoShort Me | Short URLs for anyone!</title>
<LINK REL=StyleSheet HREF="style.css" TYPE="text/css" MEDIA=screen>
<meta name="robots" content="noindex,follow" />
</head>
<body>
  <div class="container">
    <div class="login">
      <h1>SoShort your URL</h1>
      <form method="post" action="">
        <p><input type="text" name="url" value="" placeholder="https://"></p>
        <!--<p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Public URL
          </label>
        </p>-->
        <p class="submit"><input type="submit" name="commit" value="Shorten"></p>
      </form>
    </div>
	
<?php $new = $mysqli->real_escape_string($_GET['new']); if (!empty($new) && CheckShort($new, $mysqli)) { ?> <br />
<div class="login">
      <h1>Your shortened URL</h1>
		<p><url><a href="https://soshort.me/<?php echo $new; ?>" target="_blank">https://soshort.me/<?php echo $new; ?></a></url></p>
		</div>
<?php } ?>

    <div class="login-help">
      <p>copyright &copy; <b>soshort</b>, a <a href="https://chenaho.me" target="_new">Chenaho Media</a> company.</p>
    </div>
  </div>
</body>
</html>
