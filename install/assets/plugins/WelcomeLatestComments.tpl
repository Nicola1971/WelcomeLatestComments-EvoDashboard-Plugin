//<?php
/**
 * WelcomeLatestComments
 *
 * Dashboard latest comments widget plugin for EvoDashboard
 *
 * @author    Nicola Lambathakis
 * @category    plugin
 * @version    1.0 RC
 * @license	 http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal    @events OnManagerWelcomePrerender,OnManagerWelcomeHome,OnManagerWelcomeRender
 * @internal    @installset base
 * @internal    @modx_category Dashboard
 * @internal    @properties  &WidgetEvoEvent= Widget Box placement:;list;OnManagerWelcomePrerender,OnManagerWelcomeHome,OnManagerWelcomeRender;OnManagerWelcomePrerender &WidgetBoxSize= Widget size:;list;dashboard-block-full,dashboard-block-half;dashboard-block-half &WidgetTitle= Widget Title:;string;Latest Comments &parents= Parent folders:;string;0 &count= Retrieve n° comments:;string;10 &trunc= Trunc text:;string;120  
 */

/**
 * WelcomeLatestComments RC 1.0
 * author Nicola Lambathakis http://www.tattoocms.it/
 *
 * Dashboard latest comments widget plugin for EvoDashboard
 * Event: OnManagerWelcomePrerender,OnManagerWelcomeHome,OnManagerWelcomeRender
&WidgetEvoEvent= Widget Box placement:;list;OnManagerWelcomePrerender,OnManagerWelcomeHome,OnManagerWelcomeRender;OnManagerWelcomePrerender &WidgetBoxSize= Widget size:;list;dashboard-block-full,dashboard-block-half;dashboard-block-half &WidgetTitle= Widget Title:;string;Latest Comments &parents= Parent folders:;string;0 &count= Retrieve n° comments:;string;10 &trunc= Trunc text:;string;120
****
*/
// Run the main code
include($modx->config['base_path'].'assets/plugins/welcomelatestcomments/latestcomments.php');