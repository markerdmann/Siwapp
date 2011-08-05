<?php
 
include(dirname(__FILE__).'/../../bootstrap/Doctrine.php');

$t = new lime_test(24, new lime_output_color());

include(dirname(__FILE__).'/../../testTools.php');

// checks before save
$t->diag('Totals checks');
$t->is(count($test_invoice->getItems()), 3, 'we have created an Invoice which contains 3 items');
$t->is($test_invoice->getBaseAmount(), 224.98, 'getBaseAmount()');
$t->is($test_invoice->getDiscountAmount(), 4.0895, 'getDiscountAmount()');
$t->is($test_invoice->getNetAmount(), 220.8905, 'getNetAmount()');
$t->is($test_invoice->getTaxAmount(), 17.463428, 'getTaxAmount()');
$t->is($test_invoice->getGrossAmount(), 238.35, 'getGrossAmount()');

$test_invoice->save();

// test tax_amount_<TAX_NAME> property
$invoice = Doctrine::getTable('Invoice')->find(23);
$t->is($invoice->tax_amount_iva16, 753.44, 
       '->tax_amount_iva16 == 753.44');
// checks post save
$t->diag("Testing The Extended Invoice");
$einvoice = Doctrine::getTable('Invoice')->find($test_invoice->id);
$t->is($einvoice->getBaseAmount(), 224.98, 'getBase() == 224.98');
$t->is($einvoice->getDiscountAmount(), 4.0895, 'getDiscount() == 4.0895');
$t->is($einvoice->getNetAmount(), 220.8905, 'getNet() == 220.8905');
$t->is($einvoice->getTaxAmount(), 17.463428, 'getTax() == 17.463428');
$t->is($einvoice->getGrossAmount(), 238.35, 'getGross() == 238.35');

// deleting
$invoiceItem2->delete();
$test_invoice->refresh(true)->setAmounts();
$t->diag("after deleting Item 2 of the Invoice:");
$t->is(count($test_invoice->getItems()), 2, 'the Invoice now have  2 items');
$t->is($test_invoice->getNetAmount(), 135.4737, 'getNetAmount()');

// modifying
$t->diag("after making quantity of Item3 = 2:");
$invoiceItem3->setQuantity(2);
$invoiceItem3->save();
$test_invoice->refresh(true)->setAmounts();
$t->is($test_invoice->getNetAmount(), 96.6437, 'getNetAmount()');

$test_invoice->delete();

// checking the test data

$t->diag('checking test data for Customer "Smith and Co."');
$invoice = Doctrine::getTable('Invoice')->findOneBy('CustomerName', 'Smith and Co.');

// test if values on bbdd are ok
$t->is($invoice->getBaseAmount(), 7198.85, 'getBase()');
$t->is($invoice->getDiscountAmount(), 0, 'getDiscount()');
$t->is($invoice->getNetAmount(), 7198.85, 'getNet()');
$t->is($invoice->getTaxAmount(), 1034.7995, 'getTax()');
$t->is($invoice->getGrossAmount(), 8233.65, 'getGross()');
$t->is($invoice->getPaidAmount(), 8610.68, 'getPaid()');

// checks number generation
$t->is(Doctrine::getTable('Invoice')->getNextNumber(1), 9, 'getNextNumber of "ASET-" invoices will be 9');
$t->is(Doctrine::getTable('Invoice')->getNextNumber(2), 6, 'getNextNumber of "BSET-" invoices will be 6');
$t->is(Doctrine::getTable('Invoice')->getNextNumber(3), 7, 'getNextNumber of "CSET-" invoices will be 7');

