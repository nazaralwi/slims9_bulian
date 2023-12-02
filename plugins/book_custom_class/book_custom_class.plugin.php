<?php
/**
 * Plugin Name: Book Custom Class
 * Plugin URI: -
 * Description: -
 * Version: 1.0.0
 * Author: Drajat Hasan
 * Author URI: https://t.me/drajathasan
 */

use SLiMS\{DB,Plugins,Json};

// get plugin instance
$plugin = Plugins::getInstance();
// Menu for master data
$plugin->registerMenu('membership', 'Pengklompokan Custom', __DIR__ . '/pages/custom_class.php');

// registering menus or hook
$plugin->register('advance_custom_field_data', function(&$custom_data){
    if (isset($_POST['custom_class']) && count($_POST['custom_class'])) $custom_data['custom_class'] = (string)Json::stringify($_POST['custom_class']);
    if (isset($_POST['custom_class']) && !count($_POST['custom_class'])) $custom_data['custom_class'] = '[]';
});

$plugin->register('advance_custom_field_form', function($form, &$js){

    // List
    $customClass = DB::getInstance()->query('SELECT `id`,`name` FROM `mst_custom_class`');

    $options = [];
    while ($content = $customClass->fetch(PDO::FETCH_NUM)) {
        $options[] = $content;
    }

    $list = '<option value="0">Pilih</option>';
    foreach ($options as $option) {
        list($value,$label) = $option;
        $list .= '<option value="' . $value . '">' . $label . '</option>' . "\n";
    }

    $buttonList = '';
    if (isset($_REQUEST['itemID']))
    {
        // List
        $biblioCustomClass = DB::getInstance()->prepare('SELECT `custom_class` FROM `biblio_custom` WHERE `biblio_id` = ?');
        $biblioCustomClass->execute([$_REQUEST['itemID']]);
        $biblioCustomClassData = [];
        if ($biblioCustomClass->rowCount() > 0) $biblioCustomClassData = Json::parse($biblioCustomClass->fetch(PDO::FETCH_ASSOC)['custom_class'])->toArray();


        foreach ($biblioCustomClassData??[] as $data) {
            foreach ($options as $button) {
                if (isset($button[0]) && $button[0] == $data)
                {
                    $buttonList .= '<input type="hidden" id="customClassFor'.$button[0].'" name="custom_class[]" value="' . $button[0] . '"/>';
                    $buttonList .= '<button class="btn btn-outline-secondary btn-sm rounded-pill m-1 px-2 py-1 deleteBtn" data-id="' . $button[0] . '">' . $button[1] . '<i class="ml-1 fa fa-close"></i></button>';
                }
            }
        }
    }

    // Kelompok Kustom
    $form->addAnything('Pengklompokan Kustom', <<<HTML
    <div class="w-100 d-flex flex-column">
        <div class="w-100">
            <select class="select select2 kelompok">
                {$list}
            </select>
        </div>
        <div id="resultArea" class="w-100 d-flex flex-wrap p-3 border border-secondary">
            {$buttonList}
        </div>
    </div>
    HTML);

    $js = <<<JS
    $('.kelompok').change(function(){
        // return;
        let target = $(this)[0].selectedOptions[0]
        let valueSelected = target.value
        let labelSelected = target.innerText
        
        if ($('#customClassFor' + valueSelected).length == 0)
        {
            $('#resultArea').append(`
                <input type="hidden" id="customClassFor\${valueSelected}" name="custom_class[]" value="\${valueSelected}"/>
                <button class="btn btn-outline-secondary btn-sm rounded-pill m-1 px-2 py-1 deleteBtn" data-id="\${valueSelected}">\${labelSelected}<i class="ml-1 fa fa-close"></i></button>
            `)
        }
    })

    $('#mainContent').on('click', '.deleteBtn', function(){
        let id = $(this).data('id')
        $('#customClassFor' + id).remove();
        $(this).remove();
    })
    JS;
});
