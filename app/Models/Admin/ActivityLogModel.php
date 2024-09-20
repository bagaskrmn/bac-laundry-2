<?php

namespace App\Models\Admin;
use Request;

use App\Models\Admin\BaseModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityLogModel extends BaseModel
{
    public static function addLog($subject, array $description){

        // get nama menu
        $menu_name = ActivityLogModel::getMenuNameBySlug(session()->get('url_segment'))->menu_name ?? null;

        // params
        $params = [
            'menu'          => $menu_name,
            'subject'       => $subject,
            'description'   => json_encode((object) $description),
            'ip'            => Request::ip(),
            'agent'         => Request::header('sec-ch-ua') ?? null,
            'url'           => Request::fullUrl(),
            'method'        => Request::method(),
            'platform'      => Request::header('sec-ch-ua-platform') ?? null,
            'created_by'    => Auth::user()->user_id,
            'created_date'  => date('Y-m-d H:i:s')
        ];

        return DB::table('app_activity_log')->insertOrIgnore($params);
    }

    public static function getMenuNameBySlug($slug){
        return DB::table('app_menu')->select('menu_name')->where('menu_url', $slug)->first();
    }
}
