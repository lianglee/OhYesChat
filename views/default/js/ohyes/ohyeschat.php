<?php
/**
 * OhYesChat
 * @website Link: https://github.com/lianglee/OhYesChat
 * @Package Ohyes
 * @subpackage Chat
 * @author Liang Lee
 * @copyright All right reserved Liang Lee 2014.
 * @ide The Code is Generated by Liang Lee php IDE.
 */ 
?>
/**
 * OhYesChat
 * @website Link: https://github.com/lianglee/OhYesChat
 * @Package Ohyes
 * @subpackage Chat
 * @author Liang Lee
 * @copyright All right reserved Liang Lee 2014.
 * @ide The Code is Generated by Liang Lee php IDE.
 */ 
var OhYesChat = OhYesChat ||{}; 
/**
 * Get online friends list
 * @param NULL;
 *
 * @return {Object}
 */
OhYesChat.FriendsShow = function(){
    $(".friends-list").show();
    $('#OhYesChat').attr('onclick', 'OhYesChat.FriendsHide();');
    $('.friends-list').find('.data').html('<div class="ohyes-chat-loading" style="padding:79px;"><div class="OhYesChat-Icon-Loading"></div></div>');       
   	$.ajax({
        url: '<?php echo elgg_get_site_url();?>ohyeschat/friends',
        type: 'get',
        success: function(data) { 
		    $('.friends-list').find('.data').html(data['friends']);
        } 
     });
};
/**
 * Remove open tab
 * @param div = id of div;
 *
 * @return {Object}
 */
OhYesChat.TabUnlink = function(div){
                $.ajax({
                          url: '<?php echo elgg_get_site_url();?>ohyeschat/action/removetab/'+div,
                          type: 'get',
                          async: true,
                          success: function(fetch) { 
                                     if(fetch == 'removed'){
                                        $('#ohyeschat-window-'+div).remove();
                                      }
                             } 
                    });        
};
/**
 * Show a notification window
 * @param win = id of window;
 *
 * @return {Object}
 */
OhYesChat.NotifShow = function(win){
      $('.notification-window').show();
      $(win).attr('onclick', 'OhYesChat.NotifHide(this);');
      $('.ChatNotification').find('.data').html('<div class="ohyes-chat-loading"><div class="OhYesChat-Icon-Loading"></div></div>');       
             $.ajax({
                          url: '<?php echo elgg_get_site_url();?>ohyeschat/notif',
                          type: 'post',
                          async: true,
                          success: function(fetch) { 
                                   $('.ChatNotification').find('.data').html(fetch['messages']);
                                   if(fetch['count'] !== '' ){
                                       $('#chat-count-message').show().html(fetch['count']);
                                   } 
                                   
                             } 
                    }); 

}
/**
 * Hide notification window
 * @param win = id of window;
 *
 * @return NULL;
 */
OhYesChat.NotifHide = function(win, args){
      $('.notification-window').hide();
      if(args == 1){
       $('.ChatNotification').find('.inner').attr('onclick', 'OhYesChat.NotifShow(this);');
      }
      if(args !== 1){
        $(win).attr('onclick', 'OhYesChat.NotifShow(this);');
      }
}
/**
 * Open a tab
 * @param id = id of tab;
 * @param div = id of div;
 *
 * @return {Object}
 */
OhYesChat.TabOpen = function(id, div){
            $('.ChatTab')
                     .not("#OhYesChat-Tab-"+id)
                     .css('width', '190px')
                     .find('.Tab-Title')
                     .hide();
            
            var tab = "#ohyeschat-window-"+id;
            $(".ChatTab").not("#ohyeschat-window-"+id).find('.box').hide(); 
            $(".ChatTab").not("#OhYesChat-Tab-"+id).find('.ohyeschat-uinfo').show(); 
            
            $(tab).css('width', '255px');
            $("#OhYesChat-Tab-"+id).show();
            $("#ohyeschat-window-"+id).find(".OhYesChat-Icon-Onine").hide();
            $("#ohyeschat-window-"+id).find('.box').show(); 
            close = 'OhYesChat.TabUnlink('+id+');';
            $("#OhYesChat-Tab-"+id).find('.options').attr('onclick', close);
            
            close = 'OhYesChat.TabClose('+id+', this);';
            $("#OhYesChat-Tab-"+id).find('.OhYesChat-Titles').attr('onclick', close);
            
            $('.ohyeschat-new-message').hide();
            $('.ohyeschat-new-message').find('.text').html('');
            OhYesChat.scrollMove(id);
};
/**
 * Close a tab
 * @param id = id of tab;
 * @param div = id of div;
 *
 * @return {Object}
 */
OhYesChat.TabClose = function(id, div){
            var tab = "#ohyeschat-window-"+id;
            $(tab).css('width', '190px');
            $("#OhYesChat-Tab-"+id).hide();
            $("#ohyeschat-ustatus-"+id).show();
            $("#ohyeschat-window-"+id).find('.box').hide(); 
            
            open = 'OhYesChat.TabOpen('+id+',this);';
            $(div).attr('onclick', open);
};
/**
 * Hide friends list window
 *
 * @return NULL
 */
OhYesChat.FriendsHide = function(){
             $(".friends-list").hide();
             $('#OhYesChat').attr('onclick', 'OhYesChat.FriendsShow();');
};
/**
 * Open a new chat tab
 * @param div = id of div;
 *
 * @return {Object}
 */
OhYesChat.newTab = function(fid){
        if($(".OhYesChat").children(".ChatTab").size() >= 3){
               alert('Please close one tab to add new');
               return false;
        }
        if(fid){
                  	$.ajax({
                     url: '<?php echo elgg_get_site_url();?>ohyeschat/newtab/'+fid,
                     type: 'post',
                     async: true,
                     success: function(data) { 
                             if($("#ohyeschat-window-" +fid).length == 0) { 
		                           if($(".OhYesChat").children(".ChatTab").size() < 4){
                                       $('.OhYesChat').append(data['tab']);
                                    } 
                                  if(data['messages']){
                                       $('#ohyes-chat-data-messages-'+fid).append(data['messages']); 
                                   }
                                   $("#ohyeschat-window-" +fid).find('.inner').click();
                               } 
                               else {
                                    $("#ohyeschat-window-" +fid).find('.inner').click();
                               }
                                     var chattab = document.getElementById('ohyes-chat-data-messages-'+fid);
                                     chattab.scrollTop = chattab.scrollHeight;
                             } 
                    });        
        } 
};
/**
 * Send a message
 * @param form = id of form;
 *
 * @return {Object}
 */
OhYesChat.Form = function(form){
$(function(){
           $('#ohyeschat-form-'+form).submit(function(e){
	          e.preventDefault(); 
                      $('#ohyeschat-window-'+form).find("#mbox").hide();
                      $('#ohyeschat-window-'+form).find(".ohyeschat-message-sending").show();
                      data = $(this).serialize();
                       $.ajax({
                          url: '<?php echo elgg_get_site_url();?>ohyeschat/action/send',
                          type: 'post',
                          async: true,
                          data: data,
                          success: function(fetch) { 
                                   $('#ohyeschat-window-'+form).find("#mbox").show();
                                   $('#ohyeschat-window-'+form).find(".ohyeschat-message-sending").hide();
                                   $('#ohyeschat-window-'+form).find('.data').append(OhYesChat.replaceEmoticons(fetch['message']));
                                   $('#ohyeschat-form-'+form).find("#mbox").attr('value', '');
                                   var tab = form;
					               OhYesChat.scrollMove(tab);
                             } 
                    });        
           }); 
       }); 
};
/**
 * Boot OhYesChat
 *
 * @todo: lol i forgot todo for this;
 * @return {Object}
 */
OhYesChat.Boot = function(){
    $.ajax({
             url: '<?php echo elgg_get_site_url();?>ohyeschat/boot/ohyeschat.boot.js',
             dataType: "script",
             async: true,
             success: function(fetch) {
                        if($('#ohyes-chat-js')){
                             $('#ohyes-chat-js').empty();
                        }
                             fetch;
                    } 
                    });        
};
$(document).ready(function(){
         setInterval(function(){OhYesChat.Boot()}, 5000);     
         OhYesChat.scrollMove('expand'); 
}); 

/**
 * Play a sound on new message
 *
 * @todo: nil;
 * @return {mp3}
 */
OhYesChat.playSound = function(){ 
		document.getElementById('ohyes-chat-sound').play();
};

/**
 * Move scroll to end of tab
 *
 * @todo: nil;
 * @return null;
 */
OhYesChat.scrollMove = function(fid){ 
  var chattab = document.getElementById('ohyes-chat-data-messages-'+fid);
  if(chattab){
    chattab.scrollTop = chattab.scrollHeight;
    return chattab.scrollTop;
  }
};
/**
 * Register a url for icons
 *
 * @todo: nil;
 * @return  {Url}
 */
OhYesChat.emoticons = function(icon){
return "<img src='"+elgg.get_site_url()+"mod/OhYesChat/images/emoticons/ohyeschat-"+icon+".gif' />";
};
/**
 * Replace icons
 *
 * @params: message = message of user;
 * @return  {IMG}
 */
OhYesChat.replaceEmoticons = function(messages){
   var message = messages.replace(':(', OhYesChat.emoticons('sad'))
			 .replace(':)', OhYesChat.emoticons('smile'))
			 .replace('=D', OhYesChat.emoticons('happy'))
			 .replace(';)', OhYesChat.emoticons('wink'))
			 .replace(':p', OhYesChat.emoticons('tongue'))
			 .replace('8|', OhYesChat.emoticons('sunglasses'))
			 .replace('o.O', OhYesChat.emoticons('confused'))
			 .replace(':O', OhYesChat.emoticons('gasp'))
			 .replace(':*', OhYesChat.emoticons('kiss'))
			 .replace('a:', OhYesChat.emoticons('angel'))
			 .replace(':h:', OhYesChat.emoticons('heart'))
			 .replace('3:|', OhYesChat.emoticons('devil'))
			 .replace('u:', OhYesChat.emoticons('upset'))
			 .replace(':v', OhYesChat.emoticons('pacman'))
			 .replace('g:', OhYesChat.emoticons('grumpy'))
			 .replace('8)', OhYesChat.emoticons('glasses'))
			 .replace('c:', OhYesChat.emoticons('cry'));
					   
   return message;                        
};
/**
 * Close smilies container
 *
 * @params: uid = form id;
 */
OhYesChat.CloseSmilies = function(uid){
       $('#ohyes-smiles-u'+uid).slideUp();
       $('#ohyeschat-window-'+uid)
            .find('.OhYesChat-Icon-Smilies')
            .attr('onclick', 'OhYesChat.ShowSmilies('+uid+');');
};
/**
 * Show similies container
 *
 * @params: uid = form id;
 */
OhYesChat.ShowSmilies = function(uid){
    $('#ohyes-smiles-u'+uid).html('Loading...');
    $.ajax({
             url: '<?php echo elgg_get_site_url();?>ohyeschat/smilies?uid='+uid,
             type: 'get',
             async: true,
             success: function(load) {
                          $('#ohyes-smiles-u'+uid).html(load);
                      } 
                    }); 
           $('#ohyes-smiles-u'+uid).slideDown()
           $('#ohyeschat-window-'+uid).find('.OhYesChat-Icon-Smilies').attr('onclick' , 'OhYesChat.CloseSmilies('+uid+');');
           
};
/**
 * Insert Smilies
 *
 * @params: tab = form id;
 * @params: Code = smilie code;
 */
OhYesChat.InsertSmiles = function(code, tab){
         var ChatTab = $('#ohyeschat-form-'+tab).find('#mbox');
         return ChatTab.attr('value', ChatTab.val()+' '+code);
};
/**
 * Forward request
 *
 * @params: url = url;
 */
OhYesChat.Forward = function(url){
  window.location = '<?php echo elgg_get_site_url();?>'+url;
};
/**
 * Expand Window
 *
 * @params: $friend = friend username;
 */
OhYesChat.Expand = function($friend){
 return OhYesChat.Forward('chat/messages/'+$friend);
};
