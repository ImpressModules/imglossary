<?php
/**
 * $Id: onupdate.inc.php
 * Module: imGlossary
 */

if ( ! defined( 'ICMS_ROOT_PATH' ) ) exit;

// referer check
$ref = xoops_getenv('HTTP_REFERER');
if ( $ref == '' || strpos( $ref, ICMS_URL . '/modules/system/admin.php' ) === 0 ) {
	/* module specific part */

	/* General part */

	// Keep the values of block's options when module is updated (by nobunobu)
	include dirname( __FILE__ ) . "/updateblock.inc.php";
}
?>