@extends('admin.layouts.main')
@section('title', ___('Edit Post'))
@section('content')
<form id="quick-submitted-form" action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ ___('Title') }} *</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ $post->title }}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ ___('Slug') }} *</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="{{ $post->slug }}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ ___('Description') }} *</label>
                        <textarea cols="30" rows="5" class="form-control text-editor" name="description" placeholder="{{ ___('Tell us more about your listing') }}">{{ $post->description }}</textarea>
                    </div>
                    <div class="mb-3" id="quickad-photo-field">
                        <label class="form-label">{{ ___('Upload Images') }} *</label>
                        <input type="file"
                        class="quickImageUpload"
                        name="image[]"
                        multiple
                        data-allow-reorder="true"
                        data-max-file-size="3MB"
                        data-max-files="{{ @$settings->max_image_upload }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Category') }} *</label>
                        <select class="form-control" name="category" id="category">
                            <option value="">{{ __('Select Category') }}</option>
                            @foreach (categories() as $category)
                                <option value="{{ $category->id }}" {{ old('category', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('Sub Category') }} *</label>
                        <select class="form-control" name="sub_category" id="sub_category" data-selected="{{ $post->sub_category_id }}">
                        </select>
                    </div>
                    <div id="ResponseCustomFields">
                        @if(count($custom_fields))
                            @foreach($custom_fields as $field)
                                @php
                                    $field_title = $field->get_translated_title();
                                @endphp
                                @if($field->type == "text-field")
                                    <div class="mb-3">
                                        <label class="form-label">{{ $field_title }}
                                            @if($field->required) * @endif
                                        </label>
                                        <input type="text" class="form-control"
                                               name="custom[{{ $field->id }}]"
                                               id="custom[{{ $field->id }}]"
                                               value="{{ $field->default }}"
                                               placeholder="{{ $field_title }}"
                                               data-name="{{ $field->id }}"
                                               data-req="{{ $field->required }}"/>
                                        <div class="quick-error">{{ ___('This field is required.') }}</div>
                                    </div>
                                @endif
                                @if($field->type == "textarea")
                                    <div class="mb-3">
                                        <label class="form-label">{{ $field_title }}
                                            @if($field->required) * @endif
                                        </label>
                                        <textarea cols="10" rows="2" class="form-control text-editor"
                                                  name="custom[{{ $field->id }}]"
                                                  id="custom[{{ $field->id }}]"
                                                  placeholder="{{ $field_title }}"
                                                  data-name="{{ $field->id }}"
                                                  data-req="{{ $field->required }}">{{ $field->default }}</textarea>
                                        <div class="quick-error">{{ ___('This field is required.') }}</div>
                                    </div>
                                @endif
                                @if($field->type == "drop-down")
                                    <div class="mb-3">
                                        <label class="form-label">{{ $field_title }}
                                            @if($field->required) * @endif
                                        </label>
                                        <select class="form-control" name="custom[{{ $field->id }}]">
                                            <option value="" selected>{{ ___('Select') }} {{ $field_title }}</option>
                                            @foreach(explode(',',$field->options) as $option_id)
                                                @php
                                                    $option = get_customOptions_by_id($option_id);
                                                @endphp
                                                @if($option)
                                                    <option value="{{ $option_id }}"
                                                    @if($option_id == $field->default) selected @endif >{{ $option->get_translated_title() }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                @if($field->type == "radio-buttons")
                                    <div class="mb-3">
                                        <label class="form-label">{{ $field_title }}
                                            @if($field->required) * @endif
                                        </label>
                                        @foreach(explode(',',$field->options) as $option_id)
                                            @php
                                                $option = get_customOptions_by_id($option_id);
                                            @endphp
                                            @if($option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio"
                                                           name="custom[{{ $field->id }}]"
                                                           id="{{ $option_id }}"
                                                           value="{{ $option_id }}"
                                                           data-name="{{ $field->id }}"
                                                           @if($option_id == $field->default) checked @endif>
                                                    <label class="form-check-label" for="{{ $option_id }}">
                                                        {{ $option->get_translated_title() }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                                @if($field->type == "checkboxes")
                                    @php
                                        $custom_data = explode(',',$field->default);
                                    @endphp
                                    <div class="mb-3">
                                        <label class="form-label">{{ $field_title }}
                                            @if($field->required) * @endif
                                        </label>
                                        <br>
                                        @foreach(explode(',',$field->options) as $option_id)
                                            @php
                                                $option = get_customOptions_by_id($option_id);
                                            @endphp
                                            @if($option)
                                                <div class="checkbox mb-3">
                                                    <input type="checkbox"
                                                           name="custom[{{ $field->id }}][]"
                                                           id="{{ $option_id }}"
                                                           value="{{ $option_id }}"
                                                           data-name="{{ $field->id }}"
                                                           @if(in_array($option_id,$custom_data)) checked @endif/>
                                                    <label for="{{ $option_id }}"><span class="checkbox-icon"></span> {{ $option->get_translated_title() }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-3" id="quickad-price-field">
                        <label class="form-label">{{ ___('Price') }} *</label>
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-md-12">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="{{ ___('Price') }}" name="price" value="{{ $post->price }}" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2"><i class="currency">{{ get_currency_by_country_code($post->country_code) }}</i></span>
                                    </div>
                            </div>
                            <div class="col-xl-6 col-md-12 margin-top-12">
                                <div class="checkbox mb-3">
                                    <input type="checkbox" id="negotiable" name="negotiable" value="1" @if($post->negotiable == "1") checked @endif>
                                    <label for="negotiable" class="form-label fw-normal"><span class="checkbox-icon"></span> {{ ___('negotiable') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="submit-field mb-3">
                        <label class="form-label">{{ ___('Phone number') }} *</label>
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><img id="basic-addon1" src="{{ asset('assets/global/plugins/flags/images/') }}/{{ strtolower($post->country_code) }}.png"></span>
                                    <input type="text" class="form-control" name="phone" value="{{ $post->phone }}" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-12 ">
                                <div class="checkbox margin-top-12 mb-3">
                                    <input type="checkbox" name="hide_phone" id="phone" value="1" @if($post->hide_phone == "1") checked @endif>
                                    <label for="phone" class="form-label fw-normal"><span class="checkbox-icon"></span> {{ ___('hide') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('City') }} *</label>
                        <select id="jobcity" data-action="searchCityFromCountry"  class="form-control" name="city" data-size="7" title="{{ ___('Select City') }}">
                            <option value="0" selected="selected">{{ ___('Select City') }}</option>
                            @if($post->city_id != "")
                                <option value="{{ $post->city_id }}" selected="selected">{{ @$post->city->name }} , {{ @$post->state->name }}, {{ @$post->country->name }}</option>
                            @endif
                        </select>
                    </div>
                    <!-- Location -->
                    @if(@$settings->post_address_mode)
                        <div class="submit-field mb-3">
                            <label class="form-label">{{__('Address')}} *</label>
                            <div class="input-with-icon mb-3">
                                <div id="autocomplete-container" data-autocomplete-tip="{{ ___('type and hit enter') }}">
                                    <input class="form-control" type="text" placeholder="{{ ___('Address') }}" name="location" id="address-autocomplete" value="{{ $post->location }}">
                                </div>
                                <div class="geo-location"><i class="la la-crosshairs"></i></div>
                            </div>
                            <div class="map shadow" id="singleListingMap" data-latitude="{{ $latitude }}" data-longitude="{{ $longitude }}"  style="height: 200px" data-map-icon="map-marker"></div>
                            <small class="d-none">{{ ___('Drag the map marker to exact address') }}</small>
                            <input type="hidden" id="latitude" name="latitude" value="{{ $latitude }}"/>
                            <input type="hidden" id="longitude" name="longitude" value="{{ $longitude }}"/>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                    <label class="form-label">{{__('Status')}} *</label>
                    <select class="form-control" name="status">
                        <option value="active" @selected( $post->status == "active" )>{{ ___('Active') }}</option>
                        <option value="pending" @selected( $post->status == "pending" )>{{ ___('Pending') }}</option>
                        <option value="rejected" @selected( $post->status == "rejected" )>{{ ___('Rejected') }}</option>
                        <option value="expire" @selected( $post->status == "expire" )>{{ ___('Expired') }}</option>
                    </select>
                </div>
                <div class="submit-field form-group">
                    <label class="form-label">{{__('Tags')}} *</label>
                    <input class="form-control" type="text" name="tags" value="{{ $post->tag }}">
                    <small>{{ ___('Enter the tags separated by commas.') }}</small>
                </div>
                <div class="mt-3">
                    <label class="form-label">{{__('Premium')}} *</label> <br>
                    <div class="checkbox me-2">
                        <input type="checkbox" @if($post->featured == 1) checked @endif name="featured" id="featured" value="1">
                        <label for="featured" class="form-label fw-normal"><span class="checkbox-icon"></span> {{ ___('Featured') }}</label>
                    </div>
                    <div class="checkbox me-2">
                        <input type="checkbox" @if($post->urgent == 1) checked @endif name="urgent" id="urgent" value="1" >
                        <label for="urgent" class="form-label fw-normal"><span class="checkbox-icon"></span> {{ ___('Urgent') }}</label>
                    </div>
                    <div class="checkbox margin-top-12 mb-3">
                        <input type="checkbox" @if($post->highlight == 1) checked @endif name="highlight" id="highlight" value="1">
                        <label for="highlight" class="form-label fw-normal"><span class="checkbox-icon"></span> {{ ___('Highlight') }}</label>
                    </div>
                </div>
                <button type="submit" class="btn" style="background: #03bd62; padding: 5px 15px; color: white; border-radius: 6px;">{{ ___('Update') }}</button>
            </div>
        </div>
    </div>
</div>
</form>
@endsection
@push('scripts_at_top')
<script id="quick-sidebar-menu-js-extra">
    "use strict";
    const QuickMenu = {"page": "posts"};
</script>
@endpush
@push('scripts_at_bottom')
    <script src="{{ asset($activeThemeAssets.'assets/js/select2.min.js') }}"></script>
    @if(@$settings->post_desc_editor)
        <!-- CRUD FORM CONTENT - crud_fields_scripts stack -->
        <link href="{{ asset('assets/global/plugins/simditor/styles/simditor.css') }}" media="all" rel="stylesheet" type="text/css"/>
        <script src="{{ asset('assets/global/plugins/simditor/scripts/mobilecheck.js') }}"></script>
        <script src="{{ asset('assets/global/plugins/simditor/scripts/module.js') }}"></script>
        <script src="{{ asset('assets/global/plugins/simditor/scripts/uploader.js') }}"></script>
        <script src="{{ asset('assets/global/plugins/simditor/scripts/hotkeys.js') }}"></script>
        <script src="{{ asset('assets/global/plugins/simditor/scripts/simditor.js') }}"></script>
        <script>
            (function() {
                $(function() {
                    var $preview, editor, mobileToolbar, toolbar, allowedTags;
                    Simditor.locale = 'en-US';
                    toolbar = ['bold','italic','underline','|','ol','ul','blockquote','table','link'];
                    mobileToolbar = ["bold", "italic", "underline", "ul", "ol"];
                    if (mobilecheck()) {
                        toolbar = mobileToolbar;
                    }
                    allowedTags = ['br','span','a','img','b','strong','i','strike','u','font','p','ul','ol','li','blockquote','pre','h1','h2','h3','h4','hr','table'];
                    editor = new Simditor({
                        textarea: $('.text-editor'),
                        placeholder: '',
                        toolbar: toolbar,
                        pasteImage: false,
                        defaultImage: '{{ asset('assets/global/plugins/simditor/images/image.png') }}',
                        upload: false,
                        allowedTags: allowedTags
                    });
                    $preview = $('#preview');
                    if ($preview.length > 0) {
                        return editor.on('valuechanged', function(e) {
                            return $preview.html(editor.getValue());
                        });
                    }
                });
            }).call(this);
        </script>
    @endif

    @if(@$settings->post_address_mode)
        @if(@$settings->map_type == 'google')
            <link href="{{ asset('assets/global/plugins/map/google/map-marker.css') }}" type="text/css" rel="stylesheet">
            <script type='text/javascript' src='{{ asset('assets/global/plugins/map/google/jquery-migrate-1.2.1.min.js') }}'></script>
            <script type='text/javascript' src='//maps.google.com/maps/api/js?key={{ @$settings->gmap_api_key }}&#038;libraries=places%2Cgeometry&#038;ver=2.2.1'></script>
            <script type='text/javascript' src='{{ asset('assets/global/plugins/map/google/richmarker-compiled.js') }}'></script>
            <script type='text/javascript' src='{{ asset('assets/global/plugins/map/google/markerclusterer_packed.js') }}'></script>
            <script type='text/javascript' src='{{ asset('assets/global/plugins/map/google/gmapAdBox.js') }}'></script>
            <script type='text/javascript' src='{{ asset('assets/global/plugins/map/google/maps.js') }}'></script>
            <script>
                var _latitude       = @json(@$latitude);
                var _longitude      = @json(@$longitude);
                var path            = @json(asset('assets/global/plugins/map/google/'));
                var color           = @json(@$settings->map_color);
                var element         = "singleListingMap";
                var getCity         = false;
                var getCountry      = 'all';
                simpleMap(_latitude, _longitude, element);
            </script>
        @else
            <script>
                var openstreet_access_token = @json(@$settings->openstreet_access_token);
            </script>
            <link rel="stylesheet" href="{{ asset('assets/global/plugins/map/openstreet/css/style.css') }}">
            <!-- Leaflet // Docs: https://leafletjs.com/ -->
            <script src="{{ asset('assets/global/plugins/map/openstreet/leaflet.min.js') }}"></script>

            <!-- Leaflet Maps Scripts (locations are stored in leaflet-quick.js) -->
            <script src="{{ asset('assets/global/plugins/map/openstreet/leaflet-markercluster.min.js') }}"></script>
            <script src="{{ asset('assets/global/plugins/map/openstreet/leaflet-gesture-handling.min.js') }}"></script>
            <script src="{{ asset('assets/global/plugins/map/openstreet/leaflet-quick.js') }}"></script>

            <!-- Leaflet Geocoder + Search Autocomplete // Docs: https://github.com/perliedman/leaflet-control-geocoder -->
            <script src="{{ asset('assets/global/plugins/map/openstreet/leaflet-autocomplete.js') }}"></script>
            <script src="{{ asset('assets/global/plugins/map/openstreet/leaflet-control-geocoder.js') }}"></script>
            <script>
            </script>
        @endif
    @endif

    <link href="{{ asset('assets/global/plugins/filepond/filepond.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/global/plugins/filepond/filepond.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#jobcity').select2({
                placeholder: "{{ ___('Select City') }}"
            });
            $('#jobcity').select2({
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: ajaxurl,
                    type: "POST",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        var query = {
                            action: "searchCityFromCountry",
                            q: params.term, /* search term */
                            page: params.page
                        };

                        return query;
                    },
                    processResults: function (data, params) {
                        /*
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        */
                        params.page = params.page || 1;

                        return {
                            results: data.items,
                            pagination: {
                                more: (params.page * 10) < data.totalEntries
                            }
                        };
                    },
                    cache: true
                },
                escapeMarkup: function (markup) {
                    return markup;
                }, /* let our custom formatter work */
                minimumInputLength: 2,
                templateResult: function (data) {
                    return data.text;
                },
                templateSelection: function (data, container) {
                    return data.text;
                }
            });

            $('#jobcity').on('change', function() {
                var data = $("#jobcity option:selected").val();
                var custom_data= $("#jobcity").select2('data')[0];
                var latitude = custom_data.latitude;
                var longitude = custom_data.longitude;
                var address = custom_data.text;
                $('#latitude').val(latitude);
                $('#longitude').val(longitude);
                if (document.getElementById("singleListingMap") !== null && singleListingMap) {
                    $("#address-autocomplete").val(address);
                    var newLatLng = new L.LatLng(latitude, longitude);
                    singleListingMapMarker.setLatLng(newLatLng);
                    singleListingMap.flyTo(newLatLng, 10);
                }
            });

            //select category n sub-category
            function loadSubCategories(categoryId, selectedSubCategoryId = null) {
                var subCategorySelect = $('#sub_category');

                // Clear previous sub-categories
                subCategorySelect.empty();
                subCategorySelect.append('<option value="">Select Sub Category</option>');

                if (categoryId) {
                    $.ajax({
                        url: '{{route("admin.posts.get-sub-categories")}}',
                        type: 'GET',
                        data: { category_id: categoryId },
                        dataType: 'json',
                        success: function(data) {
                            $.each(data.sub_categories, function(key, subCategory) {
                                var selected = selectedSubCategoryId == subCategory.id ? 'selected' : '';
                                subCategorySelect.append('<option value="' + subCategory.id + '" ' + selected + '>' + subCategory.name + '</option>');
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error fetching sub-categories:', textStatus, errorThrown);
                            subCategorySelect.html('<option value="">Failed to load sub-categories</option>');
                        }
                    });
                }
            }

            // Event listener for category change
            $('#category').change(function() {
                var categoryId = $(this).val();
                loadSubCategories(categoryId);
            });

            // Trigger change event on page load if there's a pre-selected category
            var selectedCategoryId = $('#category').val();
            var selectedSubCategoryId = $('#sub_category').data('selected');
            if (selectedCategoryId) {
                loadSubCategories(selectedCategoryId, selectedSubCategoryId);
            }
        });
        // Turn input element into a pond with configuration options
        $('.quickImageUpload').filepond({
            imagePreviewHeight: 200,
            acceptedFileTypes: ['image/png','image/jpg','image/jpeg'],
            credits: false,
            server: {
                load: (source, load, error, progress, abort, headers) => {
                    const myRequest = new Request(source);
                    fetch(myRequest).then((res) => {
                        return res.blob();
                    }).then(load);
                },
                process: '{{ route('admin.posts.upload') }}',
                revert: '{{ route('admin.posts.revert') }}',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            files: [
                    @foreach($images as $image)
                    @if(!empty($image) && file_exists(public_path('storage/products/thumb/'.$image)))
                {
                    source: @json(asset('storage/products/thumb/'.$image)),
                    options: {
                        type: 'local',
                    },
                },
                @endif
                @endforeach
            ]
        });
    </script>

    <script>
        $('#sub_category').on('change', function (e) {
            e.preventDefault();
            // -------------------------------------------------------------
            //  Get custom fields
            // -------------------------------------------------------------
            var subcatid = $('#sub_category').val();
            var action = 'getCustomFieldByCatID';
            var data = {action: action, subcatid: subcatid};
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: ajaxurl,
                data: data,
                success: function (result) {
                    if (result != 0) {
                        $("#ResponseCustomFields").html(result);
                        $('#custom-field-block').show();
                    }
                    else {
                        $('#custom-field-block').hide();
                        $("#ResponseCustomFields").html('');
                    }
                }
            });
        });
        /** Custom-field error handler */
        $('#quick-submitted-form').on('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            $('#quick-error').hide();
            $('.form-control').removeClass('is-invalid');

            $('#ResponseCustomFields').find('.form-control').each(function () {
                const value = $(this).val().trim();
                const isRequired = $(this).data('req') === 1;

                if (isRequired && value === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    $(this).siblings('.quick-error').show();
                }
            });

            if (isValid) {
                this.submit();
            } else {
                $('html, body').animate({
                    scrollTop: $('.is-invalid:first').offset().top - 20
                }, 500);
            }
        });
    </script>
@endpush
