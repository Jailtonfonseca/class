<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Add District') }} - <span style="white-space: nowrap;">{{$region->name}}</h2>
            </div>
            <div class="slidePanel-actions">
                <button id="post_sidePanel_data" class="btn btn-icon btn-primary" title="{{ ___('Save') }}">
                    <i class="icon-feather-check"></i>
                </button>
                <button class="btn btn-default btn-icon slidePanel-close" title="{{ ___('Close') }}">
                    <i class="icon-feather-x"></i>
                </button>
            </div>
        </div>
    </header>
    <div class="slidePanel-inner">
        <form action="{{ route('admin.districts.store') }}" method="post" id="sidePanel_form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="country_code" value="{{ $countryCode }}">
            <input type="hidden" name="subadmin1_code" value="{{ $districtCode }}">
            <div class="mb-3">
                <label class="form-label">{{ ___('Name') }} : <span class="red">*</span></label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                {{quick_switch(___('Active'), 'active', 'active')}}
            </div>
        </form>
    </div>
</div>
