<?php

/**
 * templates actions.
 *
 * @package    siwapp
 * @subpackage templates
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class printTemplatesActions extends sfActions
{
 /**
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $finder = Doctrine::getTable('Template')->createQuery()->orderBy('Name', 'asc');
    $this->_csrf = new BaseForm();
    $this->templates = $finder->execute();
  }
  
  //----------------------------------------------------------------------------
  
  public function executeEdit(sfWebRequest $request)
  {
    $i18n = $this->getContext()->getI18N();
    $this->form = new TemplateForm(Doctrine::getTable('Template')->find($request->getParameter('id')));
    
    if ($request->isMethod('post') || $request->isMethod('put'))
    {
      $this->form->bind($request->getParameter('template'));
      if ($this->form->isValid())
      {
        $message = 'The template was %s successfully.';
        $updated = $this->form->getObject()->isNew() ? 'created' : 'updated';
        $this->getUser()->info($i18n->__(sprintf($message, $updated)));
        $template = $this->form->save();
        $this->redirect('@templates?action=edit&id='.$template->getId());
      }
      else 
      {
        $this->getUser()->error($i18n->__('The template has not been saved due to some errors.'));
      }
    }
  }
  
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $this->forward404Unless($request->isMethod('post'));
    
    if (count($ids = (array) $request->getParameter('ids', array())))
    {
      $rows = Doctrine::getTable('Template')->createQuery()->whereIn('id', $ids)->execute()->delete();
    }
    
    $this->redirect('@templates');
  }
  
  //----------------------------------------------------------------------------
  
  public function executeSetAsDefault(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $ids = (array) $request->getParameter('ids', array());
    $this->forward404Unless(count($ids) > 0);
    $this->forward404Unless($template = Doctrine::getTable('Template')->find($ids[0]));
    PropertyTable::set('default_template', $ids[0]);
    
    $this->redirect('@templates');
  }
}
