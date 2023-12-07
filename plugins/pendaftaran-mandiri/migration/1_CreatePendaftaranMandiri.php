<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 21/05/2021 15:28
 * @File name           : 1_CreatePendaftaranMandiri.php
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

class CreatePendaftaranMandiri extends \SLiMS\Migration\Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    function up()
    {
        \SLiMS\DB::getInstance()->query("CREATE TABLE `pendaftaran_mandiri` (
            `member_id` varchar(20) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
            `member_name` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
            `member_email` varchar(255) COLLATE 'utf8mb4_unicode_ci' NOT NULL,
            `member_address` text COLLATE 'utf8mb4_unicode_ci' NOT NULL,
            `input_date` timestamp NOT NULL
          ) ENGINE='MyISAM' COLLATE 'utf8mb4_unicode_ci';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    function down()
    {
        \SLiMS\DB::getInstance()->query('DROP TABLE `pendaftaran_mandiri`');
    }
}