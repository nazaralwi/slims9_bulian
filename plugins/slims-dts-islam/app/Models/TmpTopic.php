<?php

namespace DTSIslam\App\Models;

use Illuminate\Database\Eloquent\Model;

class TmpTopic extends Model {
    protected $table = 'tmp_topic';
    protected $primaryKey = 'topic_id';

    function topicRelated() {
        return $this->hasOne(TmpTopic::class, 'topic_id', 'related_topic_id');
    }
}