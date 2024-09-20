<?php

namespace App\Models\Admin;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BaseModel
{
    // make microtime ID
    public static function makeMicrotimeID()
    {
        return str_replace('.', '', microtime(true));
    }

    // get user menu access by url
    public static function getMenuAccessByUrl($url)
    {
        return DB::table('app_menu as a')
            ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
            ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
            ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
            ->where('a.menu_url', $url)
            ->where('c.user_id', Auth::user()->user_id)
            ->where('d.code', "R")
            ->first();
    }

    /**
     * Authorize Permission
     * @type is C,R,U,D
     */
    public static function authorize($menu_id, $permission_code)
    {
        if (!BaseModel::isAuthorize($menu_id, $permission_code)) {
            return abort('403', 'Unauthorized Access');
        } else {
            return true;
        }
    }

    public static function isAuthorize($menu_id, $permission_code)
    {
        $permission = DB::table('app_menu as a')
            ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
            ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
            ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
            ->where('a.menu_id', $menu_id)
            ->where('c.user_id', Auth::user()->user_id)
            ->where('d.code', $permission_code)
            ->first();

        if (empty($permission) || $permission == NULL) {
            return false;
        } else {
            return true;
        }
    }

    // user role
    public static function getUserRole()
    {
        $data = DB::table('app_role')
            ->select('role_name')
            ->join('app_role_user', 'app_role.role_id', '=', 'app_role_user.role_id')
            ->where('user_id', Auth::user()->user_id)
            ->first();

        return $data;
    }

    // login type 
    public static function getLoginType()
    {
        $data = DB::table('app_user')
        ->where('user_id', Auth::user()->user_id)
        ->value('login_type');

        return $data;
    }

    // user role id
    public static function getUserRoleId()
    {
        $data = DB::table('app_role')
            ->join('app_role_user', 'app_role.role_id', '=', 'app_role_user.role_id')
            ->where('user_id', Auth::user()->user_id)
            ->value('app_role.role_id');

        return $data;
    }

    // get nama Rumah Sakit By Branch_id
    public static function getBranch()
    {
        $data = DB::table('master_branch')
            ->select('name')
            ->where('id', Auth::user()->branch_id)
            ->first();

        return $data;
    }

    // get parent menu utama
    public static function parentMenuUtama($user_id)
    {
        // get data
        $parent_menu_utama = DB::table('app_menu AS a')
            ->select('a.menu_id', 'parent_menu_id', 'menu_name', 'menu_url', 'menu_icon', 'menu_active')
            ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
            ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
            ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
            ->whereNull('a.parent_menu_id')
            ->where([
                ['a.menu_display', '=', '1'],
                ['a.menu_group', '=', 'utama'],
                ['c.user_id', '=', $user_id],
                ['d.code', '=', 'R'],
            ])
            ->orderBy('a.menu_sort', 'ASC')
            ->get();

        // return
        return $parent_menu_utama;
    }

    // get child menu utama
    public static function childMenuUtama($menu_id, $user_id)
    {
        // get data
        $child_menu_utama = DB::table('app_menu AS a')
            ->select('a.menu_id', 'parent_menu_id', 'menu_name', 'menu_url', 'menu_icon', 'menu_active')
            ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
            ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
            ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
            ->where([
                ['a.parent_menu_id', '=', $menu_id],
                ['a.menu_display', '=', '1'],
                ['a.menu_group', '=', 'utama'],
                ['c.user_id', '=', $user_id],
                ['d.code', '=', 'R'],
            ])->orderBy('a.menu_sort', 'ASC')
            ->get();

        // return
        return $child_menu_utama;
    }

    // get parent menu tender
    public static function parentMenuTender($user_id)
    {
        // get data
        $parent_menu_tender = DB::table('app_menu AS a')
        ->select('a.menu_id', 'parent_menu_id', 'menu_name', 'menu_url', 'menu_icon', 'menu_active')
        ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
        ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
        ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
        ->whereNull('a.parent_menu_id')
        ->where([
            ['a.menu_display', '=', '1'],
            ['a.menu_group', '=', 'tender'],
            ['c.user_id', '=', $user_id],
            ['d.code', '=', 'R'
            ],
        ])
        ->orderBy('a.menu_sort', 'ASC')
        ->get();

        // return
        return $parent_menu_tender;
    }

    // get child menu tender
    public static function childMenuTender($menu_id, $user_id)
    {
        // get data
        $child_menu_tender = DB::table('app_menu AS a')
        ->select('a.menu_id', 'parent_menu_id', 'menu_name', 'menu_url', 'menu_icon', 'menu_active')
        ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
        ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
        ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
        ->where([
            ['a.parent_menu_id', '=', $menu_id],
            ['a.menu_display', '=', '1'],
            ['a.menu_group', '=', 'tender'],
            ['c.user_id', '=', $user_id],
            ['d.code', '=', 'R'
            ],
        ])->orderBy('a.menu_sort', 'ASC')
        ->get();

        // return
        return $child_menu_tender;
    }


    // get parent menu teknik
    public static function parentMenuTeknik($user_id)
    {
        // get data
        $parent_menu_teknik = DB::table('app_menu AS a')
        ->select('a.menu_id', 'parent_menu_id', 'menu_name', 'menu_url', 'menu_icon', 'menu_active')
        ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
        ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
        ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
        ->whereNull('a.parent_menu_id')
        ->where([
            ['a.menu_display', '=', '1'],
            ['a.menu_group', '=', 'teknik'],
            ['c.user_id', '=', $user_id],
            ['d.code', '=', 'R'
            ],
        ])
        ->orderBy('a.menu_sort', 'ASC')
        ->get();

        // return
        return $parent_menu_teknik;
    }

    // get child menu teknik
    public static function childMenuTeknik($menu_id, $user_id)
    {
        // get data
        $child_menu_teknik = DB::table('app_menu AS a')
        ->select('a.menu_id', 'parent_menu_id', 'menu_name', 'menu_url', 'menu_icon', 'menu_active')
        ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
        ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
        ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
        ->where([
            ['a.parent_menu_id', '=', $menu_id],
            ['a.menu_display', '=', '1'],
            ['a.menu_group', '=', 'teknik'],
            ['c.user_id', '=', $user_id],
            ['d.code', '=', 'R'
            ],
        ])->orderBy('a.menu_sort', 'ASC')
        ->get();

        // return
        return $child_menu_teknik;
    }

    // get parent menu system
    public static function parentMenuSystem($user_id)
    {
        // get data
        $parent_menu_system = DB::table('app_menu AS a')
            ->select('a.menu_id', 'parent_menu_id', 'menu_name', 'menu_url', 'menu_icon', 'menu_active')
            ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
            ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
            ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
            ->whereNull('a.parent_menu_id')
            ->where([
                ['a.menu_display', '=', '1'],
                ['a.menu_group', '=', 'system'],
                ['c.user_id', '=', $user_id],
                ['d.code', '=', 'R'],
            ])
            ->orderBy('a.menu_sort', 'ASC')
            ->get();

        // dd($parent_menu_system);
        // return
        return $parent_menu_system;
    }

    // get child menu system
    public static function childMenuSystem($menu_id, $user_id)
    {
        // get data
        $child_menu_system = DB::table('app_menu AS a')
            ->select('a.menu_id', 'parent_menu_id', 'menu_name', 'menu_url', 'menu_icon', 'menu_active')
            ->join('app_menu_control as d', 'd.menu_id', '=', 'a.menu_id')
            ->join('app_role_menu_control as b', 'd.id', '=', 'b.menu_control_id')
            ->join('app_role_user as c', 'b.role_id', '=', 'c.role_id')
            ->where([
                ['a.parent_menu_id', '=', $menu_id],
                ['a.menu_display', '=', '1'],
                ['a.menu_group', '=', 'system'],
                ['c.user_id', '=', $user_id],
                ['d.code', '=', 'R'],
            ])->orderBy('a.menu_sort', 'ASC')
            ->get();

        // dd($child_menu_system);

        // return
        return $child_menu_system;
    }

    // get menu parent url
    public static function getParentMenuUrl($parent_menu_id)
    {
        return DB::table('app_menu')->where('menu_id', $parent_menu_id)->value('menu_url');
    }

    // bulan indoensia
    public static function bulanIndo()
    {
        return array('01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember');
    }

    // get target rata-rata nilai
    public static function getAppSupportBy($key)
    {
        return DB::table('app_supports')->where('key', $key)->value('value');
    }

    // get list branch by regional
    // public static function getListBranchByRegional($region_name) {
    //     return DB::table('master_branch as a')
    //         ->select('a.id','a.name as branch_name')
    //         ->where('a.region_name', $region_name)
    //         ->where('a.data_status','1')
    //         ->orderBy('a.name','asc')
    //         ->get();
    // }

    // get list branch by regional
    public static function notifikasiRead($user_id)
    {
        return DB::table('notifikasi as a')
            ->select('a.*', 'b.name as tender_name')
            ->leftJoin('tender as b', 'a.tender_id', 'b.id')
            ->where('a.user_id', $user_id)
            ->where('a.status', 1)
            ->orderBy('created_date', 'desc')
            ->paginate(10);
    }
    public static function notifikasiUnread($user_id)
    {
        return DB::table('notifikasi as a')
            ->select('a.*', 'b.name as tender_name')
            ->leftJoin('tender as b', 'a.tender_id', 'b.id')
            ->where('a.user_id', $user_id)
            ->where('status', 0)
            ->orderBy('created_date', 'desc')
            ->get();
    }

    public static function set_created_by($params)
    {
        $params = Arr::add($params, 'created_by', Auth::user()->user_id);
        $params = Arr::add($params, 'created_date', date('Y-m-d H:i:s'));

        return $params;
    }

    public static function set_modified_by($params)
    {
        $params = Arr::add($params, 'modified_by', Auth::user()->user_id);
        $params = Arr::add($params, 'modified_date', date('Y-m-d H:i:s'));

        return $params;
    }

    public static function insertAppSupport($params)
    {
        return DB::table('app_supports')->insert($params);
    }

    public static function updateAppSupportByKey($key, $params)
    {
        return DB::table('app_supports')->where('key', $key)->update($params);
    }
}
