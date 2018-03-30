const sendNewMessage = (content, date, movie) => {
	const xhttp = new XMLHttpRequest();
	xhttp.open("POST", "php/addComment.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(`content=${content}&date=${date}&movie=${movie}`);	
};

const clearMessageBox = () => {
	document.getElementById("new-message").value = '';
}

const getDate = () => {
	const monthNames = [
		"January", "February", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "December"
	];
	const now = new Date();
	const date = `${monthNames[now.getMonth()]} ${now.getDate()}`;
	return date
}

const addNewMessage = (content) => {
	if (content.length >= 3000) {
		alert('Comment must be less than 3000 characters');
	}

	const messageList = document.getElementById("message-list");
	const userLogin = document.getElementById("user-login").innerHTML;
	const userFirstName = document.getElementById("user-first-name").innerHTML;
	const userLastName = document.getElementById("user-last-name").innerHTML;
	const date = getDate();
	
	const messageHTML = `
		<div class="message">
		    <div class="message-head">
		        <div class="message-head--content">
		            <p class="author">
		                ${userFirstName} ${userLastName}
		            </p>
					<a href="./user.php?login=${userLogin}">
						<p class="login">
        					@${userLogin} -
						</p>
					</a>
		            <p class="date">
		                ${date}
		            </p>
		        </div>
		    </div>
		    <p class="content">
				${content}
		    </p>
		</div>
	`;

	const tmp = messageList.innerHTML;
	messageList.innerHTML = messageHTML;
	messageList.innerHTML += tmp;

	clearMessageBox();

	const movie = document.getElementById("movie-id").innerHTML;
	sendNewMessage(content, date, movie);
};

const button = document.getElementById("comment-button");
button.addEventListener("click", () => {
	addNewMessage(document.getElementById("new-message").value)
});
