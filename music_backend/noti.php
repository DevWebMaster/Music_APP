<?php

$servername = "localhost";
$username = "root";
$password = "rubbystar";
$dbname = 'music_db';

// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = 'cias';

// Create connection
$conn = new mysqli($servername, $username, $password);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$name = $_POST['name'];
$msg = $_POST['msg'];
$sample_id = $_POST['sample_id'];

$sql = "SELECT * FROM devicetoken";
$result = mysqli_query($conn, $sql);
                $passphrase = 'song'; 
                $message = $msg;
                $ctx = stream_context_create();
                // Change 3 : APNS Cert File name and location.
                stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem'); 
                stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
                // Open a connection to the APNS server
                $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT, $ctx);
                if (!$fp)
                    exit("Failed to connect: $err $errstr" . PHP_EOL);
               
                // Create the payload body
                $body['aps'] = array(
                    'alert' => $message,
                    'sound' => 'default',
                    'id'    => $sample_id
                    );
                // Encode the payload as JSON
                $payload = json_encode($body);
                // Build the binary notification
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        // Change 1 : No braces and no spaces
                $deviceToken= $row['token']; 
                // Change 2 : If any
                
                $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
                // Send it to the server
                fwrite($fp, $msg, strlen($msg));
                
                
    }
} 
else
{
}
fclose($fp);
$conn->close();

                
?>