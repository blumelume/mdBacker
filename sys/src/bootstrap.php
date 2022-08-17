<?php
namespace mdBacker\sys;

/*
Constant System-Paths
*/
chdir('../../../');
define('ROOTPATH', getcwd());
// relative to root-dir
define('locSys', ROOTPATH.'/sys/');
define('locLogs', ROOTPATH.'/logs/');
define('locFiles', ROOTPATH.'/files/');

define('locDef', locSys.'def/');

define('locConfigs', locFiles.'configs/');
define('locTemplates', locFiles.'templates/');
define('locPages', locFiles.'pages/');
define('locComponents', locFiles.'components/');
?>