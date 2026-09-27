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

namespace calendartype_jalali;

use PHPUnit\Framework\Attributes\CoversClass;

/**
 * Tests for the Jalali calendar type.
 *
 * @package    calendartype_jalali
 * @category   test
 * @copyright  2026 Shamim Rezaie {@link http://foodle.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
#[CoversClass(structure::class)]
final class structure_test extends \advanced_testcase {
    /**
     * Ensure timestamps, including rendered and numeric-string values, can be formatted as Jalali date strings.
     */
    public function test_timestamp_to_date_string(): void {
        $structure = new structure();

        // Midnight (UTC) on 1 Farvardin 1403 (20 March 2024).
        $time = gmmktime(0, 0, 0, 3, 20, 2024);

        $this->assertSame('1 Farvardin 1403', $structure->timestamp_to_date_string($time, '%d %B %Y', 'UTC', true, true));
        $this->assertSame('01 Farvardin 1403', $structure->timestamp_to_date_string($time, '%d %B %Y', 'UTC', false, true));
        $this->assertSame('1403', $structure->timestamp_to_date_string($time, '%Y', 'UTC', true, true));
    }

    /**
     * Ensure timestamp_to_date_string accepts RenderedString objects and numeric strings.
     */
    public function test_timestamp_to_date_string_accepts_rendered_timestamp(): void {
        $structure = new structure();

        $expected = $structure->timestamp_to_date_string(1728487003, '%d %B %Y', 'UTC', true, true);
        $this->assertSame($expected, $structure->timestamp_to_date_string(
            new \Mustache\RenderedString('1728487003'),
            '%d %B %Y',
            'UTC',
            true,
            true,
        ));
        $this->assertSame($expected, $structure->timestamp_to_date_string('1728487003', '%d %B %Y', 'UTC', true, true));
    }
}
