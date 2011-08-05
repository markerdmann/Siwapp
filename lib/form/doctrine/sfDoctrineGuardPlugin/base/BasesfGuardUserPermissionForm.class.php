<?php

/**
 * sfGuardUserPermission form base class.
 *
 * @method sfGuardUserPermission getObject() Returns the current form's model object
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasesfGuardUserPermissionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'user_id'       => new sfWidgetFormInputHidden(),
      'permission_id' => new sfWidgetFormInputHidden(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'user_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'user_id', 'required' => false)),
      'permission_id' => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'permission_id', 'required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('sf_guard_user_permission[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'sfGuardUserPermission';
  }

}
