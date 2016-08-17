<?php 

include_once 'database.php';

try{

	$readQuery = "SELECT * FROM tasks";

	$statement = $conn->query( $readQuery );

	while ( $task = $statement->fetch(PDO::FETCH_OBJ) ) {

		$create_date = strftime( "%b %d, %Y", strtotime( $task->created_at ) );
		
		$output = "<tr>";
        $output .= "<td title='Click to edit'><div class='editable' onclick='makeElementEditable(this)' onblur=\"updateTaskName(this, '{$task->id}')\"> $task->name </div></td>";
        $output .= "<td title='Click to edit'><div class='editable' onclick='makeElementEditable(this)' onblur=\"updateTaskDescription(this, '{$task->id}')\"> $task->description </div> </td>";
        $output .= "<td title='Click to edit'><div class='editable' onclick='makeElementEditable(this)' onblur=\"updateTaskStatus(this, '{$task->id}')\"> $task->status </div> </td>";
        $output .= "<td> $create_date </td>";
        $output .= "<td style='width: 5%;'><button class='btn-danger' onclick=\"deleteTask('{$task->id}')\"><i class='fa fa-times'></i></button>";
        $output .= "</td>";
        $output .= "</tr>";

        echo $output;
	}

}catch ( PDOException $ex ) {

	echo "An error occurred" .$ex->getMessage();

}

?>