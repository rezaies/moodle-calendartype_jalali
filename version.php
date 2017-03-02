<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Version details.
 *
 * @package calendartype_jalali
 * @copyright 2008 onwards Foodle Group {@link http://foodle.org}
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version    = 2013110100; // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires   = 2013110100; // Requires this Moodle version.
$plugin->component  = 'calendartype_jalali'; // Full name of the plugin (used for diagnostics).
$plugin->release    = '1.0 for Moodle 2.6+';

$plugin->dependencies = array('calendartype_gregorian' => ANY_VERSION);
$plugin->maturity   = MATURITY_STABLE;
