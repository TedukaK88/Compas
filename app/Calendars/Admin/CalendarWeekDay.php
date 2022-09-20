<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;
use Auth;

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render(){
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

  function dayPartCounts($ymd){
    $html = [];
    $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
    $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
    $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

    $html[] = '<div class="text-left">';
    $user = auth()->user(); // 予約詳細画面へ遷移する際に必要なログインユーザーIDを取得しておく
    if($one_part){//===============================================================================================================
      //  $html[] = '<p class="day_part m-0 pt-1">n部</p>';  より項目や機能追加
      //    === 前準備 ===
      //  countする為に上記の$one_partからreserve_setting_idを数値として抜き出し、reserve_setting_usersから該当の予約数をcount-----------
      $one_part_id = intval($one_part["id"]);   //部数のIDを文字列から数値化する
      $one_part_count = \DB::table('reserve_setting_users')->where('reserve_setting_id',$one_part_id)->count();   //予約tableから部数のIDに絞って検索した件数をcountする
      //  --------------------------------------------------------------------------------------------------------------------------
      //　  === 予約確認画面表のマスの中身のview用コード　===
      $html[] = '<div class="d-flex">';   //flex配置用のdiv
      $html[] = '<a href="/calendar/'.$user->id.'/'.$ymd.'/1" class="day_part m-0 pt-1 text-primary">1部</a>';  //部数の表示兼詳細ページへのリンク
      $html[] = '<p class="ml-4 day_part m-0 pt-1">'.$one_part_count.'</p>';    //予約人数の表示
      $html[] = '</div>';
      //  ------------------------------------------------------------------------
    }
      //   ----- 以下３部まで繰り返す -----
    if($two_part){//===============================================================================================================
      $two_part_id = intval($two_part["id"]);
      $two_part_count = \DB::table('reserve_setting_users')->where('reserve_setting_id',$two_part_id)->count();
      //  --------------------------------------------------------------------------------------------------------------------------
      $html[] = '<div class="d-flex">';
      $html[] = '<a href="/calendar/'.$user->id.'/'.$ymd.'/2" class="day_part m-0 pt-1 text-primary">2部</a>';
      $html[] = '<p class="ml-4 day_part m-0 pt-1">'.$two_part_count.'</p>';
      $html[] = '</div>';
      //  ------------------------------------------------------------------------
    }
    if($three_part){//===============================================================================================================
      $three_part_id = intval($three_part["id"]);
      $three_part_count = \DB::table('reserve_setting_users')->where('reserve_setting_id',$three_part_id)->count();
      //  --------------------------------------------------------------------------------------------------------------------------
      $html[] = '<div class="d-flex">';
      $html[] = '<a href="/calendar/'.$user->id.'/'.$ymd.'/3" class="day_part m-0 pt-1 text-primary">3部</a>';
      $html[] = '<p class="ml-4 day_part m-0 pt-1">'.$three_part_count.'</p>';
      $html[] = '</div>';
      //  ------------------------------------------------------------------------
    }//===============================================================================================================
    $html[] = '</div>';

    return implode("", $html);
  }


  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}