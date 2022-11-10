<?php

require_once 'vendor/autoload.php';

error_reporting(E_ALL);

\VCR\VCR::configure()->setMode('new_episodes');
\VCR\VCR::turnOn();
