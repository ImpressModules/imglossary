<?php 
/**
 * $Id: arts_new.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Soapbox
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */
 
function b_entries_new_show( $options )	{

	$glossdirname = basename( dirname( dirname( __FILE__ ) ) );
	
	global $xoopsDB, $xoopsModule, $xoopsModuleConfig, $xoopsUser;
	$myts = & MyTextSanitizer :: getInstance();

	$words = $xoopsDB -> query( "SELECT * FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . "" );
	$totalwords = $xoopsDB -> getRowsNum( $words );

	$block = array();
	$sql = "SELECT entryID, term, datesub FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE datesub<" . time() . " AND datesub>0 AND submit=0 AND offline=0 ORDER BY " . $options[0] . " DESC";
	$result = $xoopsDB -> query( $sql, $options[1], 0 );

	$hModule =& xoops_gethandler( 'module' );
	$hModConfig =& xoops_gethandler( 'config' );
	$wbModule =& $hModule -> getByDirname( $glossdirname );
	$module_id = $wbModule -> getVar( 'mid' );
	$module_name = $wbModule -> getVar( 'dirname' );
	$wbConfig =& $hModConfig -> getConfigsByCat( 0, $wbModule -> getVar( 'mid' ) );

	if ( $totalwords > 0 ) {
		// If there are definitions
		while ( list( $entryID, $term, $datesub ) = $xoopsDB -> fetchRow( $result ) ) {
			$newentries = array();
			$xoopsModule = XoopsModule::getByDirname( $glossdirname );
			$linktext = ucfirst( $myts -> makeTboxData4Show( $term ) );
			$newentries['dir'] = $xoopsModule -> dirname();
			$newentries['linktext'] = $linktext;
			$newentries['id'] = $entryID;
			$newentries['date'] = "<span style='font-size: x-small;'>" . formatTimestamp( $datesub, $options[2] ) . "</span>";

			$block['newstuff'][] = $newentries;
		} 
	}
	return $block;
} 

function b_entries_new_edit( $options )	{
	$form = "" . _MB_IMGLOSSARY_ORDER . "&nbsp;<select name='options[]'>";

	$form .= "<option value='datesub'";
	if ( $options[0] == "datesub" )	{
		$form .= " selected='selected'";
	} 
	
	$form .= ">" . _MB_IMGLOSSARY_DATE . "</option>\n";
	$form .= "<option value='counter'";
	
	if ( $options[0] == "counter" )	{
		$form .= " selected='selected'";
	} 
	
	$form .= ">" . _MB_IMGLOSSARY_HITS . "</option>\n";
	$form .= "<option value='weight'";
	if ( $options[0] == "weight" ) {
		$form .= " selected='selected'";
	} 
	
	$form .= ">" . _MB_IMGLOSSARY_WEIGHT . "</option>\n";
	$form .= "</select>\n";
	$form .= "&nbsp;<br />" . _MB_IMGLOSSARY_DISP . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;" . _MB_IMGLOSSARY_TERMS . "";
	$form .= "&nbsp;<br />" . _MB_IMGLOSSARY_DATEFORMAT . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_IMGLOSSARY_DATEFORMATMANUAL;

	return $form;
} 
?>