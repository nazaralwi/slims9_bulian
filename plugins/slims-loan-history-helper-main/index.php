<?php
/**
 * @Created by          : Drajat Hasan
 * @Date                : 2022-07-13 21:31:39
 * @File name           : index.php
 */

use SLiMS\DB;

defined('INDEX_AUTH') OR die('Direct access not allowed!');

ob_start();
// IP based access limitation
require LIB . 'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-system');
// start the session
require SB . 'admin/default/session.inc.php';
require SB . 'admin/default/session_check.inc.php';
// set dependency
require SIMBIO . 'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO . 'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO . 'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO . 'simbio_DB/datagrid/simbio_dbgrid.inc.php';
// end dependency

// privileges checking
$can_read = utility::havePrivilege('system', 'r');

if (!$can_read) {
    die('<div class="errorBox">' . __('You are not authorized to view this section') . '</div>');
}

function httpQuery($query = [])
{
    return http_build_query(array_unique(array_merge($_GET, $query)));
}

$page_title = 'Indeks Sejarah Peminjaman';

/* Action Area */
function getLoanStatistic()
{
    return new class {
        private $scope = [
            'loan' => 'loan','loanHistory' => 'loan_history'
        ];

        public function compare():int
        {
            return $this->loan() - $this->loanHistory();
        }

        public function __call($method, $arguments):int
        {
            if (!isset($this->scope[$method])) return null;

            $staement = DB::getInstance()->query('SELECT COUNT(`loan_id`) AS num FROM `'.$this->scope[$method].'`');
            return $staement->FetchObject()->num;
        }
    };
}

function action()
{
    return new class {
        private $action = '';

        public function bind($actionName)
        {
            $this->action = $actionName;
            return $this;
        }

        public function execute()
        {
            if (!empty($this->action) && file_exists($actionPath = __DIR__ . DS . 'action' . DS . $this->action . '.php'))
            {
                include $actionPath;
            }
        }
    };
}

if (isset($_GET['section']))
{
    switch ($_GET['section']) {
        default:
            # code...
            break;
    }
    exit;
}

if (isset($_GET['action']))
{
    $action = pathinfo($_GET['action']);
    action()->bind($action['filename'])->execute();
    exit;
}
/* End Action Area */
?>
<div class="menuBox">
    <div class="menuBoxInner memberIcon">
        <div class="per_title">
            <h2><?php echo $page_title; ?></h2>
        </div>
        <div class="sub_section">
            <div class="btn-group">
                <a target="verbose" href="<?= $_SERVER['PHP_SELF'] . '?' . httpQuery(['action' => 'truncate']) ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Kosongkan</a>
                <a target="verbose" href="<?= $_SERVER['PHP_SELF'] . '?' . httpQuery(['action' => 'create']) ?>" class="btn btn-default"><i class="fa fa-pencil"></i> Buat Ulang</a>
            </div>
            <div class="btn-group" style="top: 65px;">
                <input type="checkbox" id="openVerbose"/>&nbsp;verbose
            </div>
        </div>
    </div>
</div>
<div class="w-100 d-block mx-5">
    <div class="d-block">
        <span>Jumlah data peminjaman</span> : <strong><?= getLoanStatistic()->loan() ?></strong>
    </div>
    <div class="d-block">
        <span>Jumlah data sejarah peminjaman</span> : <strong><?= getLoanStatistic()->loanHistory() ?></strong>
    </div>
    <div class="d-block">
        <span>Jumlah data yang tidak terindeks</span> : <strong><?= getLoanStatistic()->compare() ?></strong>
    </div>
</div>
<iframe src="<?= $_SERVER['PHP_SELF'] . '?' . httpQuery(['section' => 'iframe']) ?>" name="verbose" class="verbose d-none mx-auto my-3 rounded-lg" style="height: 300px;width: 90%;"></iframe>
<script>
    $(document).ready(function(){
        $('#openVerbose').click(function(){
            let verbose = $('.verbose');

            if (verbose.hasClass('d-none'))
            {
                $('a[target="verbose"]').each(function(){
                    $(this).attr('href', $(this).attr('href') + '&verbose=yes')
                });
                verbose.removeClass('d-none').addClass('d-block')
            }
            else
            {
                $('a[target="verbose"]').each(function(){
                    $(this).attr('href', $(this).attr('href').replace('&verbose=yes', ''))
                });
                verbose.addClass('d-none').removeClass('d-block')
            }
        });
    });
</script>
