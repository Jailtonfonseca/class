<div class="tab-pane" id="quick_post_setting">
    <form method="post" class="ajax_submit_form" data-action="{{ route('admin.settings.update') }}" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5>{{ ___('Post Settings') }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-2">

                    <div class="col-lg-6">
                        <label class="form-label" for="post_without_login">{{ ___('Post Without Login') }} *</label>
                        <select name="post_without_login" id="post_without_login" class="form-control">
                            <option value="1" {{ (@$settings->post_without_login == "1")? "selected" : "" }}>{{ ___('User can post without login') }}</option>
                            <option value="0" {{ (@$settings->post_without_login == "0")? "selected" : "" }}>{{ ___('User required login to post') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label" for="max_image_upload">{{ ___('Max Image upload') }} *</label>
                        <input type="number" name="max_image_upload" id="max_image_upload" class="form-control" value="{{ @$settings->max_image_upload }}">
                    </div>
                    <div class="col-lg-6">
                        {{quick_switch(___('Post Auto Approve'), 'post_auto_approve', @$settings->post_auto_approve == '1')}}
                    </div>
                    <div class="col-lg-6">
                        {{quick_switch(___('Premium Listing Option'), 'post_premium_listing', @$settings->post_premium_listing == '1')}}
                    </div>
                    <div class="col-lg-6">
                        {{quick_switch(___('Watermark'), 'post_watermark', @$settings->post_watermark == '1')}}
                    </div>
                    <div class="col-lg-6">
                        {{quick_switch(___('Description Editor'), 'post_desc_editor', @$settings->post_desc_editor == '1')}}
                    </div>
                    <div class="col-lg-6">
                        {{quick_switch(___('Address Field'), 'post_address_mode', @$settings->post_address_mode == '1')}}
                    </div>
                    <div class="col-lg-6">
                        {{quick_switch(___('Tags Field'), 'post_tags_mode', @$settings->post_tags_mode == '1')}}
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <input type="hidden" name="post_setting" value="1">
                <button name="submit" type="submit" class="btn btn-primary">{{ ___('Save Changes') }}</button>
            </div>
        </div>
    </form>
</div>
