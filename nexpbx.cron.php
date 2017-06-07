<?php

/****connection settings for mysql db****/
// Connect to NexPBX Mysql
$servername_mysql = "localhost";
$username_mysql = "nexpbx";
$database_mysql = "ncm";
$password_mysql = "U5KYVD4T6BaXx6ve";


/****connection settings for pg db****/
// Connect to NexPBX pg
$servername_pg  = "jax1.ngvoip.us";
$database_pg    = "fusionpbx";
$username_pg = "ngcrm";
$password_pg = "pZxt6bAefKde";


//ini_set('display_errors', 'On');
//ini_set('display_startup_errors', 1);
//error_reporting(1);


/*
*creates an array containing differnece in both devices arrays
*/
function devices_difference($array1, $array2)
{

	$devices_mysql_uuid=array_column($array2, 'device_uuid');
	foreach($array1 as $key => $value)
	{
		if(in_array($value['device_uuid'], $devices_mysql_uuid )){

			foreach ($array2 as $key2 => $value2) {

				if($value['device_uuid']==$value2['device_uuid'] ){
					$diff=array_diff($value, $value2);

					if(!empty($diff)){
						$diff['device_uuid']=$value2['device_uuid'];
						$diff['new']=0;
						$difference[$value['device_uuid']] = $diff;
					}

				}
			}

		}else{
			$value['new']=1;
			$difference[$value['device_uuid']]=$value;

		}
	}
	return !isset($difference) ? 0 : $difference;
}


/*
*creates an array containing differnece in both domains arrays
*/
function domains_difference($array1, $array2)
{

	$domain_mysql_uuid=array_column($array2, 'domain_uuid');


	foreach($array1 as $key => $value)
	{
		if(in_array($value['domain_uuid'], $domain_mysql_uuid )){

			foreach ($array2 as $key2 => $value2) {

				if($value['domain_uuid']==$value2['domain_uuid'] ){
					$diff=array_diff($value, $value2);

					if(!empty($diff)){
						$diff['domain_uuid']=$value2['domain_uuid'];
						$diff['new']=0;
						$difference[$value['domain_uuid']] = $diff;
					}



				}
			}



		}else{
			$value['new']=1;
			$difference[$value['domain_uuid']]=$value;

		}


	}
	return !isset($difference) ? 0 : $difference;
}

// Connect to NexPBX Postgres
$conn_postgres = pg_connect("host=".$servername_pg." dbname=".$database_pg." user=".$username_pg." password=".$password_pg)
or die('Could not connect: ' . pg_last_error());



// Create connection
$conn = new mysqli($servername_mysql, $username_mysql, $password_mysql,$database_mysql);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Fetch mysql Domains
$sql = "SELECT domain_uuid,domain_parent_uuid, domain_name,domain_enabled,domain_description FROM nexpbx_domains";
$result = $conn->query($sql);
$domains_mysql=mysqli_fetch_all($result,MYSQLI_ASSOC);


//single arrays of domain_uuid from mysql
$domain_uuid_mysql=array_column($domains_mysql, 'domain_uuid');


// Fetch Pg Domains
$domain_query = pg_query($conn_postgres, "SELECT v_domains.domain_uuid, v_domains.domain_parent_uuid, v_domains.domain_name, v_domains.domain_enabled,
	v_domains.domain_description FROM v_domains");
if (!$domain_query) {
	echo "An error occurred.\n";
	exit;
}

$domains_pg = pg_fetch_all($domain_query);


$sql = array();

/****Synscronize domains starts*****/
$difference=domains_difference($domains_pg, $domains_mysql);

$insert_query=0;
$update_query=0;
if(!empty($difference)){
	foreach ($difference as  $row_diff) {

		if($row_diff['new']==1){

			$sql[] = '("'.$row_diff['domain_uuid'].'", "'.$row_diff['domain_parent_uuid'].'","'.$row_diff['domain_name'].'", "'.$row_diff['domain_enabled'].'", "'.$row_diff['domain_description'].'","'.date("Y-m-d H:i:s").'","'.date("Y-m-d H:i:s").'")';
			$insert_query=1;

		}elseif($row_diff['new']==0){



			$update_sql='';
			$update=0;
			if(isset($row_diff['domain_parent_uuid'])){
				$update_sql	.= 'domain_parent_uuid="'.$row_diff['domain_parent_uuid'].'" ,';

				$update=1;
			}

			if(isset($row_diff['domain_name'])){
				$update_sql	.= 'domain_name="'.$row_diff['domain_name'].'" ,';
				$update=1;
			}

			if(isset($row_diff['domain_enabled'])){
				$update_sql	.= 'domain_enabled="'.$row_diff['domain_enabled'].'" ,';
				$update=1;
			}

			if(isset($row_diff['domain_description'])){
				$update_sql	.= 'domain_description="'.$row_diff['domain_description'].'" ,';
				$update=1;
			}



			$update_sql='Update nexpbx_domains SET '.$update_sql.' updated_at="'.date("Y-m-d H:i:s").'" WHERE domain_uuid="'.$row_diff['domain_uuid'].'"';

			mysqli_query($conn,$update_sql);
			$update_query=1;

		}

	}


	if($insert_query==1){
		$insert_sql = "INSERT INTO nexpbx_domains (domain_uuid,domain_parent_uuid,domain_name,domain_enabled,domain_description,created_at,updated_at) VALUES ".implode(',', $sql);
		if(mysqli_query($conn,$insert_sql)){
			echo "Domain records inserted  \n";
		}else{
			echo  "Domain not inserted \n";
		}
	}
	if($update_query==1){
		echo "Domain records updated successfully \n";
	}
}else{
	echo "Domains Already Upto Date \n";
}
/****Synscronize domains ends*****/



/****Synscronize devices starts*****/

// Devices
$device_query = pg_query($conn_postgres, "SELECT v_devices.device_uuid, v_devices.domain_uuid, v_devices.device_mac_address, v_devices.device_label,
	v_devices.device_vendor, v_devices.device_model, v_devices.device_enabled, v_devices.device_template, v_devices.device_description,
	v_devices.device_provisioned_date, v_devices.device_provisioned_ip FROM v_devices");
if (!$device_query) {
	echo "An error occurred.\n";
	exit;
}

$devices_pg = pg_fetch_all($device_query);
pg_free_result($device_query);



// Select all devices from mysql db table
$sql = "SELECT device_uuid,domain_uuid, device_mac_address,device_label,device_vendor,device_model,device_enabled,device_template,device_description,device_provisioned_date,device_provisioned_ip,device_type FROM nexpbx_devices";
$result = $conn->query($sql);
$devices_mysql=mysqli_fetch_all($result,MYSQLI_ASSOC);



$difference=devices_difference($devices_pg, $devices_mysql);

$deleted=devices_difference($devices_mysql, $devices_pg);




$sql_deveices=array();
$insert_query_device=0;
$update_query_device=0;


if(!empty($deleted)){
	foreach ($deleted as $key => $value) {
		if($value['new']=1){
			$delete_sql='DELETE FROM nexpbx_devices WHERE device_uuid="'.$value['device_uuid'].'"';

			if(mysqli_query($conn,$delete_sql)){
				echo "Devices deleted successfully \n";
			}else{
				echo  "Devices not deleted (Error) \n";
			}
		}
	}
}



if(!empty($difference)){
	foreach ($difference as  $row_diff) {

		if($row_diff['new']==1){

			$sql_deveices[] = '("'.$row_diff['device_uuid'].'", "'.$row_diff['domain_uuid'].'","'.$row_diff['device_mac_address'].'", "'.$row_diff['device_label'].'", "'.$row_diff['device_vendor'].'", "'.$row_diff['device_model'].'", "'.$row_diff['device_enabled'].'", "'.$row_diff['device_template'].'", "'.$row_diff['device_description'].'", "'.$row_diff['device_provisioned_date'].'", "'.$row_diff['device_provisioned_ip'].'","'.date("Y-m-d H:i:s").'","'.date("Y-m-d H:i:s").'")';
			$insert_query_device=1;

		}elseif($row_diff['new']==0){

			$update_sql='';
			$update=0;
			if(isset($row_diff['domain_uuid'])){
				$update_sql	.= 'domain_uuid="'.$row_diff['domain_uuid'].'" ,';
				$update_sql	.= 'Location_id= 0 ,';
				$update=1;
			}

			if(isset($row_diff['device_mac_address'])){
				$update_sql	.= 'device_mac_address="'.$row_diff['device_mac_address'].'" ,';
				$update=1;
			}

			if(isset($row_diff['device_label'])){
				$update_sql	.= 'device_label="'.$row_diff['device_label'].'" ,';
				$update=1;
			}

			if(isset($row_diff['device_vendor'])){
				$update_sql	.= 'device_vendor="'.$row_diff['device_vendor'].'" ,';
				$update=1;
			}

			if(isset($row_diff['device_model'])){
				$update_sql	.= 'device_model="'.$row_diff['device_model'].'" ,';
				$update=1;
			}

			if(isset($row_diff['device_template'])){
				$update_sql	.= 'device_template="'.$row_diff['device_template'].'" ,';
				$update=1;
			}

			if(isset($row_diff['device_description'])){
				$update_sql	.= 'device_description="'.$row_diff['device_description'].'" ,';
				$update=1;
			}

			if(isset($row_diff['device_provisioned_date'])){
				$update_sql	.= 'device_provisioned_date="'.$row_diff['device_provisioned_date'].'" ,';
				$update=1;
			}

			if(isset($row_diff['device_provisioned_ip'])){
				$update_sql	.= 'device_provisioned_ip="'.$row_diff['device_provisioned_ip'].'" ,';
				$update=1;
			}

			if(isset($row_diff['device_enabled'])){
				$update_sql	.= 'device_enabled="'.$row_diff['device_enabled'].'" ,';
				$update=1;
			}



			if($update==1){

				$update_sql='Update nexpbx_devices SET '.$update_sql.' updated_at="'.date("Y-m-d H:i:s").'" WHERE device_uuid="'.$row_diff['device_uuid'].'"';

				mysqli_query($conn,$update_sql);
				$update_query_device=1;
			}

		}



	}



	if($insert_query_device==1){
		$insert_sql = "INSERT INTO nexpbx_devices (device_uuid,domain_uuid, device_mac_address,device_label,device_vendor,device_model,device_enabled,device_template,device_description,device_provisioned_date,device_provisioned_ip,created_at,updated_at) VALUES ".implode(',', $sql_deveices);

		if(mysqli_query($conn,$insert_sql)){

			echo "Devices records inserted \n";
		}else{

			echo "Devices not inserted (Error) \n" . mysqli_error($conn);
		}
	}
	if($update_query_device==1){
		echo "Devices records updated successfully \n";
	}
}else{

	echo "Devices already upto date \n";
}






/****Synscronize devices ends*****/


// Closing connection
pg_close($conn_postgres);

?>
