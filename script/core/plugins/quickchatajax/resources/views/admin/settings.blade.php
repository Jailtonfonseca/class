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
                    @if($code)
                        <div class="alert d-flex align-items-center bg-label-info mb-3" role="alert">
                        <span class="badge badge-center rounded-pill bg-info border-label-info p-3 me-2"><i
                                class="fas fa-bell"></i></span>
                            <div class="ps-1">
                                <p class="mb-0">{{___('Purchase code is verified.')}}</p>
                                <small>{{$code}}</small>
                            </div>
                        </div>
                    @else
                        <div class="alert d-flex align-items-center bg-label-warning mb-3" role="alert">
                        <span class="badge badge-center rounded-pill bg-warning border-label-warning p-3 me-2"><i
                                class="fas fa-bell"></i></span>
                            <div class="ps-1">
                                {{___('Enter QuickChat - Plugin purchase code below to enable the chat features.')}}
                            </div>
                        </div>
                    @endif
                    <label class="form-label">{{___("Purchase Code")}}</label>
                    <div>
                        <input name="quickchat_purchase_code" type="text" class="form-control" value="">

                        <small class="form-text">{{___("Don't have a purchase code?")}} <a
                                href="https://codecanyon.net/item/quickchat-plugin-for-quickcms/34865712"
                                target="_blank">{{___('purchase now')}} <i class="far fa-external-link"></i></a></small>
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

