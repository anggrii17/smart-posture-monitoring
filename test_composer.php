<?php

require 'vendor/autoload.php';

if (class_exists('Google\Client')) {
    echo "GOOGLE CLIENT OK";
} else {
    echo "GOOGLE CLIENT TIDAK ADA";
}