<?php
/**
 * WelcomeLatestComments RC 3.0
 * author Nicola Lambathakis http://www.tattoocms.it/
 *
 * Dashboard latest comments widget plugin for EvoDashboard
 *
 * Event: OnManagerWelcomePrerender,OnManagerWelcomeHome,OnManagerWelcomeRender
&WidgetTitle= Widget Title:;string;Latest Comments &parents= Parent folders:;string;0 &count= retrieve n° comments:;string;10 &trunc= Trunc text:;string;120 &datarow=widget row position:;list;1,2,3,4,5,6,7,8,9,10;1 &datacol=widget col position:;list;1,2,3,4;1 &datasizex=widget x size:;list;1,2,3,4;4 &datasizey=widget y size:;list;1,2,3,4,5,6,7,8,9,10;2
****
*/

//widget name
$WidgetID = isset($WidgetID) ? $WidgetID : 'CommentsBox';
// size and position
$datarow = isset($datarow) ? $datarow : '1';
$datacol = isset($datacol) ? $datacol : '2';
$datasizex = isset($datasizex) ? $datasizex : '2';
$datasizey = isset($datasizey) ? $datasizey : '2';
//output
$WidgetOutput = isset($WidgetOutput) ? $WidgetOutput : '';
//events
$EvoEvent = isset($EvoEvent) ? $EvoEvent : 'OnManagerWelcomeHome';
$output = "";
$e = &$modx->Event;



/**************************************************************latest comment snippet*/
/*  Based on LatestComments Snippet by Aleksander Maksymiuk, http://setpro.net.pl/*/

$parents = isset($parents) && $parents ? $parents : 0;
$count = isset($count) && $count ? $count : 6;
$customFields = isset($customFields) && $customFields ? $customFields : 'name,email';
$posterField  = isset($posterField) && $posterField ? $posterField : 'name';
$dateFormat = isset($dateFormat) && $dateFormat ? $dateFormat : 'Y-m-d, H:i:s';
$trunc = isset($trunc) && $trunc ? $trunc : 0;
$truncSym = isset($truncSym) && $truncSym ? $truncSym : '...';


$tplComment = "
<tr><td><b class='text-success'>[+jcf_name+]</b> <p class='text-warning'> [+createdon+] </p></td>
    <td>[+content+]</td>
    <td>[+doc_pagetitle+] </td>

	<td><a href='../index.php?id=[+doc_id+]' data-toggle='tooltip' data-placement='top' title='Preview' target='_blank'><i class='icon-custom icon-no-border fa fa-eye icon-color-light-green icon-no-border'></i></a> </td>
	<td><a href='index.php?a=27&id=[+doc_id+]' data-toggle='tooltip' data-placement='top' title='Edit'> <i class='icon-custom fa fa-pencil-square-o icon-color-red icon-no-border'></i></a></td>

	</tr>";


# get proper table names
$jotContent = $modx->getFullTableName('jot_content');
$jotFields = $modx->getFullTableName('jot_fields');
$siteContent = $modx->getFullTableName('site_content');
$GLOBALS['siteContent'] = $siteContent;
# get Jot custom fields
$jcf = explode(',', $customFields);
# build subqueries
$subqueries = '';
foreach ($jcf as $field) {
    $subqueries .= "(SELECT " . $jotFields . ".content " .
        "FROM " . $jotFields . " " .
        "WHERE " . $jotFields . ".label = '" . $field . "' " .
            "AND " . $jotFields . ".id = " . $jotContent . ".id) " .
    "AS jcf_" . $field . ", ";
}
# build query
$query = "SELECT " .
    # fetch comment's fields
        $jotContent . ".*, " .
    # fetch comment's custom fields
        $subqueries .
    # fetch some document's fields
        $siteContent . ".id AS doc_id, " .
        $siteContent . ".pagetitle AS doc_pagetitle, " .
        $siteContent . ".longtitle AS doc_longtitle, " .
        $siteContent . ".description AS doc_description, " .
        $siteContent . ".introtext AS doc_introtext " .
    "FROM " . $jotContent . " " .
    "INNER JOIN " . $siteContent . " " .
        "ON " . $jotContent . ".uparent = " . $siteContent . ".id " .
    "WHERE " . $siteContent . ".published = '1' " .
        "AND " . $siteContent . ".deleted = '0' " .
        "AND " . $jotContent . ".published = '1' " .
        "AND " . $jotContent . ".deleted = '0' " .
        ($parents ? "AND " . $siteContent . ".id IN (" . buildScope($parents) . ") " : "") .
    "ORDER BY " . $jotContent . ".createdon DESC " .
    "LIMIT 0, " . $count;
# start rendering output
$output = "";
$e = &$modx->Event;
if($e->name == ''.$EvoEvent.'') {

if (($result = mysql_query($query)) && mysql_num_rows($result)) {
    while ($row = mysql_fetch_assoc($result)) {
        if ($row['createdby']) {
            $info = $row['createdby'] < 0 ? $modx->getWebUserInfo(-$row['createdby']) : $modx->getUserInfo($row['createdby']);
            $row['createdby'] = $info['fullname'] ? $info['fullname'] : $info['username'];
            $row['jcf_' . $posterField] = $row['createdby'];
        } else {
            $row['createdby'] = $row['jcf_' . $posterField];
        }
        $row['createdon'] = date($dateFormat, $row['createdon']);
        if ($row['editedby']) {
            $info = $modx->getUserInfo($row['editedby']);
            $row['editedby'] = $info['fullname'];
        }
        $row['editedon'] = date($dateFormat, $row['editedon']);
        if ($row['publishedby']) {
            $info = $modx->getUserInfo($row['publishedby']);
            $row['publishedby'] = $info['fullname'];
        }
        $row['publishedon'] = date($dateFormat, $row['publishedon']);
        # fill in template with actual data
        $item = $tplComment;
        foreach ($row as $key => $value) {
            $item = str_replace('[+' . $key . '+]',
                ($key == 'content' ?
                    preg_replace('/\r?\n|\r\n?/', '<br />',
                        htmlspecialchars(
                            ($trunc ?
                                mb_substr($value, 0, $trunc, 'UTF-8') . $truncSym :
                                $value
                            )
                        )
                    ) :
                    htmlspecialchars($value)
                ),
                $item
            );
        }
        $commentsoutput .= $item;
    }
    mysql_free_result($result);
}

/*###latest comment*/

/*Widget Box */

$WidgetOutput = '
<li id="'.$WidgetID.'" data-row="'.$datarow.'" data-col="'.$datacol.'" data-sizex="'.$datasizex.'" data-sizey="'.$datasizey.'">
                    <div class="panel panel-default widget-wrapper">
                      <div class="panel-headingx widget-title sectionHeader clearfix">
                          <span class="pull-left"><i class="fa fa-link"></i> '.$WidgetTitle.'</span>
                            <div class="widget-controls pull-right">
                                <div class="btn-group">
                                    <a href="#" class="btn btn-default btn-xs panel-hide hide-full glyphicon glyphicon-minus" data-id="'.$WidgetID.'"></a>
                                </div>     
                            </div>

                      </div>
                      <div class="panel-body widget-stage sectionBody">
                       <div class="table-responsive"> <table class="table-striped table-bordered">'.$commentsoutput.'</table>
                      </div>
                    </div>           
                </li>

';

}
//end Widget
$output = $WidgetOutput;
$e->output($output);
return;
?>