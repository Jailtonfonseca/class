<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2>{{ ___('Edit District') }} - <span style="white-space: nowrap;">{{ $district->name }}</span></h2>
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
        <form action="{{ route('admin.districts.update',$district->code) }}" method="post" id="sidePanel_form" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="hidden" name="country_code" value="{{ $district->country_code }}">
            <input type="hidden" name="district_code" value="{{ $district->code }}">
            <div class="mb-3">
                <label class="form-label">{{ ___('Name') }} : <span class="red">*</span></label>
                <input type="text" name="name" class="form-control" value="{{$district->name}}" required>
            </div>
            <div class="mb-3">
                {{quick_switch(___('Active'), 'active', $district->active == '1')}}
            </div>
        </form>
    </div>
</div>
