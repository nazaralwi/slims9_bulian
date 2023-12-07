<?php

namespace DTSIslam\App\Controllers;

use DTSIslam\App\Models\TmpTopic;
use DTSIslam\App\Models\TmpVocabularyControl;
use DTSIslam\App\Views\View;
use Idoalit\SlimsEloquentModels\Topic;
use Idoalit\SlimsEloquentModels\Vocabulary;

class SubjectController
{
    const AUTH_LIST = 'DTS Islam';

    function merge()
    {
        $title = __('Merge - DTS Islam');
        $description = __('Menu ini untuk menggabungkan DTS Islam dengan subjek kamu saat ini');
        View::load('merge', ['title' => $title, 'description' => $description]);
    }

    function topicCount()
    {
        header('Content-type: application/json');
        echo json_encode(['data' => TmpTopic::count()]);
    }

    function ourTopicCount() {
        header('Content-type: application/json');
        echo json_encode(['data' => Topic::where('auth_list', self::AUTH_LIST)->count()]);
    }

    function doMerge()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        header('Content-type: application/json');
        $topics = TmpTopic::orderBy('topic_id')->skip(($data['batch'] - 1) * $data['perbatch'])->take($data['perbatch'])->get();
        $errors = [];
        foreach ($topics as $topic) {
            try {
                // check if already exist
                $_topic = Topic::where('topic', $topic->topic)->first();
                if (is_null($_topic)) {
                    // add if not exist
                    $_topic = $this->addNewTopic($topic);
                }

                // working on relation
                $rels = TmpVocabularyControl::where('topic_id', $topic->topic_id)->get();
                foreach ($rels as $rel) {
                    // check if its a scope
                    if (!is_null($rel->scope)) {
                        // add scope
                        $scope = new Vocabulary();
                        $scope->topic_id = $_topic->topic_id;
                        $scope->rt_id = '';
                        $scope->related_topic_id = '';
                        $scope->scope = $rel->scope;
                        $scope->save();
                        continue;
                    }

                    // check related topic already exist or not
                    $rTopic = TmpTopic::find($rel->related_topic_id);
                    if (is_null($rTopic)) continue;

                    $_rTopic = Topic::where('topic', $rTopic->topic)->first();
                    // add related topic if not exist
                    if (is_null($_rTopic)) $_rTopic = $this->addNewTopic($rTopic);

                    // check relation
                    $relation = Vocabulary::where('topic_id', $_topic->topic_id)->where('related_topic_id', $_rTopic->topic_id)->first();
                    if (!is_null($relation)) continue;

                    // add relation
                    $relation = new Vocabulary();
                    $relation->topic_id = $_topic->topic_id;
                    $relation->rt_id = $rel->rt_id;
                    $relation->related_topic_id = $_rTopic->topic_id;
                    $relation->save();
                }
            } catch (\Throwable $th) {
                $errors[] = $th->getMessage();
            }
        }

        echo json_encode(['error' => $errors]);
    }

    function addNewTopic($topic)
    {
        $_topic = new Topic();
        $_topic->topic = $topic->topic;
        $_topic->topic_type = $topic->topic_type;
        $_topic->auth_list = self::AUTH_LIST;
        $_topic->classification = $topic->classification;
        $_topic->input_date = date('Y-m-d');
        $_topic->last_update = null;
        $_topic->save();
        return $_topic;
    }

    function use()
    {
        $title = __('Use - DTS Islam');
        $description = __('Menu ini untuk menerapkan kosakata terkendali DTS Islam dengan data bibliografi saat ini');
        View::load('use', ['title' => $title, 'description' => $description]);
    }

    function drop()
    {
        $title = __('Drop - DTS Islam');
        $description = __('Menu ini untuk menghapus subjek-subjek DTS Islam dari database');
        View::load('drop', ['title' => $title, 'description' => $description]);
    }
}
