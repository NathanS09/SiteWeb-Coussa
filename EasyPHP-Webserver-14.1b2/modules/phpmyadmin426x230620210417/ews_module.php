<?php
/**
 * EasyPHP: a complete and ready-to-use WAMP environment for
 * PHP development (Devserver) and self hosting (Webserver)
 * build with PHP, Apache, MySQL, PhpMyAdmin, Xdebug and more.
 *
 * EASYPHP WEBSERVER MODULE
 * @author   Laurent Abbal <laurent@abbal.com>
 * @link     http://www.easyphp.org
 */

$module_version = '4.2.6';
$module_info = array();
$module_info = array(
	"module_name" 		=> array(
		"en"	=>	"MySQL Administration : PhpMyAdmin",
		"fr"	=>	"Administration MySQL : PhpMyAdmin"
		),
	"module_version" 	=> $module_version,
	"en"	=>	array(
		"Application"	=>	array(
				"Name"		=>	"PhpMyAdmin",
				"Version"	=>	$module_version,
				"Installation date"	=>	"2023-06-20 21:04:17",
				"Website"	=>	"<a href='http://www.phpmyadmin.net/' target='_blank'>www.phpmyadmin.net</a>"
		),
		"Login/Password by default"	=>	array(
				"Login"		=>	"root",
				"Password"	=>	"'' (no password)"
		),
		"How to uninstall this module ?"	=>	array(
				"If you want to uninstall this module, you just have to<br />delete the folder"	=>	"<br />[modules folder]\\phpmyadmin426x230620210417",
		),	
	),
	"fr"	=>	array(
		"Application"	=>	array(
				"Nom"		=>	"PhpMyAdmin",
				"Version"	=>	$module_version,
				"Date d'installation"	=>	"2023-06-20 21:04:17",
				"Site web"	=>	"<a href='http://www.phpmyadmin.net/' target='_blank'>www.phpmyadmin.net</a>"
		),
		"Comment d&eacute;sinstaller ce module ?"	=>	array(
				"Si vous voulez d&eacute;sinstaller ce module, il suffit de supprimer le r&eacute;pertoire"	=>	"<br />[modules folder]\\phpmyadmin426x230620210417",
		),
	),	
);

$module_i18n = array();
$module_i18n = array(
	"en"	=>	array(
		"open"	=>	"open"
	),
	"fr"	=>	array(
		"open"	=>	"ouvrir"
	),
);


/* -- INFO -- */
$infobulle = '<pre>';
foreach($module_info[$lang] as $section_name => $section) {
	$infobulle .= '<br /><b style="color:#AF2D00">' . $section_name . '</b><br />';
	foreach($section as $title => $text) {
		$infobulle .= '<b>' . $title . '</b> : ' . $text . '<br />';
	}
}
$infobulle .= '</pre>';
/* ---------- */
?>

<div class="well" style="padding:5px 5px 5px 10px;margin:0px 0px 4px 0px;">
	<div class="row">
		<div class="col-sm-10" style="padding:5px 5px 0px 15px;">
			<a href="modules/<?php echo $file ?>/favicon.png"><img src="images/icon_phpmyadmin.png" /></a>
			&nbsp;<strong><?php echo $module_info['module_name'][$lang] . ' ' . $module_info['module_version'] ?></strong>
			<span class="infobulle"><span class="info">?<span class="info_frame"><?php echo $infobulle ?></span></span></span>
		</div>
		<div class="col-sm-2 text-right">
			<a href="http://<?php echo getHostByName(trim(getHostName())) . ':' . $http_port; ?>/modules/<?php echo $file ?>" class="btn btn-primary btn-sm" target="_blank"><?php echo $module_i18n[$lang]['open'] ?></a>
		</div>
	</div>
</div>
