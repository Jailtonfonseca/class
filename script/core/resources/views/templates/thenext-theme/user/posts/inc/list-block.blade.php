<!-- Item-->
@php
    $picture     =   explode(',' ,$post->images);
    if($picture[0] != ""){
        $main_picture = $picture[0];
    }else{
        $main_picture = "default.png";
    }
@endphp

<div class="job-listing @if($post->highlight == '1') highlight @endif">
    <div class="job-listing-details">
        @php
            $picture     =   explode(',' ,$post->images);
            if($picture[0] != ""){
                $main_picture = $picture[0];
            }else{
                $main_picture = "default.png";
            }
        @endphp
        <div class="job-listing-company-logo">
            <img class="img-whp lazy-load" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"  data-original="{{ asset('storage/products/thumb/'.$main_picture) }}" alt="{{ $post->title }}">
        </div>
        <div class="job-listing-description">
            <h3 class="job-listing-title"><a href="{{ route('posts.single', [$post->id,$post->slug]) }}">{{ $post->title }}</a>
                @if($post->featured == '1') <span class="badge blue"> {{ ___('Featured') }}</span> @endif
                @if($post->urgent == '1') <span class="badge yellow"> {{ ___('Urgent') }}</span> @endif
                @if($post->highlight == '1') <span class="badge red"> {{ ___('Highlight') }}</span> @endif
            </h3>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('search.category', $post->category->get_translated_slug()) }}"><i class="la la-tags"></i>
                        {{ $post->category->get_translated_title() }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('search.subcategory', [$post->category->get_translated_slug(), $post->sub_category->get_translated_slug()]) }}">
                        {{ $post->sub_category->get_translated_title() }}
                    </a>
                </li>
            </ol>
            <div>
                @if($post->custom_field_data->count() > 0)
                    <ul class="prop_details mb0">
                        @foreach ($post->custom_field_data as $customdata)
                            @if($customdata->active && $customdata->show_in_view)
                                @if($customdata->type == 'drop-down' || $customdata->type == 'radio-buttons')
                                    @php
                                        $option = get_customOptions_by_id($customdata->pivot->field_data);
                                    @endphp
                                    @if($option)
                                        <li class="list-inline-item">
                                            <img src="{{ $customdata->icon }}" width="14"/>
                                            {{ $customdata->get_translated_title() }}:
                                            {{ $option->get_translated_title() }}
                                        </li>
                                    @endif
                                @elseif($customdata->type == 'text-field' || $customdata->type == 'textarea')
                                    <li class="list-inline-item">
                                        <img src="{{ $customdata->icon }}" width="14"/>
                                        {{ $customdata->get_translated_title() }}:
                                        {{ $customdata->pivot->field_data }}
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    </ul>
                @else
                    <div>
                        <a class="locationStorage" href="#" data-id="{{ @$post->city->id }}" data-name="{{ @$post->city->name }}" data-type="city">
                            <i class="la la-map-marker"></i>
                            {{ @$post->city->name }},
                            {{ @$post->country->name }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="job-listing-footer with-icon">
        <ul>
            <li><a href="{{ route('profile', $post->user->username) }}"><i class="la la-user"></i> {{ $post->user->username }}</a></li>
            <li>
                <a class="locationStorage" href="#" data-id="{{ @$post->city->id }}" data-name="{{ @$post->city->name }}" data-type="city">
                    <i class="la la-map-marker"></i>
                    {{ @$post->city->name }},
                    {{ @$post->country->name }}
                </a>
            </li>
            @if($post->price != '0')
                <li><i class="la la-credit-card"></i> {!! price_format_by_country($post->price,$post->country_code) !!}</li>
            @endif

            <li><i class="la la-clock-o"></i> {{ date_formating($post->created_at) }}</li>
        </ul>
        @auth
            @if(auth()->user()->id != $post->user_id)
                <span class="fav-icon set-item-fav
                                            @if($post->hasFavorite()) added @endif"
                      data-item-id="{{ $post->id }}"
                      data-userid="{{ auth()->user()->id }}"
                      data-action="{{ route('posts.setFavorite') }}">
                                            </span>
            @endif
        @endauth
    </div>
</div>
