<?php
/**
 * $Id: submit.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

include '../../mainfile.php';

include_once ICMS_ROOT_PATH . '/class/xoopsformloader.php';
include ICMS_ROOT_PATH . '/header.php';

global $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;

$result = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . "" );
if ( $xoopsDB -> getRowsNum( $result ) == '0' && $xoopsModuleConfig['multicats'] == '1' ) {
	redirect_header( "index.php", 1, _AM_IMGLOSSARY_NOCOLEXISTS );
	exit();
} 

if ( !is_object( $xoopsUser ) && $xoopsModuleConfig['anonpost'] == 0 ) {
	redirect_header( "index.php", 1, _NOPERM );
	exit();
} 

if ( is_object( $xoopsUser ) && $xoopsModuleConfig['allowsubmit'] == 0 ) {
	redirect_header( "index.php", 1, _NOPERM );
	exit();
}

$op = 'form';

if ( isset( $_POST['post'] ) ) {
	$op = trim( 'post' );
} elseif ( isset( $_POST['edit'] ) ) {
	$op = trim( 'edit' );
} 
	
if( !isset( $HTTP_POST_VARS['suggest'] ) ) {
	$suggest = isset( $HTTP_GET_VARS['suggest'] ) ? intval( $HTTP_GET_VARS['suggest'] ) : 0;
} else {
	$suggest = intval( $HTTP_POST_VARS['suggest'] );
}

if ( $suggest > 0 ) {
	$terminosql = $xoopsDB -> query( "SELECT term FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE datesub<" . time() . " AND datesub>0 AND request=1 AND entryID=" . $suggest . "" );
	list( $termino ) = $xoopsDB -> fetchRow( $terminosql );
} else {
	$termino = '';
}
	
switch ( $op ) {
	case 'post':
		global $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $myts, $xoopsDB;

		include_once ICMS_ROOT_PATH . "/modules/" . $xoopsModule -> dirname() . "/include/functions.php";
		$myts = & MyTextSanitizer :: getInstance();

		$html = 1;
		if ( $xoopsUser ) {
			$uid = $xoopsUser -> getVar( 'uid' );
			if ( $xoopsUser -> isAdmin( $xoopsModule -> mid() ) ) {
				$html = empty( $html ) ? 0 : 1;
			} 
		} else {
			if ( $xoopsModuleConfig['anonpost'] == 1 ) {
				$uid = 0;
			} else {
				redirect_header( "index.php", 3, _NOPERM );
				exit();
			} 
		} 

		$block = isset( $block ) ? intval( $block ) : 1;
		$smiley = isset( $smiley ) ? intval( $smiley ) : 1;
		$xcodes = isset( $xcodes ) ? intval( $xcodes ) : 1;
		$breaks = isset( $breaks ) ? intval( $breaks ) : 1;
		$notifypub = isset( $notifypub ) ? intval( $notifypub ) : 1;

		if ( $xoopsModuleConfig['multicats'] == 1 ) {
			$categoryID = intval( $_POST['categoryID'] );
		} else {
			$categoryID = 0;
		}
		
		$term = $myts -> htmlSpecialChars( $_POST['term'] );
		$init = substr( $term, 0, 1 );
		$definition = $myts -> addSlashes( $_POST['definition'] );
		$ref = $myts -> addSlashes( $_POST['ref'] );
		$url = $myts -> addSlashes( $_POST['url'] );

		if ( empty($url) ) {
			$url = ''; 
		}

		$datesub = time();

		$submit = 1;
		$offline = 1;
		$request = 0;

		if ( $xoopsModuleConfig['autoapprove'] == 1 ) {
			$submit = 0;
			$offline = 0;
		} 

		$result = $xoopsDB -> query( "INSERT INTO " . $xoopsDB -> prefix( 'imglossary_entries' ) . " (entryID, categoryID, term, init, definition, ref, url, uid, submit, datesub, html, smiley, xcodes, breaks, offline, notifypub ) VALUES ('', '$categoryID', '$term', '$init', '$definition', '$ref', '$url', '$uid', '$submit', '$datesub', '$html', '$smiley', '$xcodes', '$breaks', '$offline', '$notifypub')" );
		$entryID = $xoopsDB -> getInsertId();

		if ( $result ) {
			if ( !is_object( $xoopsUser ) ) {
				$username = _MD_IMGLOSSARY_GUEST;
				$usermail = '';
			} else {
				$username = $xoopsUser -> getVar( "uname", "E" );
				$result = $xoopsDB -> query( "SELECT email FROM " . $xoopsDB -> prefix( 'users' ) . " WHERE uname=$username" );
				list( $usermail ) = $xoopsDB -> fetchRow( $result );
			}

			if ( $xoopsModuleConfig['mailtoadmin'] == 1 ) {
				$adminMessage = sprintf( _MD_IMGLOSSARY_WHOSUBMITTED, $username );
				$adminMessage .= "<b>" . $term . "</b>\n";
				$adminMessage .= "" . _MD_IMGLOSSARY_EMAILLEFT . " $usermail\n";
				$adminMessage .= "\n";
				
				if ($notifypub == '1') {
					$adminMessage .= _MD_IMGLOSSARY_NOTIFYONPUB;
				}
				
				$adminMessage .= "\n" . $_SERVER['HTTP_USER_AGENT'] . "\n";
				$subject = $xoopsConfig['sitename'] . " - " . _MD_IMGLOSSARY_DEFINITIONSUB;
				$xoopsMailer =& getMailer();
				$xoopsMailer -> useMail();
				$xoopsMailer -> setToEmails( $xoopsConfig['adminmail'] );
				$xoopsMailer -> setFromEmail( $usermail );
				$xoopsMailer -> setFromName( $xoopsConfig['sitename'] );
				$xoopsMailer -> setSubject( $subject );
				$xoopsMailer -> setBody( $adminMessage );
				$xoopsMailer -> send();
				$messagesent = sprintf( _MD_IMGLOSSARY_MESSAGESENT, $xoopsConfig['sitename'] ) . "<br />" . _MD_IMGLOSSARY_THANKS1 . "";
			}

			if ( $xoopsModuleConfig['autoapprove'] == 1 ) {
				redirect_header( "index.php", 2, _MD_IMGLOSSARY_RECEIVEDANDAPPROVED );
			} else {
				redirect_header( "index.php", 2, _MD_IMGLOSSARY_RECEIVED );
			} 
		} else {
			redirect_header( "submit.php", 2, _MD_IMGLOSSARY_ERRORSAVINGDB );
		} 
		exit();
		break;

	case 'form':
	default:
		global $xoopsUser, $_SERVER;
		
        if ( !is_object( $xoopsUser ) ) {
			$name = _MD_IMGLOSSARY_GUEST;
        } else {
			$name = ucfirst( $xoopsUser -> getVar( 'uname' ) );
        }

		//$xoopsOption['template_main'] = 'imglossary_submit.html';
		//include ICMS_ROOT_PATH . '/header.php';
		
		$xoopsTpl -> assign( 'send_def_to', sprintf( _MD_IMGLOSSARY_SUB_SNEWNAME, ucfirst( $xoopsModule -> name() ) ) );
		$xoopsTpl -> assign( 'send_def_g', sprintf( _MD_IMGLOSSARY_SUB_SNEWNAME, ucfirst( $xoopsModule -> name() ) ) );
		$xoopsTpl -> assign( 'wb_user_name', $name );

		$block = 1;
		$html = 1;
		$smiley = 1;
		$xcodes = 1;
		$breaks = 1;
		$categoryID = 0;
		$notifypub = 1;
		$term = $termino;
		$definition = '';
		$ref = '';
		$url = '';

		include_once 'include/storyform.inc.php';
		
		$xoopsTpl -> assign( 'modulename', $xoopsModule -> dirname() );

		$sform -> assign( $xoopsTpl );

		$xoopsTpl -> assign( 'lang_modulename', $xoopsModule -> name() );
		$xoopsTpl -> assign( 'lang_moduledirname', $xoopsModule -> dirname() );		
		
		$xoopsTpl -> assign( 'xoops_module_header', '<link rel="stylesheet" type="text/css" href="style.css" />');

		//include ICMS_ROOT_PATH . '/footer.php';
		
		break;
} 

?>