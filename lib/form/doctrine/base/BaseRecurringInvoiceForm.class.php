<?php

/**
 * RecurringInvoice form base class.
 *
 * @method RecurringInvoice getObject() Returns the current form's model object
 *
 * @package    siwapp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseRecurringInvoiceForm extends CommonForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('recurring_invoice[%s]');
  }

  public function getModelName()
  {
    return 'RecurringInvoice';
  }

}
