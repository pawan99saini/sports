<link rel="stylesheet" href="<?= base_url(); ?>assets/frontend/css/messeging.css?ver=0.2.7">
<div class="chat-wrapper">
	<div class="container">
		<div class="chat-sidebar">
			<div class="chat-s-header">
				<span class="back-contact-btn">
					<a href="javascript:void(0);" class="close-search-contact">
						<i class="ion-ios-arrow-thin-left"></i>
					</a>
				</span>
				<form action="<?= base_url(); ?>account/searchContact" class="searchMessageContact" onsubmit="return false;">
					<input type="text" placeholder="search" name="search_contacts" id="search_contacts" />
				</form>
			</div>

			<div class="contact-search-results search-results-wrapper">
				<div class="loader-wrapper load-search-results">
					<div class="loader-sub" id="login-load">
						<div class="lds-ellipsis">
							<div></div>
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>
				</div>

				<div class="search-results"></div>
			</div>

			<ul class="chatContacts">
				<?php if(count($contactList) > 0) { ?>
				<?php foreach($contactList as $contact): ?>
				<?php 
					if($contact->userID == $user_id) {
						$contactID = $contact->friendID;
					} else {
						$contactID = $contact->userID;
					} 
				?>	
				<li class="user-contact <?= ($contactID == $contact_id_current) ? 'chat-active' : ''; ?>" data-contact-id="<?= $contactID; ?>" data-chat-count="<?= $meta->chatNotificationsCount($contact->chatID); ?>">
					<?php 
						$notificationCount = $meta->chatNotificationsCount($contact->chatID);
	            		$chat_user_image   = $meta->get_user_meta('user_image', $contactID);
	            		$get_userdata      = $meta->get_userdata($contactID);
						$username 		   = $get_userdata->username;
	            		
	            		if($chat_user_image == null) {
	            			$image_url = base_url() . 'assets/uploads/users/default.jpg';
	            		} else {
	            			$image_url = base_url() . 'assets/uploads/users/user-' . $contactID . '/' . $chat_user_image;
	            		}
	            	?>
	            	<a href="<?= base_url() . 'account/messages/' . $username; ?>">
		            	<div class="sidebar-thumb">
							<img src="<?= $image_url; ?>" alt="">
						</div>
						<div>
							<h2><?= $username; ?></h2>
							<?php 
								$userStatus 	 = $get_userdata->log_status;
								$userStatusClass = strtolower($userStatus);
								
								$contactsData = '';
								if($notificationCount > 0) {
									$contactsData .= '<div class="notify-contact-bubble">';
									$contactsData .= '<span class="bubbleCount">' . $notificationCount . '</span>';
									$contactsData .= '</div>';
								}

								echo $contactsData;
							?>
							<h3>
								<span class="status <?= $userStatusClass; ?>"></span>
								<?= $userStatus; ?>
							</h3>
						</div>
					</a>
				</li>
				<?php endforeach; ?>
				<?php } else { ?>
				<li>
					<h4>No Contacts</h4>
				</li>	
				<?php } ?>
			</ul>
		</div>

		<div class="chat-main-wrap">
			<?php if($chat_status == true) { ?>
			<?php if(count($contactList) > 0) { ?>
			<div class="cmw-header">
				<?php 
					$get_image  = $meta->get_user_meta('user_image', $contact_id_current);
            		$contact_username = $meta->get_username($contact_id_current);
            		$get_userdata     = $meta->get_userdata($contact_id_current);
            		
            		if($get_image == null) {
            			$image_url = base_url() . 'assets/uploads/users/default.jpg';
            		} else {
            			$image_url = base_url() . 'assets/uploads/users/user-' . $contact_id_current . '/' . $chat_user_image;
            		}
            	?>
            	<div class="user-img">
                	<img src="<?= $image_url; ?>" />
				</div>
				<div>
					<h2>Chat with @<?= $contact_username; ?></h2>
					<h3><?= count($messageData); ?> messages</h3>
				</div>
				<img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/1940306/ico_star.png" alt="">
			</div>
			<?php } ?>

			<ul id="chat">
				<?php $chatCount = 0; ?> 
				<?php if(count($messageData) > 0) { ?>
				<?php foreach($messageData as $message): ?>	
				<?php 
					if($contact->userID == $user_id) {
						$contactID = $contact->friendID;
					} else {
						$contactID = $contact->userID;
					} 
				?>	
					
				<li class="<?= ($message->receiver_id == $user_id) ? 'you' : 'me'; ?>">
					<div class="entete">
					<?php
						$sender_userdata   = $meta->get_userdata($user_id);
						$receiver_userdata = $meta->get_userdata($contact_id_current);
					?>	
						<?php if($message->receiver_id != $user_id) { ?>
						<h3><?= date('H:i A', strtotime($message->date_time)); ?></h3>
						<h2>@<?= $sender_userdata->username; ?></h2>
						<span class="status blue"></span>							
						<?php } else { ?>
						<span class="status green"></span>
						<h2>@<?= $receiver_userdata->username; ?></h2>
						<h3><?= $meta->time_ago($message->date_time); ?></h3>
						<?php } ?>
					</div>

					<?php if($message->message != null) { ?>
					<?php 
						if($message->type == 3) {
							$gifUrl   = $message->message; 
							$messageContent  = '<div class="message"><div class="msg-gif">';
							$messageContent .= '<img src="'.$gifUrl.'" />';
							$messageContent .= '</div></div>';
						} elseif($message->type == 4) {							
							$gifUrl   = $message->message; 
							$messageContent  = '<div class="msg-sticker">';
							$messageContent .= '<img src="'.$gifUrl.'" />';
							$messageContent .= '</div>';
						
						} else {
							$convertedMessage = urldecode($message->message);
							$convertedMessage = $emojione->getEmojisFromString($convertedMessage);

							$messageContent  = '<div class="message">';
							$messageContent .= $convertedMessage;
							$messageContent .= '</div>';
							
						}
					?>
						<?= $messageContent; ?>
					<?php } ?>
					<?php 
						if($message->file_data != null) {
							echo '<div class="fileData zoom-gallery">';

							$fileData 	= unserialize($message->file_data);
							$folderPath = base_url() . 'assets/frontend/uploads/messages/chat-' . $message->chatID . '/';
							
							foreach($fileData as $file):
								echo '<div class="chat-image">';
								echo '<a href="'.$folderPath.$file.'" data-effect="mfp-move-horizontal">';
								echo '<img src="'.$folderPath.$file.'" />';
								echo '</a></div>';
							endforeach;

							echo '</div>';
						}
					?>
				</li>
				<?php $chatCount++; ?>
				<?php endforeach; ?>	
				<?php } ?>			
			</ul>
			<div class="chat-text-wrap bottom-chat-wrapper">
                <form method="POST" action="<?= base_url(); ?>account/sendMessage" enctype="multipart/form-data" class="send-message" onsubmit="return false;">
                	<div class="gse-row animate__animated animate__fadeInUp"></div>
					<div class="image-uploader">
						<div id="basic_message"></div>

						<div class="file-upload-init">
							<div class="fileUploader">
								<input type="file" name="file" multiple="true" id="basic" />
								<div id="basic_drop_zone" class="dropZone">
									<h4>
										<i class="fa fa-upload"></i>
										<span>Drop files here</span>
									</h4>
								</div>
								<div id="basic_progress"></div>                            
							</div>
						</div>  
						<a href="javascript:void(0);" class="close-message-images"><i class="ion-close"></i></a>
					</div>
					<input type="hidden" name="receiver_id" value="<?= $contact_id_current; ?>" />
                    <input type="hidden" name="thread" value="<?= $threadID; ?>" />
					<input type="hidden" name="chatCount" value="<?= $chatCount; ?>" />
                    
                    <div class="act-row act-row-center">
                        <div class="act-section">
                            <div class="act-icon">
                                <div class="message-gif act-btn">
                                    <img class="btn-tooltip" data-toggle="tooltip" data-placement="top" title="Send Gifs" src="<?= base_url(); ?>assets/frontend/images/gif_icon.png"  />
                                </div>
                            </div>
                            
                            <div class="act-icon">
                                <div class="message-sticker act-btn">
                                    <img class="btn-tooltip" data-toggle="tooltip" data-placement="top" title="Send Stickers" src="<?= base_url(); ?>assets/frontend/images/sticker_icon.png"  />
                                </div>
                            </div>
                            
							<div class="act-icon">
								<div class="message-images act-btn" data-toggle="tooltip" data-placement="top" title="Send Images" >
									<img src="<?= base_url(); ?>assets/frontend/images/image_icon.png"  />
								</div>
							</div>
                        </div>
                        
                        <div class="chat-box">
                            <textarea class="form-control" name="message_content" rows="1"  id="message_content" placeholder="Type a message..."></textarea>
                            <button type="submit" class="btn btn-send">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </form>
			</div>
			<?php } else { ?>
			<div class="err-404">
				<i class="fa fa-commenting"></i>
				<h4>Start Messaging</h4>
			</ldiv>	
			<?php } ?>
		</div>
	</div>
</div>

<div class="gif-content" style="display:none;">
    <div class="input-group input-group-sm gif-search-area">
        <input type="text" class="form-control gif-search-input" placeholder="Search GIFs via Tenor" style="z-index:0">
        <div class="input-group-append">
            <button class="btn btn-success gif-search-btn" type="button"><i class="fas fa-search"></i></button>
        </div>
        <div class="input-group-append">
            <button class="btn btn-danger gif-close" type="button"><i class="fas fa-times"></i></button>
        </div>

    </div>
	<div class="gifs">
		<span class="loading" style="display: none;"></span>
		<div class="gif-list row m-0"></div>
	</div>
</div>

<div class="sticker-content" style="display:none;">
	<div class="strickers">
		<span class="loading" style="display: none;"></span>
        <div class="d-flex">
            <ul class="nav nav-pills sticker-nav" id="pills-tab" role="tablist"></ul>
            <button class="btn btn-danger sticker-close ml-auto" type="button"><i class="fas fa-times"></i></button>
        </div>
        <div class="tab-content sticker-tab-content" id="pills-tabContent">
        </div>
	</div>
</div>

<script>
	var chatID = '<?= $threadID; ?>';
</script>