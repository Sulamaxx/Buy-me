<?php
$publickey = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDBbsMoe6foRLZdlD8Jbs7fVii9
uNxC95y9RCpE8GZasic428aut+DhVd8rzHWjyJSUUTAvMRmkoi24UAKNdRu50xpS
cH7DK49vFD+8SSJVKt2qXk05w0d7ZDviOCDf7G0mvPTpewpBtwhApEcTrCCrYJ5/
ue/1UXqYNtFr1bOq/wIDAQAB
-----END PUBLIC KEY-----";
$secret_key="cc50bb35-184f-4681-be94-a1a581b6e059";
$api_Username = "buyme";
$api_Password = "brvboLQrwlQW";
return [
	'webxpay' => [
		'public_key'     => $publickey,
		'secret_key' => $secret_key,
		'api_username' => $api_Username,
		'api_password' => $api_Password,
		'sandbox'	=>	false,
	],
];