<?php

require_once(dirname(__FILE__).'/../lime/lime.php');
 
$h = new lime_harness(array(
  'force_colors' => isset($argv) && in_array('--color', $argv),
  'verbose' => isset($argv) && in_array('--verbose', $argv),
));
$h->base_dir = realpath(dirname(__FILE__).'/..');
 
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__FILE__).'/../unit'), RecursiveIteratorIterator::LEAVES_ONLY) as $file)
{
  if (preg_match('/Test\.php$/', $file))
  {
    $h->register($file->getRealPath());
  }
}
 
exit($h->run() ? 0 : 1);
