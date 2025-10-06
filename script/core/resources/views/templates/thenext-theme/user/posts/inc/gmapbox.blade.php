<!-- Item-->
@php
    $picture     =   explode(',' ,$post->images);
    if($picture[0] != ""){
        $main_picture = $picture[0];
    }else{
        $main_picture = "default.png";
    }
@endphp

<div class="infoBox item gmapAdBox" data-id="{{ $post->id }}" style="margin-bottom: 0px;" @if($post->highlight == '1') highlighted @endif>
    <div class="map-box">
        <div class="infoBox-close"><i class="icon-feather-x"></i></div>
        <div class="card bg-transparent border-0" data-bs-theme="light">
            <div class="card-img-top position-relative bg-body-tertiary overflow-hidden">
                <div class="ratio d-block"><img style="width: 281px; height: 191px"
                                                src="{{ asset('storage/products/thumb/'.$main_picture) }}"
                                                alt="{{ $post->title }}"></div>
            </div>
            <div class="card-body p-3">
                @if($post->price != 0)
                    <div class="h5"> {!! price_format_by_country($post->price,$post->country_code) !!} </div>
                @endif
                <h5 class="fs-sm fw-normal text-body">
                    <a class="stretched-link text-body"
                       href="{{ route('posts.single', [$post->id,$post->slug]) }}">{{ $post->title }}</a>
                </h5>
                <div class="h6 fs-sm mb-0">{{ $post->category->get_translated_title() }}</div>
            </div>
            <div class="card-footer d-flex gap-2 border-0 bg-transparent pt-0 pb-3 px-3 mt-n1 text-body">
                @include($activeTheme.'user.posts.inc.custom_data')
            </div>
        </div>
    </div>
</div>
