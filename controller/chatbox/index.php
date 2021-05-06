
<!------ Include the above in your HEAD tag ---------->


<style type="text/css">
  
  #click_chat{
    cursor: pointer;
  }
</style>




<link rel="stylesheet" type="text/css" href="chatbox/css/style.css">

<body>
  <br/>
   <br/>
<div class="container">
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Messages</h4>
              <input type="hidden" id="myid" value="<?=returnID_controller()?>">
              <input type="hidden" id="sender" value="">
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                <input type="text" class="search-bar"  placeholder="Search" >
                <span class="">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
            </div>
          </div>
          <div class="inbox_chat" id="inbox_chat">




          </div>
        </div>
        <div class="mesgs">

          <div class="msg_history" id="msg_history">

      
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg" id="msg_send" placeholder="Type a message" />
              <button class="msg_send_btn" id="msg_send_btn" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </div>


<script>
  
//--chatbox
    showgetAdminchat();
    //show admin chatbox/
  function showgetAdminchat(){
    $('#inbox_chat').html('');
      var datas = "showUser";
      var myid = $('#myid').val();

        $.ajax({
            url: "../ajax_product_cart.php",
            type: "post",
            data: { methodadmin:datas},
            success: function (data) {
              var arr = JSON.parse(data);
              $.each($(arr),function(key,value){
                var datas = "getlastMessage";
                 $.ajax({
                        url: "../ajax_product_cart.php",
                        type: "post",
                        data: { methods:datas,SENDER:myid,RECEIVER:value.id},
                        success: function (data) {
                            var arr = JSON.parse(data);
                            console.log(arr);
                            // var data = showAdminwithoutmsg(value.first_name+" "+value.last_name,value.id);
                            //   $('#inbox_chat').append(data);
                            if(typeof arr.message !== 'undefined'){
                              // var data = showAdmin(value.first_name+" "+value.last_name,value.id);
                                 var data = showAdmin(value.first_name+" "+value.last_name,arr.message,arr.date,value.id);
                               $('#inbox_chat').append(data);
                             } else{
                                var data = showAdminwithoutmsg(value.first_name+" "+value.last_name,value.id);
                                $('#inbox_chat').append(data);

                            }
                        },
                        error: function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert("error"+err.Message);
                        }
                  });
                //console.log(rmsg);
                // $('#inbox_chat').append(data);

              });
            },
            error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert("error"+err.Message);
            }
        });

    }

  function showAdminwithoutmsg(name,id){

    var msg = '<div class="chat_list " id="click_chat" data-id="'+id+'">'
                +'<div class="chat_people">'
                +'<div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>'
                +'<div class="chat_ib">'
                +'<h5>'+name+'</h5>'
                +'</div>'
                +'</div>'
                +'</div>';

      return msg;

  }
    function showAdmin(name,message,date,id){
    var date = date;
    date = date.split(' ')[0];
    var hrs = date.split(' ')[1];
    console.log(date)
      var msg = '<div class="chat_list"  id="click_chat" data-id="'+id+'">'
                +'<div class="chat_people">'
                +'<div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>'
                +'<div class="chat_ib">'
                 +'<h5>'+name+'<span class="chat_date">'+date+'</span></h5>'
                +'<p>'+message+'</p>'
                +'</div>'
                +'</div>'
                +'</div>';

      return msg;
    }


//---- msg

  $("#inbox_chat").delegate('#click_chat','click',function(e){
    $(this).attr('class', 'chat_list active_chat');
     var myid = $('#myid').val();
     var recievedid = $(this).data('id');
      $('#sender').val(recievedid);
      reloadmsg(myid,recievedid)

  });

    function reloadmsg(myid,recievedid){
      $('#msg_history').html('');
      var datas = "showmMsg";
     $.ajax({
        url: "../ajax_product_cart.php",
        type: "post",
        data: { methods2:datas,SENDER:myid,RECEIVER:recievedid},
        success: function (data) {
           var arr = JSON.parse(data);
           $.each($(arr),function(key,value){

            if(value.sender  == myid){
              var msg = send_msg(value.message);
              $('#msg_history').append(msg);
            }else{
               var msg = received_msg(value.message);
              $('#msg_history').append(msg);
            }

           });
          
        },
        error: function(xhr, status, error) {
          var err = eval("(" + xhr.responseText + ")");
          alert("error"+err.Message);
        }
      });
    }

    function received_msg(msg){
      var msg = '<div class="incoming_msg">'
                +'<div class="incoming_msg_img" data-toggle="tooltip" title="Hooray!"> '
                +'<img src="https://ptetutorials.com/images/user-profile.png" data-toggle="tooltip" title="Hooray!">'
                +'</div>'
                +'<div class="received_msg">'
                +'<div class="received_withd_msg">'
                +'<p>'+msg+'</p>'
                +'  <span class="time_date"> 11:01 AM    |    June 9</span></div>'
                +'</div>'
                +'</div>';
      return msg ;
    }
    function send_msg(msg){
        var msg =  '<div class="outgoing_msg">'
                  +'<div class="sent_msg">'
                  +'<p>'+msg+'</p>'
                  +'<span class="time_date"> 11:01 AM    |    Today</span> </div>'
                  +'</div>';
        return msg;
    }
///--
$("#msg_send_btn").click(function(){

    var myid = $('#myid').val();
    var receiver = $('#sender').val();
    var msg = $('#msg_send').val();

    var datas = "sendMsg";
     $.ajax({
        url: "../ajax_product_cart.php",
        type: "post",
        data: { methods3:datas,SENDER:myid,RECEIVER:receiver,MSG:msg},
        success: function (data) {
          $('#msg_send').val('');
          showgetAdminchat();
          reloadmsg(myid,receiver);
          $(document).scrollTop($(document).height());

        },
        error: function(xhr, status, error) {
          var err = eval("(" + xhr.responseText + ")");
          alert("error"+err.Message);
        }
      });

});
$(document).keypress(function(e) {
    if(e.which == 13) {
      var myid = $('#myid').val();
      var receiver = $('#sender').val();
      var msg = $('#msg_send').val();

      var datas = "sendMsg";
       $.ajax({
          url: "../ajax_product_cart.php",
          type: "post",
          data: { methods3:datas,SENDER:myid,RECEIVER:receiver,MSG:msg},
          success: function (data) {
            $('#msg_send').val('');
            showgetAdminchat();
            reloadmsg(myid,receiver);
            $("#msg_history").animate({ scrollTop: 1000 }, 2000);
  
          },
          error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert("error"+err.Message);
          }
        });
    }
});
</script>


    </body>
    </html>