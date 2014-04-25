<?php
include './tasks.php';
include './Template.php';
$head = '<script src="/api/timeline-api.js?bundle=true" type="text/javascript"></script>

        <link rel="stylesheet" href="/css/styles.css" type="text/css" /> <!-- load your css after Timelines -->
        <script src="js/timeline_p.js" type="text/javascript"></script>

     <style type="text/css">
            /* These css rules are used to modify the display of events with classname attribute */
            /* In a production system, the rules should be in an external css file to enable     */
            /* shared use and caching                                                            */
            .special_event {font-variant: small-caps; font-weight: bold;}
            .timeline-date-label{
bottom:5px !important;            
}
        </style>';

$header = new Template('./header.php', array("head" => $head, "current_page" => 1, "body" => 'onload="onLoad();" onresize="onResize();"'));
$header->out();
if ($_SESSION['access_level'] == 1) {
    header('Location: /Timeline.php');
}
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
<input type="hidden" id="project_uid" value="2"/>
<script>$("#tl").height($(document).height() - 70);</script>
</body>
</html>