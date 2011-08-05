<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class RecurringInvoiceTable extends Doctrine_Table
{
  public static $period_types = array(
    'year'  => 'Years',
    'month' => 'Months',
    'week'  => 'Weeks',
    'day'   => 'Days'
    );
    
  /**
   * creates all the pending invoices
   *
   * @return void
   **/
  public static function createPendingInvoices()
  {
    // first check status on all recurring
    $recurrings = RecurringInvoiceQuery::create()->execute();    
    foreach ($recurrings as $r)
    {
      $r->checkStatus();
      $r->save();
    }
    
    $collection = RecurringInvoiceQuery::create()
      ->status(RecurringInvoice::PENDING)
      ->execute();
    if ($collection->count())
    {
      foreach ($collection as $r)
      {
        while($r->countPendingInvoices() > 0)
        {
          $i = $r->generateInvoice();
          $r->refresh(true);
        }
        $r->checkStatus()->save();
      }
    }
  }
}