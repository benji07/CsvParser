<?php
 
require_once(dirname(__FILE__).'/../lime/lime.php');
 
$h = new lime_harness(new lime_output(isset($argv) && in_array('--color', $argv)));
$h->base_dir = realpath(dirname(__FILE__).'/..');
 
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__FILE__).'/../unit'), RecursiveIteratorIterator::LEAVES_ONLY) as $file)
{
  if (preg_match('/Test\.php$/', $file))
  {
    $h->register($file->getRealPath());
  }
}
 
$c = new lime_coverage($h);
$c->extension = '.php';
$c->verbose = true;
$c->base_dir = realpath(dirname(__FILE__).'/../../lib');
 
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__FILE__).'/../../lib'), RecursiveIteratorIterator::LEAVES_ONLY) as $file)
{
  if (preg_match('/\.php$/', $file))
  {
    $c->register($file->getRealPath());
  }
}
 
$c->run();