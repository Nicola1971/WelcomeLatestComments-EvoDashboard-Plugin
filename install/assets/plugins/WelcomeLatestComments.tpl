//<?php
/**
 * WelcomeLatestComments
 *
 * Dashboard latest comments widget plugin for EvoDashboard
 *
 * @author    Nicola Lambathakis
 * @category    plugin
 * @version    3.0 RC
 * @license	 http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @events OnManagerWelcomeHome
 * @internal    @installset base
 * @internal    @modx_category Dashboard
 * @internal    @properties  &WidgetTitle= Widget Title:;string;Latest Comments &parents= Parent folders:;string;0 &count= retrieve n° comments:;string;10 &trunc= Trunc text:;string;120 &datarow=widget row position:;list;1,2,3,4,5,6,7,8,9,10;1 &datacol=widget col position:;list;1,2,3,4;1 &datasizex=widget x size:;list;1,2,3,4;4 &datasizey=widget y size:;list;1,2,3,4,5,6,7,8,9,10;2
 */

/**
 * WelcomeLatestComments RC 3.0
 * author Nicola Lambathakis http://www.tattoocms.it/
 *
 * Dashboard latest comments widget plugin for EvoDashboard
 * Event: OnManagerWelcomeHome
&WidgetTitle= Widget Title:;string;Latest Comments &parents= Parent folders:;string;0 &count= retrieve n° comments:;string;10 &trunc= Trunc text:;string;120 &datarow=widget row position:;list;1,2,3,4,5,6,7,8,9,10;1 &datacol=widget col position:;list;1,2,3,4;1 &datasizex=widget x size:;list;1,2,3,4;4 &datasizey=widget y size:;list;1,2,3,4,5,6,7,8,9,10;2
****
*/
// Run the main code
include($modx->config['base_path'].'assets/plugins/welcomelatestcomments/latestcomments.php');