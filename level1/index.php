<<<<<<< HEAD
<?php

header ("Content-Type: text/html; charset=utf-8");
$fileName = './counter.txt';

if (!file_exists($fileName)) {
	file_put_contents($fileName, 0);
}

$counter = (int) file_get_contents($fileName);

if (@$_REQUEST['button1']) {
    file_put_contents($fileName, ++$counter);
}

echo <<<HTML
 <head>
  <title>PHP Clicker</title>
 </head>
 <body>
 <form>
  <button type="submit" name="button1" style="text-align: center; background-color:#708d9e;"><button>Hello, click me please</button>
  <h2>You pressed this button $counter times</h2>
</form>
 </body>
HTML;
=======
<?php

header ("Content-Type: text/html; charset=utf-8");
$fileName = './counter.txt';

if (!file_exists($fileName)) {
	file_put_contents($fileName, 0);
}

$counter = (int) file_get_contents($fileName);

if (@$_REQUEST['button1']) {
    file_put_contents($fileName, ++$counter);
}

echo <<<HTML
 <head>
  <title>PHP Clicker</title>
 </head>
 <body>
 <form>
  <button type="submit" name="button1" style="text-align: center; background-color:#708d9e;"><button>Hello, click me please</button>
  <h2>You pressed this button $counter times</h2>
</form>
 </body>
HTML;
>>>>>>> 6144601d9e0f67893bf8e01bac1145d6393afe23
?>