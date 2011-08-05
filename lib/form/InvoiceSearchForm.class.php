<?php
class InvoiceSearchForm extends BaseForm
{
  public function configure()
  {
    $sfWidgetFormI18nJQueryDateOptions = array(
      'culture' => $this->getOption('culture', 'en'),
      'image'   => image_path('icons/calendar.png'),
      'config'  => "{ duration: '' }"
    );
    
    $this->setWidgets(array(
      'query'       => new sfWidgetFormInputText(),
      'from'        => new sfWidgetFormI18nJQueryDate($sfWidgetFormI18nJQueryDateOptions),
      'to'          => new sfWidgetFormI18nJQueryDate($sfWidgetFormI18nJQueryDateOptions),
      'quick_dates' => new sfWidgetFormChoice(array('choices' => InvoiceSearchForm::getQuickDates())),
      'series_id'   => new sfWidgetFormChoice(array('choices' => array(''=>'') + SeriesTable::getChoicesForSelect(false))),
      'customer_id' => new sfWidgetFormChoice(array('choices' => array())),
      'tags'        => new sfWidgetFormInputHidden(),
      'status'      => new sfWidgetFormInputHidden(),
      'not_sent'    => new sfWidgetFormInputCheckbox(),
    ));

    $this->widgetSchema->setLabels(array(
      'query'       => 'Search',
      'from'        => 'from',
      'to'          => 'to',
      'quick_dates' => ' ',
      'series_id'   => 'Series',
      'customer_id' => 'Customer',
      'not_sent'    => 'Not sent',
    ));

    $dateRangeValidatorOptions = array(
      'required'  => false
    );

    $this->setValidators(array(
      'query'       => new sfValidatorString(array('required' => false, 'trim' => true)),
      'from'        => new sfValidatorDate($dateRangeValidatorOptions),
      'to'          => new sfValidatorDate($dateRangeValidatorOptions),
      'customer_id' => new sfValidatorString(array('required' => false, 'trim' => true)),
      'tags'        => new sfValidatorString(array('required' => false, 'trim' => true)),
      'status'      => new sfValidatorString(array('required' => false, 'trim' => true)),
    ));
    
    // autocomplete for customer
    $this->widgetSchema['customer_id']->setOption('renderer_class', 'sfWidgetFormJQueryAutocompleter');
    $this->widgetSchema['customer_id']->setOption('renderer_options', array(
      'url'   => url_for('search/ajaxCustomerAutocomplete'),
      'value_callback' => 'CustomerTable::getCustomerName'
    ));
    
    $this->widgetSchema->setNameFormat('search[%s]');
    $this->widgetSchema->setFormFormatterName('list');
  }
  
  public static function getQuickDates()
  {
    return array(
      ''             => '',
      'last_week'    => 'last week',
      'last_month'   => 'last month',
      'last_year'    => 'last year',
      'last_5_years' => 'last 5 years'
    );
  }
}