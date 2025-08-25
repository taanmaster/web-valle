<?php

namespace App\Services;

/* Regular Laravel */
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Exception;
use Request;

use App\Models\Notification;

class NotificationService
{   
    public function send($type, $by ,$data, $model_action, $model_id)
    {
        /* LOG */
        if ($by == NULL) {
            $log = new Notification([
                'model_action' => $model_action,
                'model_id' => $model_id,
                'type' => $type,
                'data' => $data,
                'is_hidden' => false
            ]);
        }else{
            $log = new Notification([
                'action_by' => $by->id,
                'model_action' => $model_action,
                'model_id' => $model_id,
                'type' => $type,
                'data' => $data,
                'is_hidden' => false
            ]);
        }
        
        $log->save();
    }
}