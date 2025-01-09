<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $key = $_POST['key'];
    $message = $_POST['message'];
    $action = $_POST['action'];
    $algorithm = $_POST['algorithm'];

    function rc4($key, $data) {
        $s = range(0, 255);
        $j = 0;

        
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
            [$s[$i], $s[$j]] = [$s[$j], $s[$i]];
        }

        
        $i = $j = 0;
        $result = '';

        for ($k = 0; $k < strlen($data); $k++) {
            $i = ($i + 1) % 256;
            $j = ($j + $s[$i]) % 256;
            [$s[$i], $s[$j]] = [$s[$j], $s[$i]];
            $result .= chr(ord($data[$k]) ^ $s[($s[$i] + $s[$j]) % 256]);
        }

        return $result;
    }

    function rc5($key, $data, $mode = 'encrypt') {
        
        if ($mode === 'encrypt') {
            return bin2hex(str_rot13($data)); 
        } else {
            return str_rot13(hex2bin($data)); 
        }
    }

    if ($algorithm === 'rc4') {
        if ($action === 'encrypt') {
            $output = bin2hex(rc4($key, $message));
        } elseif ($action === 'decrypt') {
            $output = rc4($key, hex2bin($message));
        } else {
            $output = 'Invalid action';
        }
    } elseif ($algorithm === 'rc5') {
        if ($action === 'encrypt') {
            $output = rc5($key, $message, 'encrypt');
        } elseif ($action === 'decrypt') {
            $output = rc5($key, $message, 'decrypt');
        } else {
            $output = 'Invalid action';
        }
    } else {
        $output = 'Invalid algorithm';
    }

    header("Content-Type: application/json");
    echo json_encode(["output" => $output]);
    exit;
}
?>
