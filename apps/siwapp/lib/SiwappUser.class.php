<?php

class SiwappUser extends sfGuardSecurityUser
{
  public function signIn($user, $remember = false, $con = null)
  {
    parent::signIn($user, $remember, $con);
    $this->loadUserSettings();
  }
  
  public function loadUserSettings()
  {
    $currency = PropertyTable::get('currency', 'USD');
    $currency_decimals = PropertyTable::get('currency_decimals', 2);
    $this->setAttribute('currency', $currency);
    $this->setAttribute('currency_decimals', $currency_decimals);
    
    $culture = $this->getLanguage();
    if($this->getCountry()) $culture .= '_'.$this->getCountry();

    $this->setCulture($culture);
  }
  
  /**
   * Search Parameters
   */
  public function updateSearch(sfWebRequest $request)
  {
    $changed = false;
    $ns = $request->getParameter('searchNamespace');
    
    // if reset, remove all search parameters from request and user
    if ($request->getParameter('reset'))
    {
      $request->getParameterHolder()->remove('search');
      $this->getAttributeHolder()->remove('search', null, $ns);
      
      $changed = true;
    }
    else
    {
      // check if some parameters have changed, and setting them into user
      $params = array('search', 'sort');
      foreach ($params as $param)
      {
        $value = $request->getParameter($param, null);
        
        if($value && $this->getAttribute($param, null, $ns) != $value)
        {
          $this->setAttribute($param, $value, $ns);
          $changed = true;
        }
      }
    }
    
    // If something has changed we reset page to 1
    if ($changed)
    {
      $request->setParameter('page', 1);
    }

    // if page comes as parameter insert as attribute
    if ($page = $request->getParameter('page'))
    {
      $this->setAttribute('page', $page, $ns);
    }
    
    if($ns == 'invoices')
    {
      $search = $this->getSearchSettings($this->getAttribute('search', null, $ns));
    }
    else
    {
      $search = $this->getAttribute('search', null, $ns);
    }
    
    // this is to put the customer name in the autocomplete field
    if(isset($search['customer_id']) && $search['customer_id'] > 0)
    {
      if($cust = Doctrine::getTable('Customer')->find($search['customer_id']))
      {
        $search['customer_name'] = $cust->getName();
      }
      else
      {
        unset($search['customer_name']);
        unset($search['customer_id']);
      }
    }
    
    $this->setAttribute('search', $search, $ns);
  }
  
  /**
   * this function sets the $search array with default settings 
   * if the user has default settings for the search form
   *
   * @param $search array The search array
   *
   * @return array The search array
   **/
  private function getSearchSettings($search)
  {
    if($profile = $this->getProfile())
    {
      $from = $to = null;
      
      if (isset($search['from']))
      {
        $from = Tools::sfDateFromArray($search['from']);
      }
      
      if (isset($search['to']))
      {
        $to = Tools::sfDateFromArray($search['to']);
      }
      
      if (!isset($search['quick_dates']) && !$from && !$to && ($searchFilter = $profile->getSearchFilter()))
      {
        $to = sfDate::getInstance();
        $search['to'] = array(
            'day'   => $to->getDay(),
            'month' => $to->format('n'),
            'year'  => $to->getYear(),
          );
        
        $from = sfDate::getInstance();

        switch ($searchFilter)
        {
          case 'last_week':
            $from->subtractWeek(1);
            break;
          case 'last_month':
            $from->subtractMonth(1);
            break;
          case 'last_year':
            $from->subtractYear(1);
            break;
          case 'last_5_years':
            $from->subtractYear(5);
            break;
        }

        $search['from'] = array(
            'day'   => $from->getDay(),
            'month' => $from->format('n'),
            'year'  => $from->getYear(),
          );
        
        $search['quick_dates'] = $searchFilter;
      }
    }
    
    return $search;
  }
  
  public function getSelectedTags($search)
  {
    return ((isset($search['tags']) && strlen($search['tags'])) ? explode(',', $search['tags']) : array());
  }
  
  public function getPaginationMaxResults()
  {
    if (!($maxResults = $this->getProfile()->getNbDisplayResults()))
    {
      $maxResults = sfConfig::get('app_pagination_max_results', 10);
    }
    
    return $maxResults;
  }
  
  /**
   * Info Notification Helpers
   * @author Carlos Escribano <carlos@markhaus.com>
   **/
  public function info($message, $b = true)
  {
    $this->setFlash('info', $message, $b);
  }
  
  public function warn($message, $b = true)
  {
    $this->setFlash('warning', $message, $b);
  }
  
  public function error($message, $b = true)
  {
    $this->setFlash('error', $message, $b);
  }
  
  /**
   * Tag Cloud Preference
   */
  public function toggleTagCloud()
  {
    $this->setAttribute('showTags', !$this->getAttribute('showTags'));
  }
  
  public function isTagCloudVisible()
  {
    return $this->getAttribute('showTags', false);
  }
  
  public function getLanguage()
  {
    $lang = $this->getProfile()->getLanguage();
    
    return $lang ? $lang : 'en';
  }
  
  public function getCountry()
  {
    $country = $this->getProfile()->getCountry();
    
    return $country ? $country : null;
  }
  
  public function getCurrency()
  {
    return $this->getAttribute('currency');
  }
}
