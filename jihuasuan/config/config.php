<?php return array (
  'logs' => 
  array (
    'path' => 'logs/log',
    'type' => 'file',
  ),
  'DB' => 
  array (
    'type' => 'mysqli',
    'tablePre' => 'li_',
    'read' => 
    array (
      0 => 
      array (
        'host' => 'localhost:3306',
        'user' => 'root',
        'passwd' => '123456',
        'name' => 'iwebshop',
      ),
    ),
    'write' => 
    array (
      'host' => 'localhost:3306',
      'user' => 'root',
      'passwd' => '123456',
      'name' => 'iwebshop',
    ),
  ),
  'interceptor' => 
  array (
    0 => 'themeroute@onCreateController',
    1 => 'layoutroute@onCreateView',
  ),
  'langPath' => 'language',
  'viewPath' => 'views',
  'skinPath' => 'skin',
  'classes' => 'classes.*',
  'rewriteRule' => 'pathinfo',
  'theme' => 
  array (
    'pc' => 'default',
    'mobile' => 'mobile',
  ),
  'skin' => 
  array (
    'pc' => 'default',
    'mobile' => 'default',
  ),
  'timezone' => 'Etc/GMT-8',
  'upload' => 'upload',
  'dbbackup' => 'backup/database',
  'safe' => 'session',
  'safeLevel' => 'normal',
  'lang' => 'zh_sc',
  'debug' => true,
  'configExt' => 
  array (
    'site_config' => 'config/site_config.php',
  ),
  'encryptKey' => '5b28381637f2049b099e551fafbe9cd0',
)?>