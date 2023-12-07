<?php

use SLiMS\DB;

class Initialize
{
    private $db = null;

    public function __construct()
    {
        $this->db = DB::getInstance();
    }

    function up()
    {
        $query = '';
        $sqlScript = file(__DIR__ . '/../sql/v1.0.0.sql');
        foreach ($sqlScript as $line) {

            $startWith = substr(trim($line), 0, 2);
            $endWith = substr(trim($line), -1, 1);

            if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
                continue;
            }

            $query = $query . $line;
            if ($endWith == ';') {
                $this->db->query($query);
                $query = '';
            }
        }
    }

    function down()
    {
        $this->db->query("DROP TABLE IF EXISTS `tmp_relation_term`;");
        $this->db->query("DROP TABLE IF EXISTS `tmp_topic`;");
        $this->db->query("DROP TABLE IF EXISTS `tmp_voc_ctrl`;");
    }
}
