<?php
/**
 * These tests are only for the edition/batch actions of customers
 *
 **/
include(dirname(__FILE__).'/../../bootstrap/functional.php');
include(dirname(__FILE__).'/../../testTools.php');

$browser = new SiwappTestBrowser();

//save action
$browser->signin()->
  post('customers/batch',array('batch_action'=>'delete','ids'=>array(6)))->
  with('request')->begin()->
    isParameter('module','customers')->
    isParameter('action','batch')->
  end()->
  info('Testing deleting a customer with invoices')->
  with('response')->begin()->
      isStatusCode(500)->
  throwsException('siwappIntegrityException',
                  '/The customer has invoices/')->end();
