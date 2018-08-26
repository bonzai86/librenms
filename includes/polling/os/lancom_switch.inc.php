<?php

$root = snmp_get($device, '.1.3.6.1.2.1.1.2.0', '-OQv', '', '');

$serial  = snmp_get($device, $root.'.1.1.5.0', '-OQv', '', '');
$version = snmp_get($device, $root.'.1.1.3.0', '-OQv', '', '');
$hardware = snmp_get($device, $root.'.1.1.1.0', '-OQv', '', '');
