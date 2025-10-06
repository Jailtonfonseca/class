<div class="tab-pane" id="quick_map">
    <form method="post" class="ajax_submit_form" data-action="{{ route('admin.settings.update') }}" data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5>{{ ___('Map Settings') }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 mb-2">

                    <div class="col-lg-6">
                        <label class="form-label" for="map_type">{{ ___('Map Type') }} *</label>
                        <select name="map_type" id="map_type" class="form-control">
                            <option value="google" {{ (@$settings->map_type == "google")? "selected" : "" }}>{{ ___('Google Map') }}</option>
                            <option value="openstreet" {{ (@$settings->map_type == "openstreet")? "selected" : "" }}>{{ ___('Openstreet Map') }}</option>
                        </select>
                    </div>
                    <div class="col-lg-12">
                        <label class="form-label" for="openstreet_access_token">{{ ___('OpenStreet Access Token') }} *</label>
                        <input type="text" id="openstreet_access_token" name="openstreet_access_token" class="form-control"
                               value="{{ @$settings->openstreet_access_token }}" required>
                        <small class="form-text"><a href="https://account.mapbox.com/access-tokens/" target="_blank">{{ ___('Get MapBox Access Token For OpenStreet Map') }}</a></small>
                    </div>

                    <div class="col-lg-12">
                        <label class="form-label" for="gmap_api_key">{{ ___('Google Map API Key') }} *</label>
                        <input type="text" id="gmap_api_key" name="gmap_api_key" class="form-control"
                               value="{{ @$settings->gmap_api_key }}" required>
                        <small class="form-text"><a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">{{ ___('Get API Key') }}</a></small>
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label" for="map_color">{{ ___('Google Map Color') }} *</label>
                        <input type="color" id="map_color" name="map_color" class="form-control"
                               value="{{ @$settings->map_color }}">
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label" for="home_map_zoom">{{ ___('Home Map Zoom') }} *</label>
                        <input type="text" id="home_map_zoom" name="home_map_zoom" class="form-control"
                               value="{{ @$settings->home_map_zoom }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label" for="home_map_latitude">{{ ___('Home Map Latitude') }} *</label>
                        <input type="text" id="home_map_latitude" name="home_map_latitude" class="form-control"
                               value="{{ @$settings->home_map_latitude }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label" for="home_map_longitude">{{ ___('Home Map Longitude') }} *</label>
                        <input type="text" id="home_map_longitude" name="home_map_longitude" class="form-control"
                               value="{{ @$settings->home_map_longitude }}">
                    </div>

                    <div class="col-lg-6">
                        <label class="form-label" for="contact_latitude">{{ ___('Contact Map Latitude') }} *</label>
                        <input type="text" id="contact_latitude" name="contact_latitude" class="form-control"
                               value="{{ @$settings->contact_latitude }}">
                    </div>
                    <div class="col-lg-6">
                        <label class="form-label" for="contact_longitude">{{ ___('Contact Map Longitude') }} *</label>
                        <input type="text" id="contact_longitude" name="contact_longitude" class="form-control"
                               value="{{ @$settings->contact_longitude }}">
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <input type="hidden" name="map_settings" value="1">
                <button name="submit" type="submit" class="btn btn-primary">{{ ___('Save Changes') }}</button>
            </div>
        </div>
    </form>
</div>
