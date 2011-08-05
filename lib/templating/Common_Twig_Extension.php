<?php
sfContext::getInstance()->getConfiguration()->loadHelpers(array('Date', 'Text', 'Number'));

class Common_Twig_Extension extends Twig_Extension
{
  public function getFilters()
  {
    return array(
      // DateHelper
      'date'        => new Twig_Filter_Function('format_date'),
      'datetime'    => new Twig_Filter_Function('format_datetime'),
      // TextHelper
      'format'      => new Twig_Filter_Function('simple_format_text'),
      'unlink'      => new Twig_Filter_Function('strip_links_text'),
      'nl2br'       => new Twig_Filter_Function('nl2br'),
      // NumberHelper
      'currency'    => new Twig_Filter_Function('common_twig_extension_format_currency'),
      'number'      => new Twig_Filter_Function('format_number'),
      // Other
      'count'       => new Twig_Filter_Function('count'),
      'unhttp'      => new Twig_Filter_Function('common_twig_extension_unhttp'),
    );
  }
  
  public function getName()
  {
    return 'common';
  }
}

function common_twig_extension_format_currency($amount, $culture = null)
{
  $currency = sfContext::getInstance()->getUser()->getCurrency();
  return format_currency($amount, $currency, $culture);
}

function common_twig_extension_unhttp($url)
{
  return str_replace(array('http://', 'https://'), null, $url);
}