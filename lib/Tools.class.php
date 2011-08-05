<?php

class Tools
{
  public static function checkDB()
  {
    $configuration =  sfProjectConfiguration::getActive() ;

    $dbm = new sfDatabaseManager($configuration);
    $db = $dbm->getDatabase('doctrine');

    try
    {
      $conn = $db->getConnection();
    }

    catch(sfDatabaseException $ex)
    {        
      return false;
    }
    catch(Doctrine_Connection_Exception $ex2)
    {
      return false;
    }
    return true;
  }

  public static function checkLength($checkMe)
  {
    return strlen($checkMe) > 0 ? $checkMe : false ;
  }
  
  public static function sfDateFromArray($date_array, $lastminute = false)
  {
    $valid = true;
    foreach (array('year', 'month', 'day') as $key)
    {
      $valid = (isset($date_array[$key]) && strlen($date_array[$key])) && $valid;
    }
    
    if (!$valid)
      return false;
    
    $date = sfDate::getInstance()->clearTime();
    
    if ($lastminute)
    {
      $date->setHour(23)->setMinute(59)->setSecond(59);
    }
    
    $date->setDay($date_array['day']);
    $date->setMonth($date_array['month']);
    $date->setYear($date_array['year']);
    
    return $date;
  }

  public static function getGrossAmount($unitary_cost,$quantity,$discount, $total_taxes_percent)
  {
    $base_amount = $unitary_cost * $quantity;
    $discount_amount = $base_amount * $discount / 100;
    $net_amount = $base_amount - $discount_amount;
    $tax_amount = $net_amount * $total_taxes_percent / 100;
    
    return $net_amount + $tax_amount ;
  }
  
}