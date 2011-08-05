<?php

/**
 * Customer form base class.
 *
 * @method Customer getObject() Returns the current form's model object
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseCustomerForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'name'                => new sfWidgetFormInputText(),
      'name_slug'           => new sfWidgetFormInputText(),
      'identification'      => new sfWidgetFormInputText(),
      'identification_slug' => new sfWidgetFormInputText(),
      'email'               => new sfWidgetFormInputText(),
      'contact_person'      => new sfWidgetFormInputText(),
      'invoicing_address'   => new sfWidgetFormTextarea(),
      'shipping_address'    => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'name_slug'           => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'identification'      => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'identification_slug' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'email'               => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'contact_person'      => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'invoicing_address'   => new sfValidatorString(array('required' => false)),
      'shipping_address'    => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('customer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Customer';
  }

}
