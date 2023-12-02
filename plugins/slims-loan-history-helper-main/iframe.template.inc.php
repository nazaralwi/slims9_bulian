<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-07-13 22:19:52
 * @modify date 2022-07-13 23:27:08
 * @license GPLv3
 * @desc [description]
 */

defined('INDEX_AUTH') or die('direct access not allowed!');

$content = ob_get_clean();
?>
<!DOCTYPE Html>
<html>
    <head>
        <link href="<?= SWB ?>css/bootstrap.min.css" rel="stylesheet"/>
    </head>
    <body class="bg-dark text-white p-3">
        <?= $content??''?>
    </body>
</html>