<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex">
  <title>Simple PHP Git deploy script</title>
  <style>
    body { padding: 0 1em; background: #222; color: #fff; }
    h2, .error { color: #c33; }
    .prompt { color: #6be234; }
    .command { color: #729fcf; }
    .output { color: #999; }
  </style>
</head>
<body>
  <pre>
    Checking the environment ...

    Running as <b><?php echo trim(shell_exec('whoami')); ?></b>.
<?php
$requiredBinaries = array('git', 'rsync');
if (defined('BACKUP_DIR') && BACKUP_DIR !== false) {
  $requiredBinaries[] = 'tar';
  if (!is_dir(BACKUP_DIR) || !is_writable(BACKUP_DIR)) {
    die(sprintf('<div class="error">BACKUP_DIR `%s` does not exists or is not writeable.</div>', BACKUP_DIR));
  }
}
if (defined('USE_COMPOSER') && USE_COMPOSER === true) {
  $requiredBinaries[] = 'composer --no-ansi';
}
foreach ($requiredBinaries as $command) {
  $path = trim(shell_exec('which '.$command));
  if ($path == '') {
    die(sprintf('<div class="error"><b>%s</b> not available. It needs to be installed on the server for this script to work.</div>', $command));
  } else {
    $version = explode("\n", shell_exec($command.' --version'));
    printf('<b>%s</b> : %s'."\n"
      , $path
      , $version[0]
      );
  }
}

$tmp = array();
$command = 'eval `ssh-agent -s`;/usr/bin/expect /var/www/deploy/ssh.sh;ssh-add -l';
  exec($command.' 2>&1', $tmp, $return_code); // Execute the command
  echo "<pre>";
  var_dump($tmp);
  echo "</pre>";
/*
  $tmp = array();
  exec("ssh-add 2>&1", $tmp, $return_code);
  echo "<pre>";
  var_dump($tmp);
  echo "</pre>";*/