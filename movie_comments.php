<?php
function createMessages($comments) {
	$commentsHTML = '';

	foreach ($comments as $comment) {
		$commentsHTML = '
			<div class="message">
				<div class="message-head">
					<div class="message-head--content">
						<p class="author">
							'.$comment['first_name'].' '.$comment['last_name'].'
						</p>
						<a href="./user.php?login='.$comment['login'].'">
							<p class="login">
								@'.$comment['login'].' -
							</p>
						</a>
						<p class="date">
							'.$comment['date'].'
						</p>
					</div>
				</div>
				<p class="content">
					'.$comment['content'].'
				</p>
			</div>
		'.$commentsHTML;
	}
	return $commentsHTML;
}

function movieComments($comments) {
	$commentsHTML = createMessages($comments);

	echo '

		<div class="wrapper">
			<div class="messages">
				<div class="new-message">
					
					<div class="message-form">
						<textarea id="new-message" class="message-input" placeholder="What`s on your mind ?"></textarea>
								<div class="send-button">
									<input id="comment-button" type="submit" value="COMMENT"/>
								</div>
					</div>
				</div>
				<div class="messages-list" id="message-list">'
					.$commentsHTML.
				'</div>
			</div>
		</div>
';
}
?>
