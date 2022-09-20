@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p><span>{{ $date }}日</span><span class="ml-3">{{ $part }}部</span></p>  <!-- 該当日付と部数の追記 -->
    <div class="h-75 border">
      <table class="">
        <tr class="text-center">
          <th class="w-25">ID</th>
          <th class="w-25">名前</th>
          <th class="w-25">場所</th>  <!-- 改修課題遷移図に従い追加した項目 -->
        </tr>
        @foreach($reservePersons[0]->users as $user)    <!-- Controllerより受け取った、該当日該当部数の予約者リストをforeachで表示する -->
        <tr class="text-center">
          <td class="w-25">{{ $user->id }}</td>   <!-- 予約者のIDを表示する -->
          <td class="w-25">{{ $user->over_name }} {{ $user->under_name }}</td>    <!-- 予約者の苗字と名前を表示する -->
          <td class="w-25">リモート</td>    <!-- 仮入力 -->
        </tr>
        @endforeach
      </table>
    </div>
  </div>
</div>
@endsection