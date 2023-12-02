<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-07-13 23:31:15
 * @modify date 2022-07-14 00:14:37
 * @license GPLv3
 * @desc [description]
 */

use SLiMS\DB;

defined('INDEX_AUTH') OR die('Direct access not allowed!');

// took from installer
$loanQuery = DB::getInstance()->query(<<<SQL
INSERT INTO `loan_history` 
      (`loan_id`, 
        `item_code`, 
        `biblio_id`,
        `member_id`, 
        `loan_date`, 
        `due_date`, 
        `renewed`, 
        `is_lent`, 
        `is_return`, 
        `return_date`,
        `input_date`,
        `last_update`,
        `title`,
        `call_number`,
        `classification`,
        `gmd_name`,
        `language_name`,
        `location_name`,
        `collection_type_name`,
        `member_name`,
        `member_type_name`
        )
    (SELECT l.loan_id,
        l.item_code,
        b.biblio_id,
        l.member_id,
        l.loan_date,
        l.due_date,
        l.renewed,
        l.is_lent,
        l.is_return,
        l.return_date,
        IF(day(l.input_date) IS NULL,NULL, l.input_date),
        IF(day(l.last_update) IS NULL,NULL, l.last_update),
        b.title,
        IF(i.call_number IS NULL,b.call_number,i.call_number),
        b.classification,
        g.gmd_name,
        ml.language_name,
        mlc.location_name,
        mct.coll_type_name,
        m.member_name,
        mmt.member_type_name 
    FROM loan l LEFT JOIN item i ON i.item_code=l.item_code
    LEFT JOIN biblio b ON b.biblio_id=i.biblio_id
    LEFT JOIN mst_gmd g ON g.gmd_id=b.gmd_id
    LEFT JOIN mst_language ml ON ml.language_id=b.language_id 
    LEFT JOIN mst_location mlc ON mlc.location_id=i.location_id
    LEFT JOIN member m ON m.member_id=l.member_id
    LEFT JOIN mst_coll_type mct ON mct.coll_type_id=i.coll_type_id
    LEFT JOIN mst_member_type mmt ON mmt.member_type_id=m.member_type_id WHERE m.member_id IS NOT NULL AND b.biblio_id IS NOT NULL);
SQL);

// Trigger
DB::getInstance()->query(<<<SQL
--
-- create trigger `delete_loan_history`
--

DROP TRIGGER IF EXISTS `delete_loan_history`;
CREATE TRIGGER `delete_loan_history` AFTER DELETE ON `loan`
 FOR EACH ROW DELETE FROM loan_history WHERE loan_id=OLD.loan_id;

--
-- create trigger `update_loan_history`
--

DROP TRIGGER IF EXISTS `update_loan_history`;
CREATE TRIGGER `update_loan_history` AFTER UPDATE ON `loan`
 FOR EACH ROW UPDATE loan_history 
SET is_lent=NEW.is_lent,
is_return=NEW.is_return,
renewed=NEW.renewed,
return_date=NEW.return_date
WHERE loan_id=NEW.loan_id;

--
-- create trigger `insert_loan_history`
--

DROP TRIGGER IF EXISTS `insert_loan_history`;
    CREATE TRIGGER `insert_loan_history` AFTER INSERT ON `loan`
     FOR EACH ROW INSERT INTO loan_history
     SET loan_id=NEW.loan_id,
     item_code=NEW.item_code,
     member_id=NEW.member_id,
     loan_date=NEW.loan_date,
     due_date=NEW.due_date,
     renewed=NEW.renewed,
     is_lent=NEW.is_lent,
     is_return=NEW.is_return,
     return_date=NEW.return_date,
     input_date=NEW.input_date,
     last_update=NEW.last_update,
     title=(SELECT b.title FROM biblio b LEFT JOIN item i ON i.biblio_id=b.biblio_id WHERE i.item_code=NEW.item_code),
     biblio_id=(SELECT b.biblio_id FROM biblio b LEFT JOIN item i ON i.biblio_id=b.biblio_id WHERE i.item_code=NEW.item_code),
     call_number=(SELECT IF(i.call_number IS NULL, b.call_number,i.call_number) FROM biblio b LEFT JOIN item i ON i.biblio_id=b.biblio_id WHERE i.item_code=NEW.item_code),
     classification=(SELECT b.classification FROM biblio b LEFT JOIN item i ON i.biblio_id=b.biblio_id WHERE i.item_code=NEW.item_code),
     gmd_name=(SELECT g.gmd_name FROM biblio b LEFT JOIN item i ON i.biblio_id=b.biblio_id LEFT JOIN mst_gmd g ON g.gmd_id=b.gmd_id WHERE i.item_code=NEW.item_code),
     language_name=(SELECT l.language_name FROM biblio b LEFT JOIN item i ON i.biblio_id=b.biblio_id LEFT JOIN mst_language l ON b.language_id=l.language_id WHERE i.item_code=NEW.item_code),
     location_name=(SELECT ml.location_name FROM item i LEFT JOIN mst_location ml ON i.location_id=ml.location_id WHERE i.item_code=NEW.item_code),
     collection_type_name=(SELECT mct.coll_type_name FROM mst_coll_type mct LEFT JOIN item i ON i.coll_type_id=mct.coll_type_id WHERE i.item_code=NEW.item_code),
     member_name=(SELECT m.member_name FROM member m WHERE m.member_id=NEW.member_id),
     member_type_name=(SELECT mmt.member_type_name FROM mst_member_type mmt LEFT JOIN member m ON m.member_type_id=mmt.member_type_id WHERE m.member_id=NEW.member_id);;
SQL);

if (isset($_GET['verbose']))
{
    echo '<strong class="text-success">Berhasil mengisi ulang loan_history</strong>';
    include __DIR__ . DS . '..' . DS . 'iframe.template.inc.php';
    exit;
}
utility::jsToastr('Sukses', 'Berhasil mengisi ulang loan_history', 'success');

$url = $_SERVER['PHP_SELF'] . '?mod='  . $_GET['mod'] . '&id=' . $_GET['id'];
echo <<<HTML
<script>parent.$('#mainContent').simbioAJAX('{$url}')</script>
HTML;