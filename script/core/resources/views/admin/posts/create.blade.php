@extends('admin.layouts.main')
@section('title', ___('Create Post'))
@section('content')
<form id="quick-submitted-form" action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ ___('Title') }} *</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required autofocus />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ ___('Slug') }} *</label>
                        <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ ___('Description') }} *</label>
                        <textarea cols="30" rows="5" class="form-control text-editor" name="description" placeholder="{{ ___('Tell us more about your listing') }}" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{__('Upload Images')}} *</label>
                        <input type="file"
                            class="quickImageUpload"
                            name="image[]"
                            multiple
                            data-allow-reorder="true"
                            data-max-file-size="3MB"
                            data-max-files="{{ @$settings->max_image_upload }}"
                            >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{__('Category')}} *</label>
                        <select class="form-control" name="category" id="category">
                            <option value="">{{ ___('Select Category') }}</option>
                            @foreach (categories() as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{__('Sub Category')}} *</label>
                        <select class="form-control" name="sub_category" id="sub_category">
                            <option value="">{{ ___('Select Sub-Category') }} </option>
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
                                        <textarea class="form-control text-editor"
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
                                                    <option value="{{ $option_id }}">{{ $option->get_translated_title() }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <div class="quick-error">{{ ___('This field is required.') }}</div>
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
                                                           data-name="{{ $field->id }}">
                                                    <label class="form-check-label" for="{{ $option_id }}">
                                                        {{ $option->get_translated_title() }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="quick-error">{{ ___('This field is required.') }}</div>
                                    </div>
                                @endif
                                @if($field->type == "checkboxes")
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
                                                           data-name="{{ $field->id }}"/>
                                                    <label for="{{ $option_id }}"><span class="checkbox-icon"></span> {{ $option->get_translated_title() }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                        <div class="quick-error">{{ ___('This field is required.') }}</div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ ___('Price') }} *</label>
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-md-12">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="price" aria-describedby="basic-addon2">
                                    <span class="input-group-text" id="basic-addon2"><i class="currency">{{$currency_code}}</i></span>
                                  </div>
                            </div>
                            <div class="col-xl-6 col-md-12 margin-top-12">
                                <div class="checkbox mb-3">
                                    <input type="checkbox" id="negotiable" name="negotiable" value="1">
                                    <label for="negotiable" class=" form-label fw-normal"><span class="checkbox-icon"></span> {{ ___('Negotiable') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ ___('Phone') }} *</label>
                        <div class="row align-items-center">
                            <div class="col-xl-6 col-md-12">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><img id="basic-addon1" src="{{ asset('assets/global/plugins/flags/images/') }}/{{strtolower($country_code)}}.png"></span>
                                    <input type="text" class="form-control" name="phone" aria-describedby="basic-addon1">
                                  </div>
                            </div>
                            <div class="col-xl-6 col-md-12 ">
                                <div class="checkbox margin-top-12 mb-3">
                                    <input type="checkbox" name="hide_phone" id="phone" value="1">
                                    <label for="phone" class="form-label fw-normal"><span class="checkbox-icon"></span> {{ ___('Hide') }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('City') }} *</label>
                        <select id="jobcity" data-action="searchCityFromCountry"  class="form-control" name="city" data-size="7" title="{{ ___('Select City') }}">
                            <option value="0" selected="selected">{{ ___('Select City') }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{__('Address')}} *</label>
                        <div class="input-with-icon mb-2">
                            <div id="autocomplete-container" data-autocomplete-tip="{{ ___('type and hit enter') }}">
                                <input class="form-control with-border" type="text" placeholder="{{ ___('Address') }}" name="location" id="address-autocomplete">
                            </div>
                            <div class="geo-location"><i class="la la-crosshairs"></i></div>
                        </div>
                        <div class="map shadow" id="singleListingMap" data-latitude="{{ $latitude }}" data-longitude="{{ $longitude }}"  style="height: 200px" data-map-icon="map-marker"></div>
                        <small class="d-none">{{ ___('Drag the map marker to exact address') }}</small>
                        <input type="hidden" id="latitude" name="latitude" value="{{ $latitude }}"/>
                        <input type="hidden" id="longitude" name="longitude" value="{{ $longitude }}"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                    <label class="form-label">{{ __('Status') }} *</label>
                    <select class="form-control" name="status">
                        <option value="">{{ __('Select Status') }}</option>
                        <option value="active">{{ __('Active') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="rejected">{{ __('Rejected') }}</option>
                        <option value="expire">{{ __('Expired') }}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{__('Tags')}} *</label>
                    <input type="text" class="form-control" name="tags" >
                    <small>{{ ___('Enter the tags separated by commas.') }}</small>
                </div>
                <div class="mt-3">
                    <label class="form-label">{{__('Premium')}} *</label> <br>
                        <div class="checkbox me-2">
                            <input type="checkbox" name="featured" id="featured" value="1">
                            <label for="featured" class="form-label fw-normal"><span class="checkbox-icon"></span> {{ ___('Featured') }}</label>
                        </div>
                        <div class="checkbox me-2">
                            <input type="checkbox" name="urgent" id="urgent" value="1" >
                            <label for="urgent" class="form-label fw-normal"><span class="checkbox-icon"></span> {{ ___('Urgent') }}</label>
                        </div>
                        <div class="checkbox margin-top-12 mb-3">
                            <input type="checkbox" name="highlight" id="highlight" value="1">
                            <label for="highlight" class="form-label fw-normal"><span class="checkbox-icon"></span> {{ ___('Highlight') }}</label>
                        </div>
                </div>
                <button type="submit" class="btn ripple-effect big" style="background: #03bd62; padding: 5px 15px; color: white; border-radius: 6px;"><i class="icon-feather-plus" ></i>{{ ___('Submit') }}</button>
            </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('scripts_at_top')
    <script type="text/javascript">
        "use strict";
        var QuickMenu = {"page": "posts"};
    </script>
@endpush
@push('scripts_vendor')
    <link href="{{ asset('assets/global/plugins/filepond/filepond.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/global/plugins/filepond/filepond.js') }}"></script>
@endpush
@push('scripts_at_bottom')
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
<script>
    $(document).ready(function () {
        $('#jobcity').select2({
            placeholder: "{{ ___('Select City') }}"
        });
        /* Get and Bind cities */
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
            },
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
        $('#category').change(function() {
                var categoryId = $(this).val();
                var subCategorySelect = $('#sub_category');
                var requestUrl = '{{route("admin.posts.get-sub-categories")}}'; // Direct URL

                // Log the URL to the console
                console.log('AJAX request URL:', requestUrl);
                subCategorySelect.empty();
                subCategorySelect.append('<option value="">Select Sub Category</option>');

                if (categoryId) {
                    $.ajax({
                        url: requestUrl,
                        type: 'GET',
                        dataType: 'json',
                        data: { category_id: categoryId },
                        success: function(data) {
                            subCategorySelect.html('<option value="">Select Sub Category</option>');
                        $.each(data.sub_categories, function(index, subCategory) {
                            subCategorySelect.append('<option value="' + subCategory.id + '">' + subCategory.name + '</option>');
                        });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error fetching sub-categories:', textStatus, errorThrown);
                            subCategorySelect.html('<option value="">Failed to load sub-categories</option>');
                        }
                    });
                }
            });
        // Trigger change event on page load if there's a pre-selected category
        if ($('#category').val()) {
            $('#category').trigger('change');
        }

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
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching custom fields:', textStatus, errorThrown);
                    $('#ResponseCustomFields').html('<p>Failed to load custom fields.</p>');
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
                process: '{{ route("admin.posts.upload") }}',
                revert: '{{ route("admin.posts.revert") }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }
        });

    });
</script>
@endpush
