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
/**
 * User data
 * @note: Don't change anything if you don't know what you are doing;
 *
 * @return {Object}
 */ 
<?php
            $owner = elgg_get_logged_in_user_entity();
			$online = OhYesChat::countOnline($owner);
			$total_notifications = OhYesChat::countNew();
			$new_all = OhYesChat::getNewAll(array('sender'));
			$active_chat =  $_SESSION['ohyes_chat'];
			foreach($active_chat as $friend){
				$message = OhYesChat::getNew($friend);
				$icon = elgg_view("icon/default", array(
													'entity' => get_user($friend), 
													'size' => 'small',
				 ));  
				if(OhYesChat::userStatus($friend) == 'online'){
                    $status = 'OhYesChat-Icon-Onine';	
                   } 
                  else {
                   $status = 'OhYesChat-Icon-Offline';
                 }
  				$construct_active[$friend] =  array(
													'status' => $status
													);

				foreach($message as $text){
				   if($message->view == 0){
				         $new_messages[] = array(
										'fid' => $friend,
										'message' => elgg_view('ohyes/chat/message-item', array('icon' => $icon, 'message' => $text->message)),
										'total' => count($message)
										);
				   }
				}
				if(!empty($message)){
				  $sound = "'<script>OhYesChat.playSound();</script>";	
				  $login = elgg_get_logged_in_user_entity()->guid;
                  update_data("UPDATE {$CONFIG->dbprefix}ohyes_chat SET view='1' WHERE(sender='{$friend}' AND reciever='{$login}')");
				} else { $sound = 0;}
			}
			echo elgg_view('js/ohyes/');
            echo 'var OhYesChatData = ';
			echo json_encode(array(
							 'total' => array(
											  'notifications' => $total_notifications,
											  'online' => $online,
											  ),
							 'active_friends' => $construct_active,
							 'tab_messages' => $new_messages,
							 'all_new' => $new_all,
							 'sound' => $sound,
							 ));
			echo ";";
?>
/**
 * Merge user data to chat
 * @param;
 *
 * @todo: task 21;
 * @return NULL;
 */
$('#ohyes-chat-count').html(OhYesChatData['total']['online']);
if(OhYesChatData['total']['notifications'] == 0){
     $('#chat-count-message').hide();
}
if(OhYesChatData['total']['notifications'] !== 0){
    $('#chat-count-message').show().html(OhYesChatData['total']['notifications']);
}
/**
 * Playsound
 *
 * @required: OhYesChatData['sound'];
 * @return  {msg.sound}
 */
if(OhYesChatData['sound'] !== 0){
  $('.ohyes-chat-play').html(OhYesChatData['sound']);
} else {
 $('.ohyes-chat-play').html('');
}
/**
 * Update satatus of friend
 *
 * @required: OhYesChatData['active_friends'];
 * @return  {attr.status}
 */
if(OhYesChatData['active_friends']){
$.each(OhYesChatData['active_friends'], function(key, data){
      $(document).ready(function(){		
               $('#ohyeschat-ustatus-'+key).attr('class', data['status']);
     }); 		 
});
}
/**
 * Update tab message
 *
 * @required: OhYesChatData['tab_messages'];
 * @return  {append.message}
 */
if(OhYesChatData['tab_messages']){
$.each(OhYesChatData['tab_messages'], function(key, data){
   $(document).ready(function(){						  
            if($('.OhYesChat').find('#ohyeschat-window-'+data['fid'])){
                 $('#ohyeschat-window-'+data['fid']).find('.data').append(OhYesChat.replaceEmoticons(data['message']));
                      if(data['total'] > 0){
                               $('#ohyeschat-window-'+data['fid'])
                                     .find('.ohyeschat-new-message')
                                     .css('display', 'inline-block');
                               $('#ohyeschat-window-'+data['fid'])
                                      .find('.ohyeschat-new-message')
                                      .find('.text')
                                      .html(data['total']);
                       }
                 
            }
     }); 		 
});
}
/**
 * Open a new tab if message recieve
 *
 * @required: OhYesChatData['all_new'];
 * @return  {new.tab}
 */
if(OhYesChatData['all_new']){
$.each(OhYesChatData['all_new'], function(key, data){
   $(document).ready(function(){
	  if($(".OhYesChat").children(".ChatTab").size() < 4){   						  
         OhYesChat.newTab(data['sender']);
         OhYesChat.playSound();
         OhYesChat.scrollMove(data['sender']);
        }
     });     
});
}
