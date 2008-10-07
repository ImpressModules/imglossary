<?php
/**
 * $Id: xoops_version.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

function b_entries_random_show() {

	$glossdirname = basename( dirname( dirname( __FILE__ ) ) );

	global $xoopsDB, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $xoopsUser;
	$myts =& MyTextSanitizer::getInstance();
//	include_once ICMS_ROOT_PATH . "/modules/" . $glossdirname . "/include/cleantags.php";
	include_once ICMS_ROOT_PATH . "/modules/" . $glossdirname . "/include/functions.php";

	$adminlinks = '';
	$block = array();
	$block['title'] = _MB_WB_RANDOMTITLE;
		
	list ( $numrows ) = $xoopsDB -> fetchRow( $xoopsDB -> query( "SELECT COUNT(*) FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0" ) );
	if ( $numrows > 1 ) {
		$numrows = $numrows - 1;
		mt_srand( ( double )microtime() * 1000000 );
		$entrynumber = mt_rand( 0, $numrows );
	} else {
		$entrynumber = 0;
	}

	$hModule =& xoops_gethandler( 'module' );
	$hModConfig =& xoops_gethandler( 'config' );
	$wbModule =& $hModule -> getByDirname( $glossdirname );
	$module_id = $wbModule -> getVar( 'mid' );
	$module_name = $wbModule -> getVar( 'dirname' );
	$wbConfig =& $hModConfig -> getConfigsByCat( 0, $wbModule -> getVar( 'mid' ) );

	$result = $xoopsDB -> query ( "SELECT entryID, categoryID, term, definition FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0 LIMIT $entrynumber, 1" );

	while ( $myrow = $xoopsDB -> fetchArray( $result ) ) {
		$entryID = $myts -> displayTarea( $myrow['entryID'] );
		$term = ucfirst( $myts -> displayTarea( $myrow['term'] ) );

		if ( !XOOPS_USE_MULTIBYTES ) {
		//	$deftemp = cleanTags( $myrow['definition'] );
		//	$definition = $myts -> displayTarea( substr( $myrow['definition'], 0, ( $wbConfig['rndlength'] -1 ) ) ) . "...";
			$definition = imgloss_substr( $myrow['definition'], 0, $wbConfig['rndlength'] -1, '...' );
		}

		$categoryID = $myrow['categoryID'];
		$result_cat = $xoopsDB -> query( "SELECT categoryID, name FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " WHERE categoryID='$categoryID'");
		list( $categoryID, $name ) = $xoopsDB -> fetchRow( $result_cat );
		$categoryname = $myts -> displayTarea( $name );

		// Functional links
		if ( $xoopsUser ) {
			if ( $xoopsUser -> isAdmin() ) {
				$adminlinks = "<a href=\"" . ICMS_URL . "/modules/" . $glossdirname . "/admin/entry.php?op=mod&entryID=" . $entryID . "\" target=\"_blank\"><img src=\"" . ICMS_URL . "/modules/" . $glossdirname . "/images/edit.gif\" border=\"0\" alt=\"" . _MB_WB_EDITTERM . "\" ></a>&nbsp;<a href=\"" . ICMS_URL . "/modules/" . $glossdirname . "/admin/entry.php?op=del&entryID=" . $entryID . "\" target=\"_self\"><img src=\"" . ICMS_URL . "/modules/" . $glossdirname . "/images/delete.gif\" border=\"0\" alt=\"" . _MB_WB_DELTERM . "\" ></a>&nbsp;";
			}
		}
		$userlinks = "<a href=\"" . ICMS_URL . "/modules/" . $glossdirname . "/print.php?entryID=" . $entryID . "\" target=\"_blank\"><img src=\"" . ICMS_URL . "/modules/" . $glossdirname . "/images/print.gif\" border=\"0\" alt=\"" . _MB_WB_PRINTTERM . "\" ></a>&nbsp;<a href=\"mailto:?subject=" . sprintf( _MB_WB_INTENTRY, $xoopsConfig["sitename"] ) . "&amp;body=" . sprintf( _MB_WB_INTENTRYFOUND, $xoopsConfig['sitename'] ) . ":  " . ICMS_URL . "/modules/" . $glossdirname . "/entry.php?entryID=" . $entryID . " \" target=\"_blank\"><img src=\"" . ICMS_URL . "/modules/" . $glossdirname . "/images/email.gif\" border=\"0\" alt=\"" . _MB_WB_SENDTOFRIEND . "\" ></a>&nbsp;";

		if ( $wbConfig['multicats'] == 1 ) {
			$block['content'] = "<div style=\"font-size: 12px; font-weight: bold; background-color: #ccc; padding: 4px; margin: 0;\"><a href=\"" . ICMS_URL . "/modules/" . $glossdirname . "/category.php?categoryID=$categoryID\">$categoryname</a></div>";
			$block['content'] .= "<div style=\"padding: 4px 0 0 0; color: #456;\"><h5 style=\"margin: 0;\">$adminlinks $userlinks <a href=\"" . ICMS_URL . "/modules/" . $glossdirname . "/entry.php?entryID=$entryID\">$term</a></h5><div>$definition</div>";
		} else {
			$block['content'] = "<div style=\"padding: 4px; color: #456;\"><h5 style=\"margin: 0;\"> $adminlinks $userlinks<a style=\"margin: 0;\" href=\"" . ICMS_URL . "/modules/" . $glossdirname . "/entry.php?entryID=$entryID\">$term</a></h5>$definition";
		}
	}

	$block['content'] .= "<div style=\"text-align: right; font-size: x-small;\"><a href=\"" . ICMS_URL . "/modules/" . $glossdirname . "/index.php\">" . _MB_WB_SEEMORE . "</a></div>";
	return $block;
}
?>