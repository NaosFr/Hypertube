<?php
function createMessages($comments, $lang) {
	$commentsHTML = '';

	if ($comments[0]['last_name'] == 'Comments' || $comments[0]['last_name'] == 'Commentaires')
	{
		return '
			<div class="message">
				<div class="message-head">
					<div class="message-head--content">
						<p class="author">
							'. $lang['comment_title'] .'
						</p>
						<a href="#">
							<p class="login">
							</p>
						</a>
						<p class="date">
						</p>
					</div>
				</div>
				<p class="content">
					'. $lang['comment_subtitle'] .'
				</p>
			</div>

		';
	}

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

function movieComments($comments, $lang) {
	$commentsHTML = createMessages($comments, $lang);

	echo '

		<div class="wrapper">
			<div class="messages">
				<div class="new-message">
					
					<div class="message-form">
						<textarea id="new-message" class="message-input" placeholder="'. $lang['comment_placeholder'] .'"></textarea>
								<div class="send-button">
									<input id="comment-button" type="submit" value="'. $lang['comment_button'] .'"/>
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
