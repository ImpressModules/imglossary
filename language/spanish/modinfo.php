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
define("_MI_WB_MD_NAME", "Wordbook");

// A brief description of this module
define("_MI_WB_MD_DESC", "Un glosario multicategor�a");

// Sub menus in main menu block
define("_MI_WB_SUB_SMNAME1", "Enviar definici�n");
define("_MI_WB_SUB_SMNAME2", "Pedir definici�n");
define("_MI_WB_SUB_SMNAME3", "Buscar definici�n");

define("_MI_WB_RANDOMTERM", "T�rmino al azar");

// A brief description of this module
define("_MI_WB_ALLOWSUBMIT", "1. �Pueden los usuarios enviar definiciones?");
define("_MI_WB_ALLOWSUBMITDSC", "Si se define como 'S�', los usuarios tendr�n acceso al formulario de env�o");

define("_MI_WB_ANONSUBMIT", "2. Pueden los invitados enviar definiciones?");
define("_MI_WB_ANONSUBMITDSC", "Si se define como 'S�', los invitados tendr�n acceso al formulario de env�o");

define("_MI_WB_DATEFORMAT", "3. �En qu� formato debe verse la fecha?");
define("_MI_WB_DATEFORMATDSC", "Usa la parte final de language/english/global.php para elegir un estilo. Ejemplo: 'd-M-Y H:i' significa '23-Mar-2004 22:35'");

define("_MI_WB_PERPAGE", "4. �N�mero de definiciones por p�gina (Administrador)?");
define("_MI_WB_PERPAGEDSC", "N�mero de definiciones que se ver�n a la vez en la tabla que muestra definiciones en el lado del administrador.");

define("_MI_WB_PERPAGEINDEX", "5. �N�mero de definiciones por p�gina (Usuario)?");
define("_MI_WB_PERPAGEINDEXDSC", "N�mero de definiciones que se mostrar�n en cada p�gina del m�dulo, en el lado del usuario .");

define("_MI_WB_AUTOAPPROVE", "6. �Aprobar definiciones en autom�tico?");
define("_MI_WB_AUTOAPPROVEDSC", "Si se define como 'S�', XOOPS publicar� las definiciones enviadas sin intervenci�n del administrador.");

define("_MI_WB_MULTICATS", "7. �Quieres tener categor�as?");
define("_MI_WB_MULTICATSDSC", "Si se define como 'S�', podr�s tener categor�as en tu glosario, o bien varios glosarios distintos. Si se define como 'No', tendr�s una sola categor�a autom�tica.");

define("_MI_WB_CATSINMENU","8. �Deben mostrarse las categor�as en el men�?"); 
define("_MI_WB_CATSINMENUDSC","Si se define como 'S�', habr� enlaces a las categor�as en el men� principal."); 

define("_MI_WB_CATSPERINDEX","9. �Categor�as por p�gina (Usuarios)?"); 
define("_MI_WB_CATSPERINDEXDSC","Esto definir� cu�ntas categor�as mostrar en la p�gina �ndice de categor�as."); 

define("_MI_WB_ALLOWADMINHITS", "10. �Contar�n tambi�n las visitas del administrador?");
define("_MI_WB_ALLOWADMINHITSDSC", "Si se define como 'S�', el contado se mover� para cada definici�n cuando la visite el administrador.");

define("_MI_WB_MAILTOADMIN", "11. �Enviar correo al administrador en cada nuevo env�o?");  
define("_MI_WB_MAILTOADMINDSC", "Si se define como 'S�', el administrador recibir� un e-mail para cada definici�n que se env�e al sitio.");  

define("_MI_WB_RANDOMLENGTH", "12. �Cu�ntos caracteres mostrar en t�rminos al azar?");  
define("_MI_WB_RANDOMLENGTHDSC", "�Cu�ntos caracteres quieres mostrar en los bloques de t�rminos al azar, tanto en la p�gina inicial del m�dulo como en el bloque? (Por defecto: 150)");

define("_MI_WB_LINKTERMS", "13. �Mostrar enlaces a otras definiciones del glosario en cada definici�n?");  
define("_MI_WB_LINKTERMSDSC", "Si se define como 'S�', autom�ticamente crear� enlaces en tus definiciones para aquellos t�rminos que ya tengas definidos en tus glosarios.");

// Names of admin menu items
define("_MI_WB_ADMENU1", "�ndice");
define("_MI_WB_ADMENU2", "Categor�as");
define("_MI_WB_ADMENU3", "Definiciones");
define("_MI_WB_ADMENU4", "Bloques");
define("_MI_WB_ADMENU5", "Ir al m�dulo");
//mondarse
define("_MI_WB_ADMENU6", "Importar");

//Names of Blocks and Block information
define("_MI_WB_ENTRIESNEW", "T�rminos m�s nuevos");
define("_MI_WB_ENTRIESTOP", "T�rminos m�s le�dos");

?>