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
 
include("notification.php"); 
$new_content = '<?php $notification = array(\'check_date\'=>\'' . @date('Ymd') . '\',\'date\'=>\'' . $notification['date'] . '\',\'status\'=>\'0\',\'link\'=>\'' . $notification['link'] . '\',\'message\'=>\'' . $notification['message'] . '\'); ?>';
file_put_contents('notification.php', $new_content);

$redirect = $notification['link'];
header("Location: " . $redirect); 
exit;	
?>