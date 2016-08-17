// send form data to create.php for creating task by using ajax
$(document).ready(function () {

	$('#create-task').submit(function (event) {

		event.preventDefault();

		var form = $(this);

		var formData = form.serialize();

		$.ajax({
			url: 'create.php',
			method: 'POST',
			data: formData,
			success: function (data) {

				$('#ajax_msg').css("display", "block").delay(3000).slideUp(300).html(data);
				document.getElementById("create-task").reset();

			}

		});

	});

	$('#task-list').load('read.php');

});

// make element editable
function makeElementEditable(div) {

	div.style.border = "1px solid lavender";
	div.style.padding = "5px";
	div.style.background = "white";
	div.contentEditable = true;

}

// send form data to update.php for updating the task name by using ajax
function updateTaskName(target, taskId) {

	var data = target.textContent;

	target.style.border = "none";
	target.style.padding = "0px";
	target.style.background = "#ececec";
	target.contentEditable = false;

	$.ajax({
		
		url: 'update.php',
		method: 'POST',
		data: {name: data, id:taskId},
		success: function (data) {
			$('#ajax_msg').css("display", "block").delay(3000).slideUp(300).html(data);
		}

	});

}

// send form data to update.php for updating the task description by using ajax
function updateTaskDescription(target, taskId) {

	var data = target.textContent;

	target.style.border = "none";
	target.style.padding = "0px";
	target.style.background = "#ececec";
	target.contentEditable = false;

	$.ajax({

		url: 'update.php',
		method: 'POST',
		data: {description: data, id:taskId},
		success: function (data) {
			$('#ajax_msg').css("display", "block").delay(3000).slideUp(300).html(data);
		}

	});

}

// send form data to update.php for updating the task status by using ajax
function updateTaskStatus(target, taskId) {

	var data = target.textContent;

	target.style.border = "none";
	target.style.padding = "0px";
	target.style.background = "#ececec";
	target.contentEditable = false;

	$.ajax({

		url: 'update.php',
		method: 'POST',
		data: {status: data, id:taskId},
		success: function (data) {
			$('#ajax_msg').css("display", "block").delay(3000).slideUp(300).html(data);
		}

	});

}

// delete a task
function deleteTask(taskId) {

	if ( confirm("Do you really want to delete this task?") ) {

		$.ajax({

			url: 'delete.php',
			method: 'POST',
			data: {id:taskId},
			success: function (data) {
				$('#ajax_msg').css("display", "block").delay(3000).slideUp(300).html(data);
			}

		});

		$('#task-list').load('read.php');

	}

	return false;

}