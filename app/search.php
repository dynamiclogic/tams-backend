<?php
include 'database.php';
	$conn = Database::connect();
	             $temp_assets = array();

	$OK = true; // We use this to verify the status of the update.
	// If 'buscar' is in the array $_POST proceed to make the query.
	if (isset($_GET['search'])) {
		// Create the query
		$data = "%".$_GET['search']."%";
		$sql = 'SELECT assets.*,
						attributes_values.attribute_value,
						locations.longitude,
						locations.latitude,
						media.images,
						asset_types.type_value
				FROM assets 
						LEFT JOIN asset_types ON assets.type_id = asset_types.asset_type_id
						LEFT JOIN attributes_indexes ON assets.asset_id = attributes_indexes.asset_id
						LEFT JOIN attributes_values ON attributes_indexes.attribute_value_id = attributes_values.attribute_value_id
						LEFT JOIN media ON assets.asset_id = media.asset_id
						LEFT JOIN locations ON assets.asset_id = locations.asset_id
				WHERE (assets.name like ?)
						OR (assets.asset_id like ?)
						OR (assets.description like ?)
						OR (asset_types.type_value like ?)
						OR (attributes_values.attribute_value like ?)
						OR (assets.created_by like ?)
				ORDER BY asset_id DESC';
		// we have to tell the PDO that we are going to send values to the query
		$stmt = $conn->prepare($sql);
		$stmt->bindParam(1, $data);
		$stmt->bindParam(2, $data);
		$stmt->bindParam(3, $data);
		$stmt->bindParam(4, $data);
		$stmt->bindParam(5, $data);
		$stmt->bindParam(6, $data);

		// Now we execute the query passing an array toe execute();
		$results = $stmt->execute();
		// Extract the values from $result
		$rows = $stmt->fetchAll();
		$error = $stmt->errorInfo();
		//echo $error[2];
	}
	// If there are no records.
	if(empty($rows)) {
		echo "<tr>";
			echo "<td colspan='8'>There were not records</td>";
		echo "</tr>";
	}
	else {
		foreach ($rows as $row) {
			       //check for unique results
                  if (!in_array($row['asset_id'], $temp_assets)) {
                    $temp_assets[] = $row['asset_id'];

			echo '<a href="read.php?assetId='.$row['asset_id'].'" class="list-group-item"><h4 class="list-group-item-heading">';
                  echo $row['name'];
                  echo '</h4><p class="list-group-item-text">' . $row['description'] . '</p></a>';
			echo '<span id="desktop-assets"><tr>';
				echo '<td>';
				if ($row['images']) {
                    echo '<img class="asset-image-table asset-image-table-mobile" src="' . $row['images'] . '"/>';
                }
                echo '</td>';
				echo '<td>'. $row['asset_id'] . '</td>';
			   	echo '<td>'. $row['name'] . '</td>';
			   	echo '<td>'. $row['description'] . '</td>';
			   	echo '<td>'. $row['type_value'] . '</td>';
			   	echo '<td>'. $row['longitude'] . '<br>' . $row['latitude'] . '</td>';
			   	echo '<td>'. $row['created_by'] . '</td>';
				echo '<td width=250>';
				echo '<a class="btn btn-default" href="read.php?asset_id='.$row['asset_id'].'">Read</a>';
				echo '&nbsp;';
				echo '<a class="btn btn-success" href="update.php?asset_id='.$row['asset_id'].'">Update</a>';
				echo '&nbsp;';
				echo '<a class="btn btn-danger" href="delete.php?asset_id='.$row['asset_id'].'">Delete</a>';
				echo '</td>';
			echo "</tr></span>";
		}
		}
	}
?>
