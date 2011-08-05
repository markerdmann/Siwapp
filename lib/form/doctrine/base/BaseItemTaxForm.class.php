<?php

/**
 * ItemTax form base class.
 *
 * @method ItemTax getObject() Returns the current form's model object
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseItemTaxForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'item_id' => new sfWidgetFormInputHidden(),
      'tax_id'  => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'item_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'item_id', 'required' => false)),
      'tax_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'tax_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('item_tax[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ItemTax';
  }

}
