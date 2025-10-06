jQuery(function($) {
    "use strict";
    var $no_result = $('#quickad-services-wrapper .no-result');
    // Remember user choice in the modal dialog.
    var update_staff_choice = null,
        $new_category_popover = $('#quickad-new-category'),
        $new_category_form = $('#new-category-form'),
        $new_category_name = $('#quickad-category-name'),
        $edit_category_popover = $('.quickad-edit-category'),
        $edit_category_form = $('.edit-category-form');


    $new_category_popover.popover({
        html: true,
        placement: 'bottom',
        content: $new_category_form.show().detach(),
        trigger: 'manual'
    }).on('click', function () {
        $(this).popover('toggle');
    }).on('shown.bs.popover', function () {
        // focus input
        $new_category_name.focus();
    }).on('hidden.bs.popover', function () {
        //clear input
        $new_category_name.val('');
    });

    // Cancel button.
    $new_category_form.on('click', '#cancel-button', function (e) {
        $new_category_popover.popover('hide');
    });

    // Save new category.
    $new_category_form.on('submit', function(e) {
        e.preventDefault();
        var $button = $(this),
            data = $(this).serialize(),
            action = $(this).attr("action");

        $button.find('.confirm').addClass('quick-loader').prop('disabled',true);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: action,
            type: 'POST',
            dataType: "json",
            data: data,
            success:   function (response) {
                $button.find('.confirm').removeClass('quick-loader').prop('disabled',false);
                if(response.success){
                    var $id = response.id;
                    var $name = response.name;
                    var $icon = response.icon;
                    var $slug = response.slug;
                    var $getsubcategories_route = response.getsubcategories_route;
                    var $delete_route = response.delete_route;
                    var appendtpl = '<li class="quickad-nav-item quickad-category-item" ' +
                        'data-category-id="' + $id + '"  data-action="'+$getsubcategories_route+'"> ' +
                        '<div class="quickad-flexbox">' +
                        '<div class="quickad-flex-cell quickad-vertical-middle" style="width: 1%">' +
                        '<i class="icon-feather-menu quickad-js-handle quickad-icon quickad-icon-draghandle quickad-margin-right-sm quickad-cursor-move ui-sortable-handle" title="Reorder"></i></div>' +
                        '<div class="quickad-flex-cell quickad-vertical-middle"> <span class="displayed-value" style="display: inline;"><i id="quickad-cat-icon" class="quickad-margin-right-sm fa ' + $icon + '"></i> ' + $name + ' </span>  </div> <div class="quickad-flex-cell quickad-vertical-middle" style="width: 1%"> <a href="#" class="icon-feather-trash-2 text-danger quickad-js-delete" data-action="'+$delete_route+'"></a> </div> </div> </li>';
                    $('#quickad-category-item-list').append(appendtpl);
                    $new_category_popover.popover('hide');
                    quick_alert(response.message);
                }else{
                    quick_alert(response.message, 'error');
                }
            }
        });
    });

    var $new_subcategory_popover = $('.new-subcategory'),
        $new_subcategory_form = $('#new-subcategory-form'),
        $new_subcategory_name = $('#new-subcategory-name');

    // Cancel button.
    $new_subcategory_form.on('click', '#cancel-button', function (e) {
        $new_subcategory_popover.popover('hide');
    });

    $new_subcategory_popover.popover({
        html: true,
        placement: 'bottom',
        content: $new_subcategory_form.show().detach(),
        trigger: 'manual'
    }).on('click', function () {
        $(this).popover('toggle');
    }).on('shown.bs.popover', function () {
        // focus input
        $new_subcategory_name.focus();
    }).on('hidden.bs.popover', function () {
        //clear input
        $new_subcategory_name.val('');
    });

    // Save new Sub-Category.
    $new_subcategory_form.on('submit', function(e) {
        e.preventDefault();

        var $button = $(this),
            data = $(this).serialize(),
            action = $(this).attr("action"),
            id = $('.quickad-category-item.active').data('category-id');
        $('#cat-id').val(id);
        $button.find('.confirm').addClass('quick-loader').prop('disabled',true);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: action,
            type: 'POST',
            dataType: "json",
            data: $(this).serialize(),
            success:   function (response) {
                $button.find('.confirm').removeClass('quick-loader').prop('disabled',false);
                if(response.success){
                    var $id = response.id;
                    var $name = response.name;
                    var appendtpl = '<div class="panel panel-default quickad-js-collapse" data-service-id="'+$id+'"> <div class="panel-heading" role="tab" id="s_'+$id+'"> <div class="row"> <div class="col-sm-8 col-xs-10"> <div class="quickad-flexbox"> <div class="quickad-flex-cell quickad-vertical-middle" style="width: 1%"> <i class="quickad-js-handle quickad-icon quickad-icon-draghandle quickad-margin-right-sm quickad-cursor-move ui-sortable-handle hide" title="Reorder"></i> </div> <div class="quickad-flex-cell quickad-vertical-middle"> <a role="button" class="panel-title collapsed quickad-js-service-title" data-toggle="collapse" data-parent="#services_list"  href="#service_'+$id+'" aria-expanded="false" aria-controls="service_'+$id+'">'+$name+' </a> </div> </div> </div> <div class="col-sm-4 col-xs-2"> <div class="quickad-flexbox"> <div class="quickad-flex-cell quickad-vertical-middle text-right" style="width: 10%"><div class="checkbox checkbox-success"> <input id="checkbox'+$id+'" type="checkbox" class="service-checker" value="'+$id+'"> <label for="checkbox'+$id+'"></label></div></div> </div> </div> </div> </div> <div id="service_'+$id+'" class="panel-collapse collapse" role="tabpanel"style="height: 0"> <div class="panel-body"> <form method="post" id="'+$id+'"> <div class="row"> <div class="col-md-12 col-sm-6"> <div class="form-group"> <label for="title_'+$id+'">Title</label> <input name="title" value="'+$name+'" id="title_'+$id+'" class="form-control" type="text"> <input name="id" value="'+$id+'" type="hidden"> </div> </div> </div> <div class="panel-footer"> <button type="button" class="btn btn-lg btn-success ladda-button ajax-subcat-edit" data-style="zoom-in" data-spinner-size="40" onclick="editSubCat('+$id+');"><span class="ladda-label">Save</span></button> <button class="btn btn-lg btn-default js-reset" type="reset">Reset </button> </div> </form> </div> </div> </div>';
                    $('#ab-services-list').append(appendtpl);
                    $new_subcategory_popover.popover('hide');
                    quick_alert(response.message);
                }else{
                    quick_alert(response.message, 'error');
                }
            }
        });
        return false;
    });

    // Edit Main-Category.
    $edit_category_popover.each(function () {
        var $this = $(this);
        $(this).popover({
            html: true,
            placement: 'auto',
            content: $('#form-'+$this.data('id')).show().detach(),
            trigger: 'focus',
        }).on('focus', function () {
            $(this).popover('toggle');
        });
    });

    // Cancel button.
    $edit_category_form.on('click', '.cancel-button', function (e) {
        $edit_category_popover.popover('hide');
    });
    $('body').on('click', function (e) {
        $edit_category_popover.each(function () {
            // hide any open popovers when the anywhere else in the body is clicked
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

    // Categories list delegated events.
    $(document)
        // On category item click.
        .on('click', '.quickad-category-item', function(e) {
            if ($(e.target).is('.quickad-js-handle')) return;
            $('#ab-services-list').html('<div class="quickad-loading"></div>');
            var $clicked = $(this);
            var post_type = $clicked.data('post_type');
            var ajaxurl = $clicked.data('action');
            $.get(ajaxurl, {post_type: post_type}, function(response) {
                if ( response != 0 ) {
                    $('.quickad-category-title').text($clicked.find('.displayed-value').text());
                    $('#ab-services-list').html(response);
                }else{
                    $('#ab-services-list').html('<h3>No sub category found.</h3>');
                }
                $('.quickad-category-item').not($clicked).removeClass('active');
                $clicked.addClass('active');
                if($clicked.data('category-id') != undefined){
                    $('.new-subcategory').show();
                }else{
                    $('.new-subcategory').hide();
                }
                makeSortable();
            });
        })

        // On edit category click.
        .on('click', '.quickad-js-edit', function(e) {
            // Keep category item click from being executed.
            e.stopPropagation();
            // Prevent navigating to '#'.
            e.preventDefault();
            var $this = $(this).closest('.quickad-category-item');
            $this.find('.displayed-value').hide();
            $this.find('#quickad-cat-icon').hide();
            $this.find('#edit-category-form').show();
        })

        // On blur save changes.
        .on('submit', '.edit-category-form', function(e) {
            e.preventDefault();
            var $this = $(this),
                data = $this.serialize(),
                action = $(this).attr("action");
            $this.find('.confirm').addClass('quick-loader').prop('disabled',true);
            $.post(action, data, function(response) {
                if (response.success) {
                    // Show modified category name.
                    var $item = $('.item-'+response.id);
                    $item.find('.quickad-cat-name').text(response.name);
                    $item.find('.quickad-cat-icon').attr('class','quickad-cat-icon quickad-margin-right-sm '+ response.icon);
                    $edit_category_popover.popover('hide');
                    quick_alert(response.message);
                }else{
                    quick_alert(response.message, 'error');
                }
                $this.find('.confirm').removeClass('quick-loader').prop('disabled',false);
            });
            return false;
        })

        // On blur save changes.
        .on('submit', '.edit-subcategory-form', function(e) {
            e.preventDefault();
            var $this = $(this),
                data = $this.serialize(),
                action = $(this).attr("action");
            $this.find('.confirm').addClass('quick-loader').prop('disabled',true);
            $.post(action, data, function(response) {
                if (response.success) {
                    quick_alert(response.message);
                }else{
                    quick_alert(response.message, 'error');
                }
                $this.find('.confirm').removeClass('quick-loader').prop('disabled',false);
            });
            return false;
        })

        .on('click', '#cancel-button', function(e) {
            e.stopPropagation();
            // Prevent navigating to '#'.
            e.preventDefault();
            var $item = $(this).closest('.quickad-category-item');
            $item.find('form').hide();
            $item.find('.displayed-value').show();
            $item.find('#quickad-cat-icon').show();
        })

        .on('click', '.iconpicker', function(e) {
            e.stopPropagation();
            // Prevent navigating to '#'.
            e.preventDefault();
        })
        // On press Enter save changes.
        .on('keypress', 'input', function (e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                $(this).blur();
            }
        })

        // On delete category click.
        .on('click', '.quickad-js-delete', function(e) {
            // Keep category item click from being executed.
            e.stopPropagation();
            // Prevent navigating to '#'.
            e.preventDefault();
            // Ask user if he is sure.
            if (confirm('Are you sure?')) {

                var $this = $(this),
                    $item = $(this).closest('.quickad-category-item'),
                    id = $item.data('category-id'),
                    action = $this.data('action');
                $this.addClass('quick-loader').prop('disabled',true);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: action,
                    type: 'delete',
                    data: {
                        "id": id,
                        "action": action
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Remove category item from DOM.
                            $('.quickad-js-all-services').trigger('click');
                            $item.remove();
                            quick_alert(response.message);
                        } else {
                            quick_alert(response.message,'error');
                        }
                        $this.removeClass('quick-loader').prop('disabled',false);
                    }
                });
            }
        })

        .on('click', 'input', function(e) {
            e.stopPropagation();
    });

    // Services list delegated events.
    $('#quickad-services-wrapper').on('click', '#quickad-delete', function(e) {
            if (confirm('Are you sure?')) {
                var $this = $(this),
                    $item = $(this).closest('.quickad-category-item'),
                    id = $item.data('category-id'),
                    action = $this.data('action');
                var $this = $(this),
                    action = $this.data('action'),
                    $for_delete = $('.service-checker:checked'),
                    services = [],
                    $panels = [];

                $for_delete.each(function(){
                    var panel = $(this).parents('.quickad-js-collapse');
                    $panels.push(panel);
                    services.push(this.value);
                });

                $this.addClass('quick-loader').prop('disabled',true);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: action,
                    type: 'POST',
                    data: {
                        "subCatids[]": services,
                        "action": action
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // Remove Sub category item from DOM.
                            $.each($panels.reverse(), function (index) {
                                $(this).delay(500 * index).fadeOut(200, function () {
                                    $(this).remove();
                                });
                            });
                            quick_alert(response.message);
                        } else {
                            quick_alert(response.message,'error');
                        }
                        $this.removeClass('quick-loader').prop('disabled',false);
                    }
                });
            }
        });


    var $category = $('#quickad-category-item-list');
    $category.sortable({
        axis   : 'y',
        handle : '.quickad-js-handle',
        update : function( event, ui ) {
            var data = [];
            $category.children('li').each(function() {
                var $this = $(this),
                    position = $this.data('category-id');
                data.push(position);
            });

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type : 'POST',
                url  : $category.data("action"),
                data : { position: data },
                success: function (response, textStatus, jqXHR) {
                    // Remove Ads item from DOM.
                    if(response.success) {
                        quickadAlert({success: ['Category Order Changed Successfully.']});
                    }else{
                        quickadAlert({error: ['Problem in Reorder, Please try again.']});
                    }
                }
            });
        }
    });

    function makeSortable() {
        if ($('.quickad-js-all-services').hasClass('active')) {
            var $services = $('#services_list'),
                fixHelper = function(e, ui) {
                    ui.children().each(function() {
                        $(this).width($(this).width());
                    });
                    return ui;
                };
            $services.sortable({
                helper : fixHelper,
                axis   : 'y',
                handle : '.quickad-js-handle',
                update : function( event, ui ) {
                    var data = [];
                    $services.children('div').each(function() {
                        data.push($(this).data('service-id'));
                    });
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type : 'POST',
                        url  : $services.data("action"),
                        data : { position: data },
                        success: function (response, textStatus, jqXHR) {
                            // Remove Ads item from DOM.
                            if(response.success) {
                                quickadAlert({success: ['Sub-Category Order Changed Successfully.']});
                            }else{
                                quickadAlert({error: ['Problem in Reorder, Please try again.']});
                            }
                        }
                    });
                }
            });
        } else {
            $('#services_list .quickad-js-handle').hide();
        }
    }
    makeSortable();
});

$('.iconpicker').on('change', function (e) {
    var $item = $(this).siblings('.categoryicon');
    $item.val(e.icon);
});
$(window).bind("load", function() {
    $('.quickad-category-item:first').trigger('click');
});
