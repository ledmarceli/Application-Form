<?php
$name = $_POST[name];
$surname = $_POST[last-name];
$email = $_POST[email];
$telephone = $_POST[telephone];
$address1 = $_POST[address1];
$address2 = $_POST[address2];
$town = $_POST[town];
$county = $_POST[county];
$postcode = $_POST[postcode];
$country = $_POST[country];
$description = $_POST[description];
$file = $_POST[fileToSend];


// Recipient 
$to = $email; 

 
// Email subject 
$subject = 'Your application details';  
 
// Attachment file  
 
// Email body content 
$Content = "$name\r\n$surname\r\n$email\r\n$telephone\r\n$address1\r\n$address2\r\n$town\r\n$county\r\n$postcode\r\n$country\r\n$description";

 
// Boundary  
$semi_rand = md5(time());  
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
 
// Headers for attachment  
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 
// Multipart boundary  
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
"Content-Transfer-Encoding: 7bit\n\n" . $Content . "\n\n";  
 
// Preparing attachment 
if(!empty($file) > 0){ 
    if(is_file($file)){ 
        $message .= "--{$mime_boundary}\n"; 
        $fp =    @fopen($file,"rb"); 
        $data =  @fread($fp,filesize($file)); 
 
        @fclose($fp); 
        $data = chunk_split(base64_encode($data)); 
        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" .  
        "Content-Description: ".basename($file)."\n" . 
        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" .  
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
    } 
} 
$message .= "--{$mime_boundary}--"; 
 
// Send email 
$mail = @mail($to, $subject, $message, $headers);  

?>
