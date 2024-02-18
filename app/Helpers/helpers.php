<?php
if (!function_exists('encryptString')) {
    function encryptString($value)
    {
        $key = 'jOI6W+9nCHLrPLdaTA82UH4CUBhz8aZ0mCRNz920J8Y='; // Previously generated safely, ie: openssl_random_pseudo_bytes 

        $plaintext = $value;

        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);

        // Encrypted string 
        $ciphertext = base64_encode($iv . $hmac . $ciphertext_raw);
        return $ciphertext;
    }
}

if (!function_exists('decryptString')) {
    function decryptString($value)
    {
        $key = 'jOI6W+9nCHLrPLdaTA82UH4CUBhz8aZ0mCRNz920J8Y='; // Previously used in encryption 
        $c = base64_decode($value);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);

        if (hash_equals($hmac, $calcmac)) { //PHP 5.6+ Timing attack safe string comparison 
            return $original_plaintext;
        } else {
            throw new Exception('Decription failed!', 500);
        }
    }
}
