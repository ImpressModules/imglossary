<?php
/**
 * $Id: icms_version.php
 * Module: imGlossary - a multicategory glossary 
 * Version: 1.00
 * Author: McDonald
 * Licence: GNU
 */
 
if ( !defined( "ICMS_ROOT_PATH" ) ) die( "ICMS root path not defined" );
 
$glossdirname = basename( dirname( __FILE__ ) );

global $xoopsConfig;

include_once ICMS_ROOT_PATH . '/language/'. $xoopsConfig['language'] . '/moduleabout.php';

//	** General information
$modversion = array(
	'name' 				=> _MI_IMGLOSSARY_MD_NAME,
	'version' 			=> "1.00",
	'status' 			=> "RC-1",
	'status_version'	=> "RC-1",
	'date'				=> "12 October 2008",
	'description' 		=> _MI_IMGLOSSARY_MD_DESC,
	'author' 			=> "McDonald",
	'credits' 			=> "hsalazar, Catzwolf",
	'support_site_url' 	=> "http://community.impresscms.org/modules/newbb/",
	'support_site_name' => "ImpressCMS Community - Modules Support Forum",
	'license' 			=> "GNU General Public License (GPL)",
	'official' 			=> 0,
	'image' 			=> "images/imglossary_logo.png",		// Module logo
	'iconbig' 			=> "images/imglossary_iconsbig.png",	// Control Panel icon
	'iconsmall' 		=> "images/imglossary_iconsmall.png",	// Module menu icon
	'dirname' 			=> $glossdirname 
	);

// 	** Contributors **
$modversion['people']['developers'][]  = "[url=http://community.impresscms.org/userinfo.php?uid=179]McDonald[/url]";
$modversion['people']['translators'][] = "[url=http://community.impresscms.org/userinfo.php?uid=10]sato-san[/url] (German)";
$modversion['people']['translators'][] = "[url=http://community.impresscms.org/userinfo.php?uid=371]wuddel[/url] (German)";
$modversion['people']['translators'][] = "[url=http://community.impresscms.org/userinfo.php?uid=179]McDonald[/url] (Dutch)";
$modversion['people']['translators'][] = "[url=http://community.impresscms.org/userinfo.php?uid=14]GibaPhp[/url] (Portuguese-Brazil)";
$modversion['people']['translators'][] = "[url=http://community.impresscms.org/userinfo.php?uid=97]debianus[/url] (Spanish)";

//	** If Release Candidate **
$modversion['warning'] = _MODABOUT_WARNING_RC;

//	** If Final  **
//$modversion['warning'] = _MODABOUT_WARNING_FINAL;

// 	** Admin things **
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/imglossary.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = "imglossary_cats";
$modversion['tables'][1] = "imglossary_entries";

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "imglossary_search";

// Menu
global $xoopsUser, $xoopsDB, $xoopsModule;

$modversion['hasMain'] = 1;
$hModConfig =& xoops_gethandler('config');
$hModule =& xoops_gethandler('module');
if ( $imglossaryModule =& $hModule -> getByDirname( $glossdirname ) ) {
	$imglossaryConfig =& $hModConfig -> getConfigsByCat( 0, $imglossaryModule -> getVar('mid') );
	//if ( isset($wimglossaryConfig['catsinmenu']) && $imglossaryConfig['anonpost'] == 1 )
	if ( ( $xoopsUser && ( $imglossaryConfig['allowsubmit'] == 1 ) ) || ( $imglossaryConfig['anonpost'] == 1 ) ) {
		$modversion['sub'][1]['name'] = _MI_IMGLOSSARY_SUB_SMNAME1;
		$modversion['sub'][1]['url'] = "submit.php";	
	}
}
//if ($xoopsUser)
//	{
//	$modversion['sub'][1]['name'] = _MI_IMGLOSSARY_SUB_SMNAME1;
//	$modversion['sub'][1]['url'] = "submit.php";
//	}
$modversion['sub'][2]['name'] = _MI_IMGLOSSARY_SUB_SMNAME2;
$modversion['sub'][2]['url'] = "request.php";
$modversion['sub'][3]['name'] = _MI_IMGLOSSARY_SUB_SMNAME3;
$modversion['sub'][3]['url'] = "search.php";


$sql = $xoopsDB -> query( "SELECT categoryID, name FROM " . $xoopsDB -> prefix( 'imglossary_cats' ) . " " );
$i = 4;
$hModConfig =& xoops_gethandler( 'config' );
$hModule =& xoops_gethandler( 'module' );
if ($imglossaryModule =& $hModule -> getByDirname( $glossdirname ) ) {
	$imglossaryConfig =& $hModConfig -> getConfigsByCat( 0, $imglossaryModule -> getVar('mid') );
	if ( isset( $imglossaryConfig['catsinmenu'] ) && $imglossaryConfig['catsinmenu'] == 1 )	{
		while ( list( $categoryID, $name ) = $xoopsDB -> fetchRow( $sql ) ) {
			$modversion['sub'][$i]['name'] = $name;
			$modversion['sub'][$i]['url'] = "category.php?categoryID=" . $categoryID . "";
			$i++;
		} 
	}
}

// Blocks
$modversion['blocks'][1]['file'] = "entries_new.php";
$modversion['blocks'][1]['name'] = _MI_IMGLOSSARY_ENTRIESNEW;
$modversion['blocks'][1]['description'] = "Shows new entries";
$modversion['blocks'][1]['show_func'] = "b_entries_new_show";
$modversion['blocks'][1]['edit_func'] = "b_entries_new_edit";
$modversion['blocks'][1]['options'] = "datesub|5|d F Y";
$modversion['blocks'][1]['template'] = "imglossary_entries_new.html";

$modversion['blocks'][2]['file'] = "entries_top.php";
$modversion['blocks'][2]['name'] = _MI_IMGLOSSARY_ENTRIESTOP;
$modversion['blocks'][2]['description'] = "Shows popular entries";
$modversion['blocks'][2]['show_func'] = "b_entries_top_show";
$modversion['blocks'][2]['edit_func'] = "b_entries_top_edit";
$modversion['blocks'][2]['options'] = "counter|5";
$modversion['blocks'][2]['template'] = "imglossary_entries_top.html";

$modversion['blocks'][3]['file'] = "random_term.php";
$modversion['blocks'][3]['name'] = _MI_IMGLOSSARY_RANDOMTERM;
$modversion['blocks'][3]['description'] = "Shows a random term";
$modversion['blocks'][3]['show_func'] = "b_entries_random_show";
$modversion['blocks'][3]['template'] = "imglossary_entries_random.html";

// Templates
$modversion['templates'][1]['file'] = 'imglossary_category.html';
$modversion['templates'][1]['description'] = 'Display categories';
$modversion['templates'][2]['file'] = 'imglossary_index.html';
$modversion['templates'][2]['description'] = 'Display index';
$modversion['templates'][3]['file'] = 'imglossary_entry.html';
$modversion['templates'][3]['description'] = 'Display entry';
$modversion['templates'][4]['file'] = 'imglossary_letter.html';
$modversion['templates'][4]['description'] = 'Display letter';
$modversion['templates'][5]['file'] = 'imglossary_search.html';
$modversion['templates'][5]['description'] = 'Search in glossary';
$modversion['templates'][6]['file'] = 'imglossary_request.html';
$modversion['templates'][6]['description'] = 'Request a definition';
//$modversion['templates'][7]['file'] = 'imglossary_submit.html';
//$modversion['templates'][7]['description'] = 'Submit a definition';

global $xoopsmoduleConfig;
// Config Settings (only for modules that need config settings generated automatically)
$i = 0;
$i++;
$modversion['config'][$i]['name'] = 'allowsubmit';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_ALLOWSUBMIT';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_ALLOWSUBMITDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'anonpost';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_ANONSUBMIT';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_ANONSUBMITDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'dateformat';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_DATEFORMAT';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_DATEFORMATDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'd-M-Y H:i';
$i++;
$modversion['config'][$i]['name'] = 'perpage';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_PERPAGE';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_PERPAGEDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = array( '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50 );
$i++;
$modversion['config'][$i]['name'] = 'indexperpage';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_PERPAGEINDEX';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_PERPAGEINDEXDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;
$modversion['config'][$i]['options'] = array( '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50 );
$i++;
$modversion['config'][$i]['name'] = 'autoapprove';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_AUTOAPPROVE';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_AUTOAPPROVEDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'multicats';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_MULTICATS';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_MULTICATSDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'catsinmenu';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_CATSINMENU';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_CATSINMENUDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
/* $i++;
* $modversion['config'][$i]['name'] = 'catsperindex';
* $modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_CATSPERINDEX';
* $modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_CATSPERINDEXDSC';
* $modversion['config'][$i]['formtype'] = 'select';
* $modversion['config'][$i]['valuetype'] = 'int';
* $modversion['config'][$i]['default'] = 3;
* $modversion['config'][$i]['options'] = array( '1' => 1, '3' => 3, '5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50 );
*/
$i++;
$modversion['config'][$i]['name'] = 'sortcats';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_SORTCATS';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_SORTCATSDSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'name';
$modversion['config'][$i]['options'] = array( '_MI_IMGLOSSARY_TITLE' => 'name',
                                              '_MI_IMGLOSSARY_WEIGHT' => 'weight'
                                              );
$i++;
$modversion['config'][$i]['name'] = 'adminhits';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_ALLOWADMINHITS';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_ALLOWADMINHITSDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'mailtoadmin';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_MAILTOADMIN';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_MAILTOADMINDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;
$i++;
$modversion['config'][$i]['name'] = 'rndlength';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_RANDOMLENGTH';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_RANDOMLENGTHDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 500;
$i++;
$modversion['config'][$i]['name'] = 'linkterms';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_LINKTERMS';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_LINKTERMSDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'showsubmitter';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_SHOWSUBMITTER';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_SHOWSUBMITTERDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'showsbookmarks';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_SHOWSBOOKMARKS';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_SHOWSBOOKMARKSDSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;
$i++;
$modversion['config'][$i]['name'] = 'searchcolor';
$modversion['config'][$i]['title'] = '_MI_IMGLOSSARY_SEARCHCOLOR';
$modversion['config'][$i]['description'] = '_MI_IMGLOSSARY_SEARCHCOLORDSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '#FFFF00';
$i = 0;
//Comments
$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'entryID';
$modversion['comments']['pageName'] = 'entry.php';

$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'imglossary_com_approve';
$modversion['comments']['callback']['update'] = 'imglossary_com_update';

// On Update
if ( ! empty( $_POST['fct'] ) && ! empty( $_POST['op'] ) && $_POST['fct'] == 'modulesadmin' && $_POST['op'] == 'update_ok' && $_POST['dirname'] == $modversion['dirname'] )
{
    include dirname( __FILE__ ) . "/include/onupdate.inc.php" ;
}

?>