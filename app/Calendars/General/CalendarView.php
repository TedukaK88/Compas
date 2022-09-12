<?php
namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView{

  private $carbon;
  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  public function getTitle(){
    return $this->carbon->format('Y年n月');
  }

  function render(){
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th>月</th>';
    $html[] = '<th>火</th>';
    $html[] = '<th>水</th>';
    $html[] = '<th>木</th>';
    $html[] = '<th>金</th>';
    $html[] = '<th>土</th>';
    $html[] = '<th>日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    foreach($weeks as $week){
      $html[] = '<tr class="'.$week->getClassName().'">';

      $days = $week->getDays();
      foreach($days as $day){
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        //カレンダー内の枠組みのコード
        if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
          //過去日の場合↓
          $html[] = '<td class="past-day border">';
        }else{
          //未来日の場合↓
          $html[] = '<td class="calendar-td '.$day->getClassName().'">';
        }
        $html[] = $day->render();

        if(in_array($day->everyDay(), $day->authReserveDay())){
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if($reservePart == 1){
            $reservePart = "リモ1部";
            $reserveResult = "1部参加";   //参加済み表記作成
          }else if($reservePart == 2){
            $reservePart = "リモ2部";
            $reserveResult = "2部参加";   //参加済み表記作成
          }else if($reservePart == 3){
            $reservePart = "リモ3部";
            $reserveResult = "3部参加";   //参加済み表記作成
          }
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            // 過去日 且つ 予約済み の時のコード  (出席情報の表示)
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">'.$reserveResult.'</p>';   //出席情報の表示
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';    //予約用配列のnull
          }else{
            //　未来日 且つ 予約済み の時のコード   (出席情報の表示、削除機能)
            $html[] = '<button class="btn btn-danger p-0 w-75 modalOpen" name="" style="font-size:12px" data-date="'. $day->authReserveDate($day->everyDay())->first()->setting_reserve .'" data-part="'.$day->authReserveDate($day->everyDay())->first()->setting_part.'" >'.$reservePart.'</button>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }
        }else{
          // 予約部数選択欄表示コードに過去日であるかのif文を追記↓
          if($startDay <= $day->everyDay() && $toDay >= $day->everyDay()){
            // 未予約 且つ 過去日 である場合のコード   (受付終了の文言)
            $html[] = '<p>受付終了</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';  //予約する際にnullの値が必要
          }else{
            // 未予約 且つ 未来日 である場合のコード   (予約機能)
            $html[] = $day->selectPart($day->everyDay());
          }
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">'.csrf_field().'</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field().'</form>';

    return implode('', $html);
  }
//予約キャンセルのmodal用=================================================================================================================
  function cancel(){
    $html[] = '<p id="showDate">予約日：xxxx-xx-xx</p>';
    $html[] = '<p id="showPart">時間：リモn部</p>';
    $html[] = '<p>上記の予約をキャンセルしてもよろしいですか？</p>';
    $html[] = '<br>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">'.csrf_field();
    $html[] = '<div class="d-grid gap-2 d-md-flex justify-content-between w-75 m-auto">';
    $html[] = '<button type="submit" class="btn btn-primary modalClose" style="font-size:12px">閉じる</button>';
    $html[] = '<button type="submit" class="btn btn-danger" style="font-size:12px" form="deleteParts">キャンセル</button>';
    $html[] = '<input type="hidden" id="cancelPart" name="getPart" value="value part" form="deleteParts">';
    $html[] = '<input type="hidden" id="cancelDate" name="getDate" value="value date" form="deleteParts">';
    $html[] = '</div>';
    $html[] = '</form>';

    return implode('', $html);
  }
//=======================================================================================================================================
  protected function getWeeks(){
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while($tmpDay->lte($lastDay)){
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}