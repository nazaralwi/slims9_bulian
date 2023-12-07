<?php

namespace DTSIslam\App\Controllers;

use Idoalit\SlimsEloquentModels\BiblioTopic;
use Idoalit\SlimsEloquentModels\Vocabulary;

class BiblioTopicController
{

    function getBiblioTopicCount()
    {
        header('Content-type: application/json');
        echo json_encode(['data' => BiblioTopic::count()]);
    }

    function doMigrate()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        header('Content-type: application/json');

        $migrated = 0;
        $errors = [];
        $biblioTopics = BiblioTopic::orderBy('biblio_id')->skip(($data['batch'] - 1) * $data['perbatch'])->take($data['perbatch'])->get();
        foreach ($biblioTopics as $biblioTopic) {
            $vocabs = Vocabulary::where('topic_id', $biblioTopic->topic_id)->get();
            foreach ($vocabs as $vocab) {
                if ($vocab->rt_id === 'U' && $biblioTopic->topic_id !== $vocab->related_topic_id) {
                    try {
                        // delete first
                        $biblioTopic->delete();

                        // input again
                        $ba = new BiblioTopic();
                        $ba->biblio_id = $biblioTopic->biblio_id;
                        $ba->topic_id = $vocab->related_topic_id;
                        $ba->level = $biblioTopic->level;
                        $ba->save();

                        $migrated++;
                    } catch (\Throwable $th) {
                        $errors[] = $th->getMessage();
                        // undo delete
                        $biblioTopic->save();
                    }
                }
            }
        }

        echo json_encode(['migrated' => $migrated, 'error' => $errors]);
    }
}
