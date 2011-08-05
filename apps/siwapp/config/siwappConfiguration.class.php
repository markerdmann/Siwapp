<?php

class siwappConfiguration extends sfApplicationConfiguration
{
  public function configure()
  {
    // enable utf support
    if(!defined("DOMPDF_UNICODE_ENABLED"))
      define("DOMPDF_UNICODE_ENABLED",true);
    if(!defined("DOMPDF_FONT_DIR"))
      define("DOMPDF_FONT_DIR",
             sfConfig::get('sf_data_dir').DIRECTORY_SEPARATOR.'fonts/');
    if(!defined("DOMPDF_FONT_CACHE"))
      define("DOMPDF_FONT_CACHE",
        sfConfig::get('sf_upload_dir').DIRECTORY_SEPARATOR.'pdf_fonts_cache');
    
    // this is needed to load the logo image on the pdf 
    if(!defined("DOMPDF_ENABLE_REMOTE"))
      define("DOMPDF_ENABLE_REMOTE", true);
    // this is for security reasons, due to the previous setting
    if(!defined("DOMPDF_ENABLE_PHP"))
      define("DOMPDF_ENABLE_PHP", false);
  }
}
