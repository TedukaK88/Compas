@extends('layouts.sidebar')

@section('content')
<div class="board_area w-100 m-auto d-flex">
  <div class="post_view w-75 mt-5">
    <p class="w-75 m-auto">投稿一覧</p>
    @foreach($posts as $post)
    <div class="post_area border w-75 mt-3 mr-auto ml-auto mb-3 p-3">
      <p><span>{{ $post->user->over_name }}</span><span class="ml-3">{{ $post->user->under_name }}</span>さん</p>
      <p><a href="{{ route('post.detail', ['id' => $post->id]) }}">{{ $post->post_title }}</a></p>
      <div class="post_bottom_area d-flex">
        <div class="d-flex post_status">
            <?php
              $comment = \DB::table('post_comments')
              ->join('posts','posts.id','=','post_id')
              ->where('posts.id',$post->id)
              ->pluck('post_comments.user_id');
              $like = \DB::table('likes')
              ->join('posts','posts.id','=','like_post_id')
              ->where('posts.id',$post->id)
              ->pluck('like_user_id');
            ?>
          <div class="mr-5">
            <i class="fa fa-comment"></i><span class="">{{ count($comment) }}</span>
          </div>
          <div>
            @if(Auth::user()->is_Like($post->id))
            <p class="m-0"><i class="fas fa-heart un_like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ count($like) }}</span></p>
            @else
            <p class="m-0"><i class="fas fa-heart like_btn" post_id="{{ $post->id }}"></i><span class="like_counts{{ $post->id }}">{{ count($like) }}</span></p>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div class="other_area w-25">
    <div class="m-4">
      <div class="mb-3 btn btn-primary post-btn"><a href="{{ route('post.input') }}">新規投稿</a></div>
      <div class="mb-1">
        <input type="text" class="post-search" placeholder="キーワードで検索" name="keyword" form="postSearchRequest">
        <input type="submit" class="btn btn-secondary" value="検索" form="postSearchRequest">
      </div>
      <input type="submit" name="like_posts" class="category_btn" value="いいねした投稿" form="postSearchRequest">
      <input type="submit" name="my_posts" class="category_btn" value="自分の投稿" form="postSearchRequest">
      <ul>
        @foreach($categories as $category)
        <?php
          $sub_categories = \DB::table('sub_categories')->where('main_category_id',$category->id)->get();
        ?>
        <li class="main_categories mt-2" category_id="{{ $category->id }}"><span>{{ $category->main_category }}<span></li>
          <ul class="sub_categories">
          @foreach($sub_categories as $sub_category)
            <li class="ml-4">
              <input type="submit" name="category_word" class="category_btn" value="{{ $sub_category->sub_category }}" form="postSearchRequest">
            </li>
          @endforeach
          </ul>
        @endforeach
      </ul>
    </div>
  </div>
  <form action="{{ route('post.show') }}" method="get" id="postSearchRequest"></form>
</div>
@endsection