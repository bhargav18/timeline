<?php
include './tasks.php';
include './Template.php';
$head='<!-- Style-->
        <style>
            html, body {
                height:100%;
                padding: 0px;
                margin: 0px;
            }
        </style>';

$header = new Template('./header.php',array(head=>$head,current_page=>1));
$header->out();

$tasks = new tasks();
$task_list = $tasks->getTasks($_SESSION['user_uid']);
//print_r( $task_list);
//echo $_SESSION['user_uid'];
?>
<!--

88888888888 d8b                        888 d8b                888888   d8888b  
   888     Y8P                        888 Y8P                   88b d88P  Y88b 
   888                                888                       888 Y88b
   888     888 88888b d88b     d88b   888 888 88888b     d88b   888   Y888b
   888     888 888  888  88b d8P  Y8b 888 888 888  88b d8P  Y8b 888      Y88b
   888     888 888  888  888 88888888 888 888 888  888 88888888 888        888 
   888     888 888  888  888 Y8b      888 888 888  888 Y8b      88P Y88b  d88P 
   888     888 888  888  888   Y8888  888 888 888  888   Y8888  888   Y8888P
                                                               d88P            
                                                             d88P             
                                                           888P              
    -->
        <!-- BEGIN Timeline Embed -->
        <div id="timeline-embed"></div>
        <script type="text/javascript">
            var data = {
                "timeline":
                        {
                            "headline": <?= '"' . $task_list[0]['name'] . '"' ?>,
                            "type": "default",
                            "text": <?= '"' . $task_list[0]['brief'] . '"' ?>,
                            "startDate": <?
$date = DateTime::createFromFormat("Y-m-d", $task_list[0]['start_date']);
echo '"' . $date->format("Y,n,j") . '"';

?>,
                            "date": [
<?for($i=0;$i<  count($task_list);$i++){?>
                                {
                                    "startDate":<?
$date = DateTime::createFromFormat("Y-m-d", $task_list[$i]['start_date']);
echo '"' . $date->format("Y,n,j") . '"';
?>,
                                    "endDate": <?
$date = DateTime::createFromFormat("Y-m-d", $task_list[$i]['end_date']);
echo '"' . $date->format("Y,n,j") . '"';
?>,
                                    "headline": <?= '"' . $task_list[$i]['name'] . '"' ?>,
                                    "text":<?= '"' . $task_list[$i]['brief'] . '"' ?>,
                                    "asset":
                                            {
                                                "media": "",
                                                "credit": "",
                                                "caption": ""
                                            }
                                }
                                <? if(count($task_list)>0){echo ",";} }?>
                            ]
                        }
            };

            var timeline_config = {
                width: "100%",
                height: "100%",
                source: data
            }
        </script>
        <script type="text/javascript" src="../build/js/storyjs-embed.js"></script>
        <!-- END Timeline Embed-->
    </body>
</html>