<?php
/**
 * $Id: search.inc.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

function imgloss_search( $queryarray, $andor, $limit, $offset, $userid )	{

	global $xoopsUser, $xoopsDB;
	
	$sql = "SELECT entryID, term, definition, ref, uid, datesub FROM " . $xoopsDB -> prefix( 'imglossary_entries' ) . " WHERE submit=0 AND offline=0";

	if ( $userid != 0 ) {
        $sql .= " AND uid=" . $userid . " ";
    }

	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	if ( is_array( $queryarray ) && $count = count( $queryarray ) ) {
		$sql .= " AND ( ( term LIKE LOWER('%$queryarray[0]%') OR LOWER(definition) 
							   LIKE LOWER('%$queryarray[0]%') OR LOWER(ref) 
							   LIKE LOWER('%$queryarray[0]%') )";
		for ( $i = 1; $i < $count; $i++ ) {
			$sql .= " $andor ";
			$sql .= "( term LIKE LOWER('%$queryarray[$i]%') OR LOWER(definition) 
						    LIKE LOWER('%$queryarray[$i]%') OR LOWER(ref) 
						    LIKE LOWER('%$queryarray[$i]%') )";
		} 
		$sql .= ") ";
	} 
	$sql .= "ORDER BY entryID DESC";
	$result = $xoopsDB -> query( $sql, $limit, $offset );
    $ret = array();
    $i = 0;

	while ( $myrow = $xoopsDB -> fetchArray( $result ) ) {
		$ret[$i]['image'] = "images/wb.png";
		$ret[$i]['link'] = "entry.php?entryID=" . $myrow['entryID'];
		$ret[$i]['title'] = $myrow['term'];
		$ret[$i]['time'] = $myrow['datesub'];
		$ret[$i]['uid'] = $myrow['uid'];
		$i++;
	} 
	return $ret;
} 
?>