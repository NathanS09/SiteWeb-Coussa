<?php
//'app_service_install'	=>	urlencode("\"C:\Program Files\EasyPHP-Webserver-14.1_test_03\binaries\httpserver\bin\\ews-httpd.exe\" -k install -n ews-httpserver"),
$server = array();
$server = array(
	'app_folder'			=>	"httpserver",
	'app_type'				=>	"httpserver",
	'app_type_name'			=>	"http server",
	'app_name'				=>	"Apache",
	'app_version'			=>	"2.4.9",
	'app_website'			=>	"httpd.apache.org",
	'app_website_url'		=>	"http://httpd.apache.org",
	'app_icon'				=>	"ews_icon_httpserver.png",
	'app_service_name'		=>	"ews-httpserver",
	'app_service_stop'		=>	"service-manager stop ews-httpserver /nowait /pause:no",
	'app_service_start'		=>	"service-manager start ews-httpserver /nowait /pause:no",
	'app_service_install'	=>	urlencode("service-manager add \"..\binaries\httpserver\bin\\ews-httpd.exe -k runservice\" ews-httpserver ews-httpserver /start:auto /overwrite:yes"),
	'app_service_remove'	=>	"service-manager delete ews-httpserver"
);
?>