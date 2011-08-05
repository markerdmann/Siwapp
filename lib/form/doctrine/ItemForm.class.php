<?php

/**
 * Item form.
 *
 * @package    form
 * @subpackage Item
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class ItemForm extends BaseItemForm
{
  public function configure()
  {
    parent::configure();
    $this->widgetSchema['common_id'] = new sfWidgetFormInputHidden(); 

    $this->widgetSchema['discount'] = new sfWidgetFormInputText(array(), array('size'=>'3', 'class'=>'observable discount'));
    $this->widgetSchema['quantity'] = new sfWidgetFormInputText(array(), array('size'=>'5', 'class'=>'observable quantity'));
    $this->widgetSchema['unitary_cost'] = new sfWidgetFormInputText(array(), array('size'=>'10', 'class'=>'observable unitary_cost'));
    $this->widgetSchema['description'] = new sfWidgetFormTextarea(array(), array('rows'=>'1', 'class'=>'resizable'));

    $this->validatorSchema['taxes_list']->addMessage('invalid',"Can't duplicate taxes");
  }

  public function doUpdateObject($values)
  {
    $this->object->unlink('Taxes');
    $values['Taxes'] = $values['taxes_list'];
    return parent::doUpdateObject($values);
  }

}