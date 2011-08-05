<?php

/**
 * Project form base class.
 *
 * @package    form
 * @version    SVN: $Id: sfDoctrineFormBaseTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class BaseFormDoctrine extends sfFormDoctrine
{
  protected $JQueryDateOptions = array(
                                       'culture' => '',
                                       'image'   => '',
                                       'config'  => "{ duration: '' }"
                                       );
  protected $culture = null;
  
  public function setup()
  {
    sfWidgetFormSchema::setDefaultFormFormatterName('list');
    $this->culture = $this->getOption('culture',
                                      sfConfig::get('sf_default_culture'));
    $this->JQueryDateOptions['culture'] = substr($this->culture, 0, 2);
    $this->JQueryDateOptions['image']   = $this->getImagePath('icons/calendar.png');
  }
  
  protected function getImagePath($source)
  {
    if(!sfContext::getInstance())
    {
      return null;
    }
    $request = sfContext::getInstance()->getRequest();
    $sf_relative_url_root = $request->getRelativeUrlRoot();
    if(0 !== strpos($source,'/'))
    {
      $source = $sf_relative_url_root.'/images/'.$source;
    }
    if(false === strpos(basename($source),'.'))
    {
      $source .= '.'.'png';
    }
    if($sf_relative_url_root && 0 !== strpos($source,$sf_relative_url_root))
    {
      $source = $sf_relative_url_root.$source;
    }

    return $source;
  }
}