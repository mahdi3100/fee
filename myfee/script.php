#!/usr/bin/php
<?php

require 'vendor/autoload.php';
use Candidat\Fee\Service\NewCSV;
$getcsvpath = $argv[1];
$NewCSV = new NewCSV($getcsvpath);
$NewCSV->checkFormatCSV();
$NewCSV->FeeResault();
