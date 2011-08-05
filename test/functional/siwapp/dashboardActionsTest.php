<?php
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new SiwappTestBrowser();

$browser->signin()->
  get('dashboard')->
  with('request')->begin()->
    isParameter('module', 'dashboard')->
    isParameter('action', 'index')->
  end()->
  with('response')->begin()->
    isStatusCode(200)->
    // check totals
    checkElement('#dashboard-balance-total', '/262,149\.22/')-> 
    checkElement('#receipts', '/259,335\.25/')->                
    checkElement('#due', '/2,813\.97/')->                       
    checkElement('#overdue', '/637\.47/')->
  end()
;