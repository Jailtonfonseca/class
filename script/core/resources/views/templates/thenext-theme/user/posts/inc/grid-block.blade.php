<!-- Item-->
@php
    $picture     =   explode(',' ,$post->images);
    if($picture[0] != ""){
        $main_picture = $picture[0];
    }else{
        $main_picture = "default.png";
    }
@endphp

<div class="feat_property  @if($post->highlight == '1') highlight @endif">
    <div class="thumb">
        <img class="img-whp lazy-load" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"  data-original="{{ asset('storage/products/thumb/'.$main_picture) }}" alt="{{ $post->title }}">
        <div class="thmb_cntnt">
            <ul class="tag mb0">
                @if($post->featured == '1') <li class="list-inline-item featured"><a href="#"> {{ ___('Featured') }}</li> @endif
                @if($post->urgent == '1') <li class="list-inline-item urgent"><a href="#"> {{ ___('Urgent') }}</li> @endif
            </ul>
            <a class="fp_price" href="#">{!! price_format_by_country($post->price,$post->country_code) !!}</a>
        </div>
    </div>
    <div class="details">
        <div class="tc_content">
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
            <h4>
                <a href="{{ route('posts.single', [$post->id,$post->slug]) }}">
                    {{ $post->title }}
                </a>
            </h4>
            <p><i class="la la-map-marker"></i>
                {{ @$post->city->name }},
                {{ @$post->country->name }}
            </p>
            <div class="d-none">
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
                    <ul class="prop_details mb0">
                        <li class="list-inline-item">
                            {{ \Illuminate\Support\Str::limit(strip_tags($post->description), 110, $end='...') }}
                        </li>
                    </ul>
                @endif
            </div>
        </div>
        <div class="listing-footer">
            <a class="author-link" href="{{ route('profile', $post->user->username) }}"><i class="fa fa-user" aria-hidden="true"></i>
                {{ $post->user->username }}</a>
            <span><i class="fa fa-calendar-o" aria-hidden="true"></i>
                                                {{ date_formating($post->created_at) }}
                                            </span>
        </div>
    </div>
</div>
