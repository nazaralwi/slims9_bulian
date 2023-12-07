<?php

/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 26/06/2021 1:07
 * @File name           : WelcomeController.php
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

namespace DTSIslam\App\Controllers;

use DTSIslam\App\Models\TmpTopic;
use DTSIslam\App\Models\TmpVocabularyControl;
use DTSIslam\App\Views\View;

class WelcomeController
{

    function index()
    {
        $topic_count = TmpTopic::count();
        $relation_count = TmpVocabularyControl::count();
        $topic_related_count = TmpTopic::join('tmp_voc_ctrl', 'tmp_voc_ctrl.topic_id', '=', 'tmp_topic.topic_id')
            ->whereNotNull('related_topic_id')->where('related_topic_id', '!=', '')->count();

        $title = __('DTS Islam');
        $description = __('Daftar Tajuk Subjek Islam dan Klasifikasi Islam');

        View::load(
            'welcome',
            [
                'topic_count' => $topic_count,
                'relation_count' => $relation_count, 
                'topic_related_count' => $topic_related_count, 
                'title' => $title, 
                'description' => $description
            ]
        );
    }

    function credits()
    {
        $title = __('Credits - DTS Islam');
        $description = __('Berikut ini mereka-mereka yang telah berkontribusi dalam pengembangan plugin DTS Islam');
        View::load('credits', [
            'title' => $title, 
                'description' => $description
        ]);
    }
}
