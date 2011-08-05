<?php
// Intended to FIX undefined index _dompdf_show_warnings...
global $_dompdf_show_warnings;

/**
 * print actions.
 *
 * @package    siwapp
 * @subpackage print
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class printActions extends sfActions
{
  private $templateNotFoundMsg = "<html><body>We couldn't find the associated template</body></html>";
  /**
   * Default action
   * @param array ids - Object IDs as request parameter
   */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('print', 'html');
  }
  
  /**
   * HTML output
   * @param array ids - Object IDs as request parameter
   */
  public function executeHtml(sfWebRequest $request)
  {
    try
    {
      $this->html = $this->render();
    }
    catch(LogicException $le)
    {
      $this->html  = $this->templateNotFoundMsg;
    }
    $this->setLayout(false);
  }
  
  /**
   * HTML output with print dialog and autohiding
   * @param array ids - Object IDs as request parameter
   */
  public function executePrint(sfWebRequest $request)
  {    
    try
    {
      $res =  $this->renderText(preg_replace("/<body/", '<body onload="window.print();"', $this->render()));
    }
    catch(LogicException $le)
    {
      $res = $this->renderText($this->templateNotFoundMsg);
    }

    return $res;
  }
  
  /**
   * PDF output
   * @param array ids - Object IDs as request parameter
   */
  public function executePdf(sfWebRequest $request)
  {
    switch($n = count($ids = (array) $this->getRequestParameter('ids', array())))
    {
      case 0:
        $this->forward404();
        break;
      case 1:
        $name = "invoice-{$ids[0]}";
        break;
      default:
        $name = "$n-invoices";
        break;
    }
    try
    {
      $this->render(true)->stream("$name.pdf");
      return sfView::NONE;
    }
    catch(LogicException $le)
    {
      return $this->renderText($this->templateNotFoundMsg);
    }
  }
  
  private function render($pdf = false)
  {
    sfConfig::set('sf_web_debug',false);
    $printer = new Printer('Invoice', PropertyTable::get('default_template'));
    $data    = $this->getInvoiceDataFromRequest($this->getRequest());

    return ($pdf ? $printer->renderPdf($data) : $printer->render($data));
  }
  
  private function getInvoiceDataFromRequest(sfWebRequest $request)
  {
    $data   = array();
    // explicit all the relations so they are already loaded for the template

    $finder = Doctrine::getTable('Invoice')->createQuery()->from('Invoice in')->
      leftJoin('in.Items it')->leftJoin('it.Taxes tx')->
      whereIn('in.id', (array) $request->getParameter('ids',array(0)))->execute();

    foreach ($finder as $invoice)
    {
      $data[] = $invoice;
    }
    return $data;
  }


}
