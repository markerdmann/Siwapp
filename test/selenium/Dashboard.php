<?php
require_once(dirname(__FILE__).'/../bootstrap/Selenium.php');

class Dashboard extends SiwappSeleniumTest
{
  public function testShowPayments()
  {
    $this->login();
    
    $this->log("::testShowPayments()");
    $this->open("dashboard");
    
    $this->log("show payment details for the most recent invoice (top table).", 'click');
    
    $this->click("//*/table[@class=\"listing\"][1]/tbody/tr[1]/td[8]/button");
    $ret = $this->waitForCondition("selenium.isElementPresent('//*/table[@class=\"listing\"][1]/tbody/tr[2]/td[1]/form[@class=\"payments-form\"]') == true");
    
    $this->log("show payment details for the most recent overdue invoice (bottom table).", 'click');
    
    // Bottom Table
    $this->click("//*/table[@class=\"listing\"][2]/tbody/tr[1]/td[7]/button");
    $this->waitForCondition("selenium.isElementPresent('//*/table[@class=\"listing\"][2]/tbody/tr[2]/td[1]/form[@class=\"payments-form\"]') == true");
  }
}
?>