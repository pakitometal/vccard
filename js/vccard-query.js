window.addEventListener('load', function(){
	var status_msg = false;
	document.getElementById('pos').focus();

	function clear_status() {
		if ( status_msg ) {
			status_msg.parentNode.removeChild(status_msg);
		}
	}

	function show_status(status) {
		status_msg = document.createElement('div');
		status_msg.id = 'status_msg';
		status_msg.className = 'error';
		var status_text = 'ERROR';
		if ( status ) {
			status_msg.className = 'ok';
			status_text = 'OK';
		}
		status_msg.innerHTML = '<p>'+status_text+'</p>';
		document.body.appendChild(status_msg);
	}

	document.getElementById('do_query').addEventListener('click', function(e){
		e.preventDefault();
		e.stopPropagation();
		clear_status();
		var current_elem = this;
		current_elem.style.display = 'none';
		current_elem.parentNode.classList.add('spinner');
		var xhr = new XMLHttpRequest();
		xhr.open(
			'POST',
			encodeURI('php/vccard-query.php')
		);
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		xhr.onload = function() {
			var response_status = false;
			if ( 200 === xhr.status ) {
				response = JSON.parse(xhr.responseText);
				response_status = response.status;
			}
			current_elem.style.display = 'block';
			current_elem.parentNode.classList.remove('spinner');
			show_status(response_status);
			document.getElementById('pos').value = document.getElementById('passwd').value = '';
			if ( !response_status ) {
				document.getElementById('pos').focus();
			}
		};
		var pos = 'undefined' != typeof document.getElementById('pos').value ? document.getElementById('pos').value : '';
		var passwd = 'undefined' != typeof document.getElementById('passwd').value ? document.getElementById('passwd').value : '';
		xhr.send(encodeURI('pos=' + pos + '&passwd=' + passwd));
	}, false);
}, false);
