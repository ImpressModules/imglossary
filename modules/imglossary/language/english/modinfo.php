<?php
/**
 * $Id: main.php v 1.0 8 May 2004 hsalazar Exp $
 * Module: Wordbook - a multicategory glossary
 * Version: v 1.00
 * Release Date: 8 May 2004
 * Author: hsalazar
 * Licence: GNU
 */

// Module Info
// The name of this module
global $xoopsModule;
define("_MI_WB_MD_NAME", "imGlossary");

// A brief description of this module
define("_MI_WB_MD_DESC", "A multicategory glossary");

// Sub menus in main menu block
define("_MI_WB_SUB_SMNAME1", "Submit an entry");
define("_MI_WB_SUB_SMNAME2", "Request a definition");
define("_MI_WB_SUB_SMNAME3", "Search for a definition");

define("_MI_WB_RANDOMTERM", "Random term");

// A brief description of this module
define("_MI_WB_ALLOWSUBMIT", "Can users submit entries?");
define("_MI_WB_ALLOWSUBMITDSC", "If set to 'Yes', users will have access to a submission form");

define("_MI_WB_ANONSUBMIT", "Can guests submit entries?");
define("_MI_WB_ANONSUBMITDSC", "If set to 'Yes', guests will have access to a submission form");

define("_MI_WB_DATEFORMAT", "In what format should the date appear?");
define("_MI_WB_DATEFORMATDSC", "Use the final part of language/english/global.php to select a display style. Example: 'd-M-Y H:i' translates to '23-Mar-2004 22:35'");

define("_MI_WB_PERPAGE", "Number of entries per page (Admin side)?");
define("_MI_WB_PERPAGEDSC", "Number of entries that will be shown at once in the table that displays active entries in the admin side.");

define("_MI_WB_PERPAGEINDEX", "Number of entries per page (User side)?");
define("_MI_WB_PERPAGEINDEXDSC", "Number of entries that will be shown on each page in the user side of the module.");

define("_MI_WB_AUTOAPPROVE", "Approve entries automatically?");
define("_MI_WB_AUTOAPPROVEDSC", "If set to 'Yes', ImpressCMS will publish submitted entries without admin intervention.");

define("_MI_WB_MULTICATS", "Do you want to have glossary categories?");
define("_MI_WB_MULTICATSDSC", "If set to 'Yes', will allow you to have glossary categories. If set to no, will have a single automatic category.");

define("_MI_WB_CATSINMENU","Should the categories be shown in the menu?"); 
define("_MI_WB_CATSINMENUDSC","If set to 'Yes' if you want links to categories in the main menu."); 

define("_MI_WB_CATSPERINDEX","Number of categories per page (User side)?"); 
define("_MI_WB_CATSPERINDEXDSC","This will define how many categories will be shown in the index page."); 

define("_MI_WB_ALLOWADMINHITS", "Will the admin hits be included in the counter?");
define("_MI_WB_ALLOWADMINHITSDSC", "If set to 'Yes', will increase counter for each entry on admin visits.");

define("_MI_WB_MAILTOADMIN", "Send mail to admin on each new submission?");  
define("_MI_WB_MAILTOADMINDSC", "If set to 'Yes', the manager will receive an e-mail for every submitted entry."); 
 
define("_MI_WB_RANDOMLENGTH", "Length of string to show in random definitions?");  
define("_MI_WB_RANDOMLENGTHDSC", "How many characters do you want to show in the random term boxes, both in the main page and in the block? (Default: 150)");

define("_MI_WB_LINKTERMS", "Show links to other glossary terms in the definitions?");  
define("_MI_WB_LINKTERMSDSC", "If set to 'yes', will automatically link in your definitions those terms you already have in your glossaries.");

// Names of admin menu items
define("_MI_WB_ADMENU1", "Index");
define("_MI_WB_ADMENU2", "Categories");
define("_MI_WB_ADMENU3", "Entries");
define("_MI_WB_ADMENU4", "Blocks");
define("_MI_WB_ADMENU5", "Go to module");
//mondarse
define("_MI_WB_ADMENU6", "Import");

//Names of Blocks and Block information
define("_MI_WB_ENTRIESNEW", "Newest Terms");
define("_MI_WB_ENTRIESTOP", "Most Read Terms");

?>