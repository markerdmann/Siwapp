<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <?php include_http_metas() ?>
  <?php include_metas() ?>
  <?php include_title() ?>
  <link rel="shortcut icon" href="favicon.ico" />
  <script type="text/javascript" src="<?php echo url_for('js/i18n') ?>"></script>
  <script type="text/javascript" src="<?php echo url_for('js/url?key='.$sf_request->getParameter('module')) ?>"></script>
</head>
<body class="<?php echo semantic_body_classes() ?>">
<?php echo javascript_tag("
  var userCulture = '".$sf_user->getCulture()."';
"); ?>
<div id="hd">
  <div id="hd-top">
    <div id="version">
      <?php echo 'v. '.sfConfig::get('app_version');?>
    </div>
    
    <ul id="hd-top-menu" class="inline content">
      <li><?php echo __('Welcome, [1]!', array('[1]' => $sf_user->getUsername())) ?> |</li>
      <!--<li><?php // echo link_to(__('Help'), '@homepage') ?> |</li>-->
      <li><?php echo link_to(__('Settings'), 'configuration/settings', array('accesskey' => "s")) ?> |</li>
      <li><?php echo link_to(__('Logout'), '@sf_guard_signout') ?></li>
    </ul>
    
    <?php include_partial('global/notifications') ?>
  </div>
  
  <div id="hd-navbar" class="content">
    <?php
      $tab        = $sf_params->get('tab');
      if ($tab == 'recurring') $mainButton = array(__('New Recurring Invoice'), 'recurring/new');
      elseif ($tab == 'customers')  $mainButton = array(__('New Customer'), 'customers/new');
      else $mainButton = array(__('New Invoice'), 'invoices/new');
      $active     = 'class="active"';
    ?>
    <?php echo link_to('<span>'.$mainButton[0].'</span>', $mainButton[1], 'id=new-invoice-button'); ?>
    <ul id="hd-navbar-menu" class="negative">
      <li <?php if ($tab == 'dashboard') echo $active ?>>
        <?php echo link_to(__('Dashboard'), '@dashboard') ?>
      </li>
      <li <?php if ($tab == 'invoices') echo $active ?>>
        <?php echo link_to(__('Invoices'), '@invoices') ?>
      </li>
      <li <?php if ($tab == 'recurring') echo $active ?>>
        <?php echo link_to(__('Recurring Invoices'), '@recurring') ?>
      </li>
      <li <?php if ($tab == 'customers') echo $active ?>>
        <?php echo link_to(__('Customers'), '@customers') ?>
      </li>
    </ul>
  </div>
  
</div>

<div id="bd">
  <div id="bd-top">
    <?php if ($sf_params->get('searchForm')) include_component_slot('searchForm')?>
  </div>
  
  <div id="bd-content">
    <?php echo $sf_content ?>
  </div>
</div>
  
</body>
</html>
