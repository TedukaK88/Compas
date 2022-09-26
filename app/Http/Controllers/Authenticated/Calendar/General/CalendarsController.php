<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        // DD($request);
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    //予約削除機能追加
    public function delete(Request $request){
        // DD($request);
        $delete_date = $request->getDate;   //削除する予約の日付を変数にする
        $delete_part = $request->getPart;     //削除する予約の部を変数にする
        $delete_reserve_setting_id =        //削除する予約のレコードidを取得する
            \DB::table('reserve_settings')->select('id')
                ->where('setting_reserve',$delete_date)
                ->where('setting_part',$delete_part)
                ->value('id');
        $delete_user_id = Auth::id();
        $reserve_settings = ReserveSettings::where('setting_reserve', $delete_date)->where('setting_part', $delete_part)->first();
        // DD($request,$delete_date,$delete_part,$delete_reserve_setting_id,$delete_user_id);

        //予約レコードの削除
        \DB::table('reserve_setting_users')->where('user_id',$delete_user_id)->where('reserve_setting_id',$delete_reserve_setting_id)->delete();
        //該当日、部数の予約枠を１つ空ける
        $reserve_settings->increment('limit_users');

        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}