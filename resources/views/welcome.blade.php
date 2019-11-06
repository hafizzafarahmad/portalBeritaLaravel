@extends('layouts.frontend.app')

@section('title','Home')

@push('css')
    <link href="{{ asset('assets/frontend/css/home/styles.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/frontend/css/home/responsive.css') }}" rel="stylesheet">
    <style>
        .favorite_posts{
            color: blue;
        }
    </style>
@endpush

@section('content')
    <!-- Feature section -->
	<section class="feature-section spad set-bg" data-setbg="{{ Storage::url('bg/bg1.png') }}">
		<div class="container">
			<div class="row">
                 @forelse($featureds as $featured)
                    <div class="col-lg-3 col-md-6 p-0">

                        <div class="feature-item set-bg" data-setbg="{{ Storage::url('post/'.$featured->image) }}">
                            <div class="fi-content text-white">
                                <h3><a href="{{ route('post.details',$featured->slug) }}"><b>{{ $featured->title }}</b></a></h3>
                            </div>
                        </div>

                    </div>
                    @empty
                    <div class="col-lg-12 col-md-12">

                        <div class="card h-100">
                            <div class="single-post post-style-1 p-2">
                               <strong>No Post Found :(</strong>
                            </div><!-- single-post -->
                        </div><!-- card -->
                        
                    </div><!-- col-lg-4 col-md-6 -->
                @endforelse
			</div>
		</div>
	</section>
	<!-- Feature section end -->

    <!-- section Post-->
    <section class="blog-area section recent-game-section spad">
        <div class="container">

            <div class="row">

                @forelse($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="single-post post-style-1">

                                <div class="blog-image"><img src="{{ Storage::url('post/'.$post->image) }}" alt="{{ $post->title }}"></div>

                                <div class="blog-info">

                                    <h4 class="title"><a href="{{ route('post.details',$post->slug) }}"><b>{{ $post->title }}</b></a></h4>

                                    <ul class="post-footer">

                                        <li>
                                            @guest
                                                <a href="javascript:void(0);" onclick="toastr.info('To add favorite list. You need to login first.','Info',{
                                                    closeButton: true,
                                                    progressBar: true,
                                                })"><i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>
                                            @else
                                                <a href="javascript:void(0);" onclick="document.getElementById('favorite-form-{{ $post->id }}').submit();"
                                                   class="{{ !Auth::user()->favorite_posts->where('pivot.post_id',$post->id)->count()  == 0 ? 'favorite_posts' : ''}}"><i class="ion-heart"></i>{{ $post->favorite_to_users->count() }}</a>

                                                <form id="favorite-form-{{ $post->id }}" method="POST" action="{{ route('post.favorite',$post->id) }}" style="display: none;">
                                                    @csrf
                                                </form>
                                            @endguest

                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-chatbubble"></i>{{ $post->comments->count() }}</a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-eye"></i>{{ $post->view_count }}</a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                    <div class="col-lg-12 col-md-12">
                        <div class="card h-100">
                            <div class="single-post post-style-1 p-2">
                               <strong>No Post Found :(</strong>
                            </div>
                        </div>
                    </div>
                @endforelse
            
            </div>

            <a class="load-more-btn" href="{{ route('post.index') }}"><b>LOAD MORE</b></a>

        </div>
    </section>
    <!-- End section Post-->

    <!-- Review section -->
	<section class="review-section spad set-bg" data-setbg="{{Storage::url('bg/bg2.jpg')}}">
		<div class="container">
			<div class="section-title">
				<div class="cata new">new</div>
				<h2 style="color:white">Recent Reviews</h2>
            </div>
			<div class="row">
                @forelse ($reviews as $review)
                <div class="col-lg-3 col-md-6">
                    <div class="review-item">
                        <div class="review-cover set-bg" data-setbg="{{Storage::url('review/'.$review->image)}}">
                            <div class="score yellow">{{ $review->score }}</div>
                        </div>
                        <div class="review-text">
                            <h5 style="color:white"><b>{{ $review->title }}</b></h5>
                            <p style="color:gainsboro">{{ $review->sh_review }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-lg-12 col-md-12">
                    <div class="card h-100">
                        <div class="single-post post-style-1 p-2">
                           <strong>No Post Found :(</strong>
                        </div>
                    </div>
                </div>
                @endforelse
			</div>
		</div>
	</section>
	<!-- Review section end -->
@endsection

@push('js')

@endpush