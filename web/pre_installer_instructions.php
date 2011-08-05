<?php 
// this file can not ve viewed unless it's included from pre_installer_code.php
if(!isset($included_in_pre_installer))
{
  die('You\'re attempting to access this file the wrong way.');
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="title" content="siwapp - Installer" />
    <title>siwapp - Preinstall</title>
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" type="text/css" media="all" href="css/tripoli/tripoli.css" />
    <!--[if ie]><link rel="stylesheet" type="text/css" media="all" href="css/tripoli/tripoli.ie.css" /><![endif]-->
    <link rel="stylesheet" type="text/css" media="all" href="css/siwapp/layout.css" />
    <link rel="stylesheet" type="text/css" media="all" href="css/siwapp/typography.css" />
    <link rel="stylesheet" type="text/css" media="all" href="css/siwapp/buttons.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/siwapp/theme.css" />
    <link rel="stylesheet" type="text/css" media="all" href="css/siwapp/controls.css" />
    <link rel="stylesheet" type="text/css" media="print" href="css/siwapp/print.css" />
    <link rel="stylesheet" type="text/css" media="all" href="css/ui-orange/ui.all.css" />
    <link rel="stylesheet" type="text/css" media="all" href="css/siwapp/installer.css" />
  </head>
  <body class="static step0">
    <div id="hd"></div>

    <div id="bd">
      <div id="bd-content">
        <form id="step0Form" class="installerForm" action="" method="get">
        <div id="header">
          <h2>Pre-installation instructions</h2>
          <ul>
            <li class="buttons">
              <button type="submit" id="finish" class="btn"><span><span>Start</span></span></button>  
            </li>
          </ul>
        </div>
        
        <div id="content">
          <p>
            SIWAPP is based on the symfony framework, and it needs to have access to certain 
            special files and directories to work.
          </p>
          <?php if(!is_dir($options['sf_root_dir'].'/config')):?>
          <p>
            The webpage you're seeing right now is located at: <br/>
            <code><?php echo dirname(__FILE__)?></code><br/><br/>
            And SIWAPP expects to find the symfony root directory at:<br/>
            <code><?php echo $options['sf_root_dir']?></code><br/>
          </p>
          <p>However, <strong>SIWAPP can't find that directory</strong>. Please type here the path of the symfony root directory:</p>
          <p><input name="sf_root_dir" size="50"/></p>
          <?php elseif(!is_writable($options['sf_root_dir'].'/cache')): ?>
          <input name="sf_root_dir" type="hidden" value="<?php echo $options['sf_root_dir']?>"/>
          <p><strong>SIWAPP can't write to the "cache" directory.</strong><br/> 
             The "cache" directory should be located at: <br/>
             <code><?php echo $options['sf_root_dir']?>/cache</code><br/>
              Please make sure it exists and the web server can write to it.
          </p>
          <?php else:?>
          <input name="sf_root_dir" type="hidden" value="<?php echo $options['sf_root_dir']?>"/>
          <?php endif?>
          <?php if(!$pdo):?>
          <p><strong>Your php distribution doesn't support PDO</strong>. SIWAPP , as being based on the symfony framework, relies heavily on PDO. You need to enable PDO support in you PHP.
          <?php endif?>
          <p>Once you've solved the indicated problems, reload this page, or just click on the "start" button.</p>
          <div style="text-align: center;">
            <a href="http://www.siwapp.org/">Siwapp</a> is Free Software released under the MIT license  </div>
          </div>
        </div>
        </form>
      </div> <!-- div#bd-content -->
    </div> <!-- div#bd -->
  </body>
</html>
