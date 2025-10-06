$(document).ready(function(){
    // -------------------------------------------------------------
    //  Intialize orakuploader
    // -------------------------------------------------------------
    $('#item_screen').orakuploader({
        site_url :  siteurl,
        orakuploader_path : 'plugins/orakuploader/',
        orakuploader_main_path : 'storage/products',
        orakuploader_thumbnail_path : 'storage/products/thumb',
        orakuploader_add_image : siteurl+'plugins/orakuploader/images/add.svg',
        orakuploader_watermark : watermark_image,
        orakuploader_add_label : lang_upload_images,
        orakuploader_use_main : true,
        orakuploader_use_sortable : true,
        orakuploader_use_dragndrop : true,
        orakuploader_use_rotation: true,
        orakuploader_resize_to : 800,
        orakuploader_thumbnail_size  : 250,
        orakuploader_maximum_uploads : max_image_upload,
        orakuploader_max_exceeded : max_image_upload,
        orakuploader_hide_on_exceed : true,
        orakuploader_main_changed    : function (filename) {
            $("#mainlabel-images").remove();
            $("div").find("[filename='" + filename + "']").append("<div id='mainlabel-images' class='maintext'>Main Image</div>");
        },
        orakuploader_max_exceeded : function() {
            alert("You exceeded the max. limit of "+max_image_upload+" images.");
        }
    });
});