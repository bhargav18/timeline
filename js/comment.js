/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function get_comments(){
     
    $.ajax({
        url:'functions.php?action=get_comments',
        type:'post',
        data:'task_uid='+$('#tasks_list').val(),
        success:function(response){ 
        if(response === "\n0"){
             $('div.post-bottom-section').html("<h2>There is no comment for this task</h2>");
        }else{            
            $('div.post-bottom-section').html(response);
            $('#taskid').val($('#tasks_list').val());
        }
        }
    });
    
}
