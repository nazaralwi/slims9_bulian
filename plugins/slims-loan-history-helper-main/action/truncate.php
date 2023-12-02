<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-07-13 22:48:56
 * @modify date 2022-07-14 00:14:42
 * @license GPLv3
 * @desc [description]
 */

use SLiMS\DB;

defined('INDEX_AUTH') OR die('Direct access not allowed!');

DB::getInstance()->query("TRUNCATE TABLE `loan_history`");

if (isset($_GET['verbose']))
{
    echo '<strong class="text-success">Mengosongkan tabel loan_history</strong>';
    include __DIR__ . DS . '..' . DS . 'iframe.template.inc.php';
    exit;
}

utility::jsToastr('Sukses', 'Mengosongkan tabel loan_history', 'success');
$url = $_SERVER['PHP_SELF'] . '?mod='  . $_GET['mod'] . '&id=' . $_GET['id'];
echo <<<HTML
<script>parent.$('#mainContent').simbioAJAX('{$url}')</script>
HTML;