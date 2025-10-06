@extends($activeTheme.'layouts.app')
@section('title', $page_title)
@section('active_menu', $active_menu)
@section('content')
    <div class="dashboard-box margin-top-0">
        <div class="headline">
            <h3><i class="icon-feather-layers"></i> {{ $page_title }}</h3>
        </div>
        <div class="content with-padding">
            <div class="table-responsive">
                <table id="js-table-list" class="basic-table dashboard-box-list">
                    <tr>
                        <th class="big-width">{{ ___('Ads') }}</th>
                        <th class="small-width">{{ ___('Status') }}</th>
                        <th class="small-width">{{ ___('Action') }}</th>
                    </tr>
                    @if ($posts->count() > 0)
                        @foreach ($posts as $post)
                            <tr class="ajax-item-listing @if($post->hide == '1') opapcityLight @endif"
                                data-item-id="{{ $post->id }}">
                                <td>
                                    <div class="job-listing">
                                        <div class="job-listing-details">
                                            @php
                                                $picture     =   explode(',' ,$post->images);
                                                if($picture[0] != ""){
                                                    $main_picture = $picture[0];
                                                }else{
                                                    $main_picture = "default.png";
                                                }
                                            @endphp
                                            <div class="job-listing-description">
                                                <div class="job-listing-company-logo company-logo-myads">
                                                    <img class="img-whp lazy-load" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"  data-original="{{ asset('storage/products/thumb/'.$main_picture) }}" alt="{{ $post->title }}">
                                                </div>
                                                <div>
                                                    <h3 class="job-listing-title margin-bottom-5">
                                                        <a href="{{ route('posts.single', [$post->id,$post->slug]) }}">{{ $post->title }}</a>
                                                        <label class="label-wrap hidden-sm hidden-xs margin-zero d-inline-block">
                                                            @if($post->featured == '1') <span class="badge blue"> {{ ___('Featured') }}</span> @endif
                                                            @if($post->urgent == '1') <span class="badge yellow"> {{ ___('Urgent') }}</span> @endif
                                                            @if($post->highlight == '1') <span class="badge red"> {{ ___('Highlight') }}</span> @endif
                                                        </label>
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
                                                    <div class="job-listing-footer font-14">
                                                        <ul>
                                                            <li>
                                                                <i class="la la-map-marker"></i>
                                                                {{ @$post->city->name }},
                                                                {{ @$post->country->name }}
                                                            </li>
                                                            <li><i class="la la-calendar-times-o"></i> {{ ___('Expiring') }}: {{ date_formating($post->expire_date) }}</li>
                                                        </ul>
                                                        @if($post->price != '0')
                                                            <span class="table-property-price">{!! price_format_by_country($post->price,$post->country_code) !!}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td width="12%">
                                    @if($post->status == 'active') <span class="badge green"> {{ ___('Active') }}</span> @endif
                                    @if($post->status == 'pending') <span class="badge blue"> {{ ___('pending') }}</span> @endif
                                    @if($post->status == 'rejected') <span class="badge red"> {{ ___('rejected') }}</span> @endif
                                    @if($post->status == 'expire') <span class="badge yellow"> {{ ___('expire') }}</span> @endif
                                    @if($post->hide == '1') <span class="badge red label-hidden"> {{ ___('Hidden') }}</span> @endif
                                </td>
                                <td width="12%">
                                    <a href="{{ route('posts.edit', $post->id) }}" class="button gray ripple-effect ico" data-tippy-placement="top" title="{{ ___('Edit') }}"><i class="icon-feather-edit"></i></a>

                                    <a class="button gray ripple-effect ico item-js-hide" href="#" data-ajax-action="{{ route('posts.setShowHide',$post->id) }}"  data-tippy-placement="top" title="{{ $post->hide == '0' ? "hide" : "show" }}">
                                        <i class="fa {{ $post->hide == '0' ? "fa-eye-slash" : "fa-eye" }}"></i>
                                    </a>

                                    <a href="#" data-ajax-action="{{ route('posts.deleteMyListing',$post->id) }}" class="button gray ripple-effect ico item-js-delete" data-tippy-placement="top" title="{{ ___('Delete') }}"><i class="icon-feather-trash-2"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">{{ ___('Nothing found') }}</td>
                        </tr>
                    @endif
                </table>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- Pagination -->
                    <div class="pagination-container margin-top-20">
                        {{ $posts->links($activeTheme.'pagination/default') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts_at_bottom')
        <script type="text/javascript">
            var LANG_SHOW   = @json(___('Show'));
            var LANG_HIDE   = @json(___('Hide'));
            var LANG_HIDDEN   = @json(___('Hidden'));
        </script>
    @endpush
@endsection
