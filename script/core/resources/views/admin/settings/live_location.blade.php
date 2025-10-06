<div class="tab-pane" id="quick_live_location">
    <form method="post" class="ajax_submit_form" data-action="{{ route('admin.settings.update') }}" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5>{{ ___('Live Location') }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-2">

                    <div class="col-lg-12">
                        <label class="form-label" for="location_track_icon">{{ ___('Live Location Track Icon') }} *</label>
                        <select name="location_track_icon" id="location_track_icon" class="form-control">
                            <option value="1" {{ (@$settings->location_track_icon == "1")? "selected" : "" }}>{{ ___('Show') }}</option>
                            <option value="0" {{ (@$settings->location_track_icon == "0")? "selected" : "" }}>{{ ___('Hide') }}</option>
                        </select>
                        <small class="form-text"><i class="fa fa-crosshairs"></i> {{ ___('This icon Show on Home search where field and create post location field.') }}</small>
                    </div>

                    <div class="col-lg-12">
                        <label class="form-label" for="auto_detect_location">{{ ___('Auto Detect Location') }} *</label>
                        <select name="auto_detect_location" id="auto_detect_location" class="form-control">
                            <option value="yes" {{ (@$settings->auto_detect_location == "yes")? "selected" : "" }}>{{ ___('On') }}</option>
                            <option value="no" {{ (@$settings->auto_detect_location == "no")? "selected" : "" }}>{{ ___('Off') }}</option>
                        </select>
                    </div>

                    <div class="col-lg-12">
                        <label class="form-label" for="live_location_api">{{ ___('Live Location Api') }} *</label>
                        <select name="live_location_api" id="live_location_api" class="form-control">
                            <option value="geo_ip_db" {{ (@$settings->live_location_api == "geo_ip_db")? "selected" : "" }}>{{ ___('Geo IP Database') }}</option>
                            <option value="ip_api" {{ (@$settings->live_location_api == "ip_api")? "selected" : "" }}>{{ ___('IP API') }}</option>
                            <option value="gps" {{ (@$settings->live_location_api == "gps")? "selected" : "" }}>{{ ___('Google GPS') }}</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <input type="hidden" name="live_location_settings" value="1">
                <button name="submit" type="submit" class="btn btn-primary">{{ ___('Save Changes') }}</button>
            </div>
        </div>
    </form>
</div>
