<?php 

include_once 'database.php';

try{

	$readQuery = "SELECT * FROM tasks";

	$statement = $conn->query( $readQuery );

	while ( $task = $statement->fetch(PDO::FETCH_OBJ) ) {

		$create_date = strftime( "%b %d, %Y", strtotime( $task->created_at ) );
		
		$output = "<tr>";
        $output .= "<td><div> $task->name </div></td>";
        $output .= "<td> <div> $task->description </div> </td>";
        $output .= "<td> <div> $task->status </div> </td>";
        $output .= "<td> $create_date </td>";
        $output .= "<td style='width: 5%;'><button><i class='btn-danger fa fa-times'></i></button>";
        $output .= "</td>";
        $output .= "</tr>";

        echo $output;
	}

}catch ( PDOException $ex ) {

	echo "An error occurred" .$ex->getMessage();

}

?>