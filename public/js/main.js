$().ready(function() {
	$( "#signupForm" ).validate( {
		rules: {
			first_name: {
				required: true,
				minlength: 2
			},
			password: {
				required: true,
				minlength: 5
			},
			email: {
				required: true,
				email: true
			},
		},
		messages: {
			first_name: {
				required: "Please enter a first name",
				minlength: "Your first name must consist of at least 2 characters"
			},
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			email: "Please enter a valid email address",
		}
	});

	$( "#signinForm" ).validate( {
		rules: {
			password: {
				required: true,
				minlength: 5
			},
			email: {
				required: true,
				email: true
			},
		},
		messages: {
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 5 characters long"
			},
			email: "Please enter a valid email address",
		}
	});

	// dashboard edit content
	var postid = 0;
	var postBodyElement = null;
	$('.post').find('.interaction').find('.edit').on('click', function(event) {
		event.preventDefault();
		postBodyElement = event.target.parentNode.parentNode.childNodes[1];
		var postBody = postBodyElement.textContent;
		postid = event.target.parentNode.parentNode.dataset['postid'];
		$('#edit-body').val(postBody);
		$('#edit-modal').modal();
	});

	$('#modal-save').on('click', function() {
		$.ajax({
			method: 'POST',
			url: urlEdit,
			data: {
				body: $('#edit-body').val(),
				id: postid,
				_token: token
			}
		}).done(function (msg) {
			$(postBodyElement).text(msg['new_body']);
			$('#edit-modal').modal('hide');
		});
	});

	$('.post').find('.interaction').find('#like-btn').on('click', function(event) {
		event.preventDefault();
		postid = event.target.parentNode.parentNode.dataset['postid'];
		$.ajax({
			method: 'POST',
			url: urlLike,
			data: {
				id: postid,
				_token: token
			}
		}).done(function(msg) {
			console.log(msg['msg']);
			var btn_pos = event.target;
			console.log(event.target);
			if ($(btn_pos).hasClass( "unlike" )) {
				$(btn_pos).removeClass('unlike').addClass('like');
			} else {
				$(btn_pos).removeClass('like').addClass('unlike');
			}
		});
	});
});