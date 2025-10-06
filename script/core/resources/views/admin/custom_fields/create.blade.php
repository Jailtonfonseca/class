<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Create Custom Field') }}</h2>
            </div>
            <div class="slidePanel-actions">
                <button id="post_sidePanel_data" class="btn btn-icon btn-primary" title="{{___('Save')}}">
                    <i class="icon-feather-check"></i>
                </button>
                <button class="btn btn-icon btn-default slidePanel-close" title="{{___('Close')}}">
                    <i class="icon-feather-x"></i>
                </button>
            </div>
        </div>
    </header>
    <div class="slidePanel-inner">
        <div id="quickad-tbs" class="wrap">
            <div class="quickad-tbs-body">
                <form action="{{ route('admin.customfields.store') }}" method="post" enctype="multipart/form-data" id="sidePanel_form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">{{ ___('Icon Picture') }} *</label>
                        <input type="text" name="icon" class="form-control" value="" placeholder="{{ ___('Paste the icon image url') }}" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ ___('Field Type') }} *</label>
                        <select name="field_type" class="form-select" id="quickad-custom-type">
                            <option value="">{{ ___('Select Field Type') }}</option>
                            <option value="text-field">{{ ___('Text Field') }}</option>
                            <option value="textarea">{{ ___('Textarea') }}</option>
                            <option value="checkboxes">{{ ___('Checkboxs') }}</option>
                            <option value="radio-buttons">{{ ___('Radio Buttons') }}</option>
                            <option value="drop-down">{{ ___('Select box') }}</option>
                        </select>
                    </div>

                    <ul id="quickad-custom-fields" class="ui-sortable" style="position: relative">

                    </ul>

                    <p class="help-block">{{ ___('HTML allowed in textarea.') }}</p>

                    <div class="mb-2">
                        {{ quick_switch(___('Use as filter'), 'use_as_filter', false, ___('Use this field as filter in the advanced search. ')) }}
                    </div>
                    <div class="mb-2">
                        {{ quick_switch(___('Show in List or Grid view'), 'show_in_view', false, ___('Use this field as show in List or Grid view.')) }}
                    </div>
                    <div class="mb-2">
                        {{ quick_switch(___('Active'), 'active', true) }}
                    </div>

                </form>
                <ul id="quickad-templates" style="display:none">

                    <li data-type="text-field">
                        <div class="quickad-flexbox">
                            <div class="quickad-flex-cell" style="width: 100%">
                                @include('admin.custom_fields.inc.field', ['title' => ___('Text Field')])
                                @include('admin.custom_fields.inc.categories')
                            </div>
                        </div>
                        <hr>
                    </li>

                    <li data-type="textarea">
                        <div class="quickad-flexbox">
                            <div class="quickad-flex-cell" style="width: 100%">
                                @include('admin.custom_fields.inc.field', ['title' => ___('Text Area')])
                                @include('admin.custom_fields.inc.categories')
                            </div>
                        </div>
                        <hr>
                    </li>

                    <li data-type="checkboxes">
                        <div class="quickad-flexbox">
                            <div class="quickad-flex-cell" style="width: 100%">
                                @include('admin.custom_fields.inc.field', ['title' => ___('Checkbox Group')])

                                <ul class="quickad-items mb-3"></ul>
                                <button class="btn btn-sm btn-default mb-3" data-type="checkboxes-item">
                                    <i class="icon-feather-plus"></i> {{ ___('Checkbox') }} </button>

                                @include('admin.custom_fields.inc.categories')
                            </div>
                        </div>
                        <hr>
                    </li>

                    <li data-type="radio-buttons">
                        <div class="quickad-flexbox">
                            <div class="quickad-flex-cell" style="width: 100%">
                                @include('admin.custom_fields.inc.field', ['title' => ___('Radio Button Group')])

                                <ul class="quickad-items mb-3"></ul>
                                <button class="btn btn-sm btn-default mb-3" data-type="radio-buttons-item">
                                    <i class="icon-feather-plus"></i> {{ ___('Radio Button') }}
                                </button>

                                @include('admin.custom_fields.inc.categories')
                            </div>
                        </div>
                        <hr>
                    </li>

                    <li data-type="drop-down">
                        <div class="quickad-flexbox">
                            <div class="quickad-flex-cell" style="width: 100%">
                                @include('admin.custom_fields.inc.field', ['title' => ___('Select Drop Down')])

                                <ul class="quickad-items mb-3"></ul>
                                <button class="btn btn-sm btn-default mb-3" data-type="drop-down-item">
                                    <i class="icon-feather-plus"></i> {{ ___('Option') }}
                                </button>

                                @include('admin.custom_fields.inc.categories')
                            </div>
                        </div>
                        <hr>
                    </li>

                    <li data-type="checkboxes-item" class="mb-1">
                        @include('admin.custom_fields.inc.option')
                    </li>

                    <li data-type="radio-buttons-item" class="mb-1">
                        @include('admin.custom_fields.inc.option')
                    </li>

                    <li data-type="drop-down-item" class="mb-1">
                        @include('admin.custom_fields.inc.option')
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>


<script>
    var quickadL10n = {
        "csrf_token": "{{ csrf_token() }}",
        "selector":{
            "all_selected":"All Category",
            "nothing_selected":"No category selected"
        },
        "saved":"Custom fields saved"
    };
    var $fields = $("#quickad-custom-fields"),
        $cf_per_service = $('#quickad_custom_fields_per_service');
    /**
     * On "Add new field" on field type select.
     */
    /*$('#quickad-js-add-fields').on('click', 'button', function() {
        addField($(this).data('type'));
    });*/

    $('#quickad-custom-type').on('change', function() {
        addField($(this).val());
    });

    /**
     * On "Add new item" button click.
     */
    $fields.on('click', 'button', function() {
        addItem($(this).prev('ul'), $(this).data('type'));
    });

    /**
     * Delete checkbox/radio button/drop-down option.
     */
    $fields.on('click', '.quickad-option-delete', function(e) {
        e.preventDefault();
        var $item = $(this).closest('li');
        $item.fadeOut('fast', function() {
            $item.remove();
        });
    });
    /**
     * Add new field.
     *
     * @param type
     * @param id
     * @param label
     * @param required
     * @param services
     * @returns {*|jQuery}
     */
    function addField(type, id, label, required, services, translation) {
        var $new_field = $('ul#quickad-templates > li[data-type=' + type + ']').clone();
        // Set id, label and required.
        if (typeof id == 'undefined') {
            id = Math.floor((Math.random() * 100000) + 1);
        }
        if (typeof label == 'undefined') {
            label = '';
        }
        if (typeof required == 'undefined') {
            required = false;
        }
        if (typeof translation == 'undefined') {
            var transclass = "hide";
        }else{
            var transclass = "show";
        }
        $new_field
            .hide()
            .data('quickad-field-id', id)
            .find('.quickad-required').prop({
            id      : 'required-' + id,
            checked : required
        })
            .next('label').attr('for', 'required-' + id)
            .end().end()
            .find('.quickad-label').val(label)
            .end()
            .find('.quickad_language_translation').addClass(transclass).data('custom-field-id', id)
            .end()
            .find('.quickad-services-holder .subcategory input:checkbox').each(function (index) {
            if (services && $.inArray(this.value, services) > -1) {
                this.checked = true;
                var $holder = $(this).closest('.main-category');
                var service_checked = $holder.find('.quickad-js-check-sub-entity:checked').length;

                if( service_checked == $holder.find('.quickad-js-check-sub-entity').length)
                    $holder.find('.quickad-js-check-entity').prop('checked', true);
                else
                    $holder.find('.quickad-js-check-entity').prop('checked', false);
            }
            this.id = 'check-sub-' + id + '-' + index;
            $(this).next().attr('for', 'check-sub-' + id + '-' + index);
        }).end()
            .find('.quickad-services-holder .quickad-js-check-entity').each(function (index) {
            this.id = 'check-main-' + id + '-' + index;
            $(this).next().attr('for', 'check-main-' + id + '-' + index);
        }).end()
            .find('.quickad-services-holder .quickad-check-all-entities').each(function (index) {
            this.id = 'check-all-' + id + '-' + index;
            $(this).next().attr('for', 'check-all-' + id + '-' + index);
        });
        // Add new field to the list.
        $fields.html($new_field);
        $new_field.fadeIn('fast');
        // Make it sortable.

        $new_field.find('ul.quickad-items').sortable({
            axis   : 'y',
            handle : '.quickad-js-handle',
            update : function( event, ui ) {
                var data = [],
                    field_id = $(this).parents('li').data('quickad-field-id');
                $(this).children('li').each(function() {
                    var $this = $(this);
                    var position = $this.data('option_id');
                    data.push(position);
                });
                $.ajax({
                    type : 'POST',
                    url  : ajaxurl,
                    data : { action: 'quickad_update_custom_option_position',field_id: field_id, position: data},
                    success: function (response, textStatus, jqXHR) {
                        // Remove Ads item from DOM.
                        if(response != 0) {
                            quickadAlert({success: ['Custom Option Order Changed Successfully.']});
                        }else{
                            quickadAlert({error: ['Problem in Reorder, Please try again.']});
                        }
                    }
                });
            }
        });
        // Set focus to label field.
        $new_field.find('.quickad-label').focus();

        return $new_field;
    }

    /**
     * Add new checkbox/radio button/drop-down option.
     *
     * @param $ul
     * @param type
     * @param value
     * @return {*|jQuery}
     */
    function addItem($ul, type, id, value) {
        var $new_item = $('ul#quickad-templates > li[data-type=' + type + ']').clone();
        if (typeof value != 'undefined'){
            $new_item.find('input').val(value);
        }
        if (typeof id == 'undefined') {
            id = Math.floor((Math.random() * 100000) + 1);
        }
        $new_item.data('option_id', id);
        $new_item.find('.translate-fields input').each(function (){
            var name = $(this).attr('name');
            name = name.replace('{key}', id);
            $(this).attr('name',name);
        })

        $new_item.hide().appendTo($ul).fadeIn('fast').find('input').focus();

        return $new_item;
    }

    $cf_per_service.change(function() {
        if ($(this).val() == 1) {
            $('.quickad-services-holder').fadeIn('slow');
        } else {
            $('.quickad-services-holder').fadeOut('slow');
        }
    });

    function updateServiceButton($holder) {
        var service_checked = $holder.find('.quickad-js-check-sub-entity:checked').length;
        if (service_checked == 0) {
            $holder.find('.quickad-js-count').text(quickadL10n.selector.nothing_selected);
            $holder.find('.quickad-check-all-entities').prop('checked', false);
        }
        else if (service_checked == 1) {
            $holder.find('.quickad-js-count').text($holder.find('.quickad-js-check-sub-entity:checked').data('title'));
            $holder.find('.quickad-js-check-entity').prop('checked', (service_checked == $holder.find('.quickad-js-check-sub-entity').length));
        }
        else {
            if( service_checked == $holder.find('.quickad-js-check-sub-entity').length) {
                $holder.find('.quickad-check-all-entities').prop('checked', true);
                $holder.find('.quickad-js-count').text(quickadL10n.selector.all_selected);
            }
            else {
                $holder.find('.quickad-check-all-entities').prop('checked', false);
                $holder.find('.quickad-js-count').text(service_checked + '/' + $holder.find('.quickad-js-check-sub-entity').length);
            }
        }
    }

    $(document).on('click', '.quickad-check-all-entities', function () {
        var $holder = $(this).parents('.quickad-services-holder');
        $holder.find('.quickad-js-check-entity').prop('checked', $(this).prop('checked'));
        $holder.find('.quickad-js-check-sub-entity').prop('checked', $(this).prop('checked'));
        updateServiceButton($holder);
    });

    $(document).on('click', '.quickad-services-holder ul.dropdown-menu li div.checkbox', function (e) {
        e.stopPropagation();
    });

    $(document).on('click', '.quickad-js-check-entity', function (e) {
        e.stopPropagation();
        $(this).closest('li').find('.quickad-js-check-sub-entity').prop('checked', $(this).prop('checked'));
        var $holder = $(this).parents('.quickad-services-holder');
        console.log($holder);
        updateServiceButton($holder);
        e.stopPropagation();
    });

    $(document).on('click', '.quickad-js-check-sub-entity', function (e) {
        var $holder = $(this).closest('.main-category');
        var service_checked = $holder.find('.quickad-js-check-sub-entity:checked').length;

        if( service_checked == $holder.find('.quickad-js-check-sub-entity').length)
            $holder.find('.quickad-js-check-entity').prop('checked', true);
        else
            $holder.find('.quickad-js-check-entity').prop('checked', false);

        updateServiceButton($(this).parents('.quickad-services-holder'));
        e.stopPropagation();
    });
</script>
