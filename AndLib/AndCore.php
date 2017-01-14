<?php 

define(DOCROOT, $_SERVER['DOCUMENT_ROOT']);
define(HOSTNAME, $_SERVER['SERVER_NAME']);
define(SUPERDIR, dirname(__FILE__));
$a = str_replace(DOCROOT,"",SUPERDIR . "/");
define(REALPATH, 'http://' . HOSTNAME . '/' . $a );

include_once 'AndTimeUtils.php';
include_once 'AndPath.php';
include_once 'AndReport.php';
include_once 'AndDatabase.php';
include_once 'AndErrReport.php';
include_once 'AndSecurityGuard.php';
include_once 'AndGenerator.php';
//for Development
include_once 'AndErrReport.php';
include_once 'AndDevDebug.php';

?>