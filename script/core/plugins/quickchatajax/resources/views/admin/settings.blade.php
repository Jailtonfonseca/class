@extends('admin.layouts.main')
@section('title', ___('QuickChat - Settings'))
@section('content')
    <form method="post" class="ajax_submit_form" data-action="{{ route('admin.quickchatajax.index') }}"
          data-ajax-sidepanel="true">
        <div class="quick-card card">
            <div class="card-header">
                <h5>{{ ___('QuickChat') }}</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="alert d-flex align-items-center bg-label-success mb-3" role="alert">
                        <span class="badge badge-center rounded-pill bg-success border-label-success p-3 me-2"><i
                                class="fas fa-check"></i></span>
                        <div class="ps-1">
                            <p class="mb-0">{{___('QuickChat plugin is active and ready to use.')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button name="submit" type="submit" class="btn btn-primary">{{ ___('Save Changes') }}</button>
            </div>
        </div>
    </form>

    @push('scripts_at_top')
        <script id="quick-sidebar-menu-js-extra">
            "use strict";
            var QuickMenu = {"page": "plugins"};
        </script>
    @endpush
@endsection

