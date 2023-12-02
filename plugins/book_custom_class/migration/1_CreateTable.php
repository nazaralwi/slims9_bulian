<?php
/**
 * @author Drajat Hasan
 * @email drajathasan20@gmail.com
 * @create date 2022-11-28 14:55:28
 * @modify date 2022-11-28 15:23:38
 * @license GPLv3
 * @desc [description]
 */

use SLiMS\Migration\Migration;
use SLiMS\Table\{Schema,Blueprint};

class CreateTable extends Migration
{
    function up()
    {
        Schema::create('mst_custom_class', function(Blueprint $table){
            $table->autoIncrement('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        if (!Schema::hasColumn('biblio_custom', 'custom_class'))
        {
            Schema::table('biblio_custom', function(Blueprint $table){
                $table->text('custom_class')->nullable()->add();
            });
        }
    }

    function down()
    {
        
    }
}
