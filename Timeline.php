<?php
session_start();
if ($_SESSION['access_level'] == 2) {
    if (!isset($_GET['project'])) {
        header("Location: /Timeline_project.php");
    }
}
include './tasks.php';
include './Template.php';
$custom_msg="";
$comment = TRUE;
if($_SESSION['access_level'] == 2){
    $custom_msg="<script>var custom_msg='There is no task for this project.'</script>";
}else{
    $custom_msg="<script>var custom_msg='There is no task assigned to you.'</script>";
}
$head = $custom_msg.'<script src="/api/timeline-api.js?bundle=true" type="text/javascript"></script>

        <link rel="stylesheet" href="/css/styles.css" tycommentpe="text/css" /> <!-- load your css after Timelines -->
        <script src="js/timeline.js" type="text/javascript"></script>

     <style type="text/css">
            /* These css rules are used to modify the display of events with classname attribute */
            /* In a production system, the rules should be in an external css file to enable     */
            /* shared use and caching                                                            */
            .special_event {font-variant: small-caps; font-weight: bold;}
            .timeline-date-label{
bottom:5px !important;            
}
        </style>';
$project="";
if($_SESSION['access_level'] == 2){
$project = $_GET['project'];    
}

$header = new Template('./header.php', array( "project"=>$project,"current_page" => 1, "head" => $head, "current_page=>1", "body" => 'onload="onLoad();" onresize="onResize();"'));
$header->out();
?>
<script>
    Timeline.DefaultEventSource.Event.prototype.fillTime = function(elmt,
            labeller) {
        if (this._instant) {
            if (this.isImprecise()) {

                elmt.appendChild(elmt.ownerDocument.createTextNode(this.getProperty("start")));
                elmt.appendChild(elmt.ownerDocument.createElement("br"));

                elmt.appendChild(elmt.ownerDocument.createTextNode(this.getProperty("end")));
            } else {

                elmt.appendChild(elmt.ownerDocument.createTextNode(this.getProperty("start")));
            }
        } else {
            if (this.isImprecise()) {
                elmt.appendChild(elmt.ownerDocument.createTextNode(
                        this.getProperty("start") + " ~ " +
                        this.getProperty("latestStart")));
                elmt.appendChild(elmt.ownerDocument.createElement("br"));
                elmt.appendChild(elmt.ownerDocument.createTextNode(
                        this.getProperty("earliestEnd") + " ~ " +
                        this.getProperty("end")));
            } else {

                elmt.appendChild(elmt.ownerDocument.createTextNode(this.getProperty("start")));
                elmt.appendChild(elmt.ownerDocument.createElement("br"));

                elmt.appendChild(elmt.ownerDocument.createTextNode(this.getProperty("end")));
            }
        }
    };
</script>
<div id="body">
    <div id="tl" class="timeline-default" style="float: left;width: 100%;position: absolute;left: 0px;top: 70px;margin-bottom:80px;">
    </div>
</div>
<input type="hidden" id="project_uid" value="<?php if ($_SESSION['access_level'] == 2) {
    if (isset($_GET['project'])) {
        echo $_GET['project'];
    } else {
        
    }
} else {
    echo 1;
} ?>"/>
<script>$("#tl").height($(document).height() - 70);</script>
</body>
</html>