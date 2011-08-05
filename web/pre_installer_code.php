<?php 
// this file can not ve viewed unless it's included from install.php or install_dev.php
session_start();
if(!isset($included_in_installer))
{
  die('You\'re attempting to access this file the wrong way.');
}

if(isset($_REQUEST['sf_root_dir']))
{
  $_SESSION['sf_root_dir'] = $_REQUEST['sf_root_dir'];
}


$options['sf_root_dir'] = isset($_SESSION['sf_root_dir']) ? $_SESSION['sf_root_dir'] : $options['sf_root_dir'];

$go_ahead = true;
$pdo = true;

if(!class_exists('PDO') || !count(PDO::getAvailableDrivers()))
{
  $pdo = false;
  $go_ahead = false;
 }
if(!is_dir($options['sf_root_dir'].DIRECTORY_SEPARATOR.'config'))
{
  $go_ahead = false;
  $no_config = true;
 }

if(!is_writable($options['sf_root_dir'].DIRECTORY_SEPARATOR.'cache'))
{
  $go_ahead = false;
  $no_cache = true;
 }

if(!$go_ahead)
{
  $included_in_pre_installer = true;
  include_once($options['sf_web_dir'].DIRECTORY_SEPARATOR.'pre_installer_instructions.php');
  exit;
}