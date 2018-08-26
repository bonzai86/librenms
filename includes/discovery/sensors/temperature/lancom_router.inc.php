<?php
/*
 * LibreNMS LCOS Temperature Sensor Discovery module
 *
 * Copyright (c) 2016 Chris A. Evans <thecityofguanyu@outlook.com>
 *
 * This program is free software: you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the
 * Free Software Foundation, either version 3 of the License, or (at your
 * option) any later version.  Please see LICENSE.txt at the top level of
 * the source code distribution for details.
 */

echo("LCOS");

$root = snmp_get($device, '.1.3.6.1.2.1.1.2.0', '-OQv', '', '');

if (strpos($root, '.2356.500') > 0) {
    // LCOS <= 9.0
    // Chassis temperature
    $high_limit         = snmp_get($device, $root.'.2.53.1.0', '-Oqv', 'LCOS-MIB');
    $high_warn_limit    = $high_limit - 10;
    $low_limit     = snmp_get($device, $root.'.2.53.2.0', '-Oqv', 'LCOS-MIB');
    $low_warn_limit          = $low_limit + 10;

    $descr    = "System Temperature";
    $valueoid = $root.'.3.1.1.4.1.47.20.0'; // LCOS-MIB::lcsStatusHardwareInfoTemperatureDegrees.0 = INTEGER: 24
    $value    = snmp_get($device, $root.'.1.47.20.0', '-Oqv', 'LCOS-MIB');
} else {
    // LCOS > 9.0
    // Chassis temperature
    $high_limit         = snmp_get($device, 'lcsSetupTemperatureMonitorUpperLimitDegrees.0', '-Oqv', 'LCOS-MIB');
    $high_warn_limit    = $high_limit - 10;
    $low_limit     = snmp_get($device, 'lcsSetupTemperatureMonitorLowerLimitDegrees.0', '-Oqv', 'LCOS-MIB');
    $low_warn_limit          = $low_limit + 10;

    $descr    = "System Temperature";
    $valueoid = ".1.3.6.1.4.1.2356.11.1.47.20.0"; // LCOS-MIB::lcsStatusHardwareInfoTemperatureDegrees.0 = INTEGER: 24
    $value    = snmp_get($device, 'lcsStatusHardwareInfoTemperatureDegrees.0', '-Oqv', 'LCOS-MIB');
}

if (is_numeric($value)) {
    discover_sensor($valid['sensor'], 'temperature', $device, $valueoid, 1, 'lcos', $descr, '1', '1', $low_limit, $low_warn_limit, $high_warn_limit, $high_limit, $value);
}
