<?php
//	'app_service_install'	=>	urlencode("service-manager add \"..\binaries\dbserver\bin\ews-mysqld.exe\" ews-dbserver ews-dbserver /start:auto /overwrite:yes"),
$server = array();
$server = array(
	'app_folder'			=>	"dbserver",
	'app_type'				=>	"dbserver",
	'app_type_name'			=>	"db server",
	'app_name'				=>	"MySQL",
	'app_version'			=>	"5.6.19",
	'app_website'			=>	"www.mysql.com",
	'app_website_url'		=>	"http://www.mysql.com",
	'app_icon'				=>	"ews_icon_dbserver.png",
	'app_service_name'		=>	"ews-dbserver",
	'app_service_stop'		=>	"service-manager stop ews-dbserver /nowait /pause:no",
	'app_service_start'		=>	"service-manager start ews-dbserver /nowait /pause:no",
	'app_service_install'	=>	urlencode("service-manager add \"..\\binaries\\dbserver\\bin\\ews-mysqld.exe ews-dbserver\" ews-dbserver ews-dbserver /start:auto /overwrite:yes"),
	'app_service_remove'	=>	"service-manager delete ews-dbserver"
);
?>