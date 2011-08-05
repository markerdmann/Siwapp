<?php
 
include(dirname(__FILE__).'/../../bootstrap/Doctrine.php');

$t = new lime_test(9, new lime_output_color());

$t->diag("CustomerTable class tests");

$slugged = CustomerTable::slugify('Some Text with 5 SpACes');
$t->is($slugged, 'sometextwith5spaces', '->slugify(\'Some Text with 5 SpACes\')');

$slugged = CustomerTable::slugify('  Text with -ç-€-®-ñ-©- and , and_ & chars');
$t->is($slugged, 'textwithceurrncandand_chars', '->slugify(\'  Text with -ç-€-®-ñ-©- and , and_ & chars\')');

$t->diag("Checking with test data.");

$test = Doctrine::getTable('Customer')->matchIdentification('4 7 16  --162 -264W');
$t->is($test->getNameSlug(), 'springshield', '->matchIdentification()');
$test = Doctrine::getTable('Customer')->matchName('  spring -- shi eld');
$t->is($test->getNameSlug(), 'springshield', '->matchName()');



$invoice = new Invoice();
$invoice->setCustomerName(' Sonky !rubber Goods');

$test = Doctrine::getTable('Customer')->getCustomerMatch($invoice);
$t->is($test->getIdentificationSlug(), '40487600161', '->getCustomerMatch() with name');


$invoice->setCustomerIdentification('40487600161-2');
$test = Doctrine::getTable('Customer')->getCustomerMatch($invoice);
$t->is($test->state(), Doctrine_Record::STATE_TCLEAN, '->getCustomerMatch() returns new customer if no match identification');

$invoice->setCustomerName(' Sonky !rubberaa Goods');
$invoice->setCustomerIdentification('40487600161');

$test = Doctrine::getTable('Customer')->getCustomerMatch($invoice);

$t->is($test->state(), Doctrine_Record::STATE_CLEAN, '->getCustomerMatch() matchs if name doesn\'t match and identification matchs');
$t->is($test->getEmail(), 'olivia_mirren@example.com', 'and gets the right customer');

$test = CustomerTable::simpleRetrieveForSelect('Rouster and Sideways',2);

$t->is(count($test),1,'::simpleRetrieveForSelect');
