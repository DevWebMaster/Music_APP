<?php
include("../src/RtmTokenBuilder.php");

$appID = "a810e31e7a5e48069ef4b1e75ad1582f";
$appCertificate = "5e7801b3240441758e9483fa6032200e";
$user = "test_user_id";
$role = RtmTokenBuilder::RoleRtmUser;
$expireTimeInSeconds = 3600;
$currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
$privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

$token = RtmTokenBuilder::buildToken($appID, $appCertificate, $user, $role, $privilegeExpiredTs);
echo 'Rtm Token: ' . $token . PHP_EOL;

?>
