<?php

/**
 * Property form base class.
 *
 * @method Property getObject() Returns the current form's model object
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePropertyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'keey'  => new sfWidgetFormInputHidden(),
      'value' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'keey'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'keey', 'required' => false)),
      'value' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('property[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Property';
  }

}
