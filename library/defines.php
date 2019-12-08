<?php

  defined('DIR_CONFIG') or define('DIR_CONFIG', DIR_LIB."/config");
  defined('DIR_DB') or define('DIR_DB', DIR_LIB."/db");
  defined('DIR_CLASSES') or define('DIR_CLASSES', DIR_LIB."/classes");

  defined('DB_FILE') or define('DB_FILE', DIR_CONFIG."/".DB_NAME);

  defined('DIR_HTML') or define('DIR_HTML', DIR_LIB."/html");
  defined('DIR_PAGES') or define('DIR_PAGES', DIR_HTML."/pages");
  defined('DIR_MODULES') or define('DIR_MODULES', DIR_HTML."/modules");
