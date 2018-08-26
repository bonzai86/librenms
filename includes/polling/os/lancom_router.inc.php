<?php
/**
 * locos.inc.php
 *
 * LibreNMS os polling module for Lancom LCOS
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2017 Marcus Pink
 * @author     Marcus Pink <mpink@avantgarde-labs.de>
 */
 
$root = snmp_get($device, '.1.3.6.1.2.1.1.2.0', '-OQv', '', '');

if (strpos($root, '.2356.500') > 0) {
    $serial  = snmp_get($device, $root.'.3.1.1.4.1', '-OQv', '', '');
    $version = snmp_get($device, $root.'.3.1.1.3.1', '-OQv', '', '');
    $hardware = snmp_get($device, $root.'.3.1.1.2.1', '-OQv', '', '');
} else {
    $lcos_data = snmp_get_multi_oid($device, 'lcsFirmwareVersionTableEntrySerialNumber.1 lcsFirmwareVersionTableEntryVersion.1  lcsFirmwareVersionTableEntryModule.1', '-OQs', 'LCOS-MIB');

    $serial  = $lcos_data['lcsFirmwareVersionTableEntrySerialNumber.eIfc'];
    $version = $lcos_data['lcsFirmwareVersionTableEntryVersion.eIfc'];
    $hardware = $lcos_data['lcsFirmwareVersionTableEntryModule.eIfc'];
}
unset($lcos_data);
