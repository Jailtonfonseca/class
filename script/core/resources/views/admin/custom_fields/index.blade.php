@extends('admin.layouts.main')
@section('title', ___('Custom Fields'))
@section('content')
    <div class="quick-card card">
        <div class="card-body">
            <div class="dataTables_wrapper">
                <table class="table table-striped" id="ajax_datatable" data-jsonfile="{{ route('admin.customfields.index') }}" data-order-dir="asc">
                    <thead>
                    <tr>
                        <th>{{ ___('ID') }}</th>
                        <th>{{ ___('Name') }}</th>
                        <th>{{ ___('Type') }}</th>
                        <th>{{ ___('Use as Filter') }}</th>
                        <th>{{ ___('Show in View') }}</th>
                        <th>{{ ___('Active') }}</th>
                        <th width="20" class="no-sort" data-priority="1"></th>
                        <th width="20" class="no-sort" data-priority="1">
                            <div class="checkbox">
                                <input type="checkbox" id="quick-checkbox-all">
                                <label for="quick-checkbox-all"><span class="checkbox-icon"></span></label>
                            </div>
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Site Action -->
    <div class="site-action">
        <div class="site-action-buttons">
            <button type="button" id="quick-delete-button" data-action="{{ route('admin.customfields.delete') }}"
                    class="btn btn-danger btn-floating animation-slide-bottom">
                <i class="icon icon-feather-trash-2" aria-hidden="true"></i>
            </button>
        </div>
        <button type="button" class="front-icon btn btn-primary btn-floating"
                data-url="{{ route('admin.customfields.create') }}" data-toggle="slidePanel">
            <i class="icon-feather-plus animation-scale-up" aria-hidden="true"></i>
        </button>
        <button type="button" class="back-icon btn btn-primary btn-floating">
            <i class="icon-feather-x animation-scale-up" aria-hidden="true"></i>
        </button>
    </div>
    @push('styles_vendor')
        <link rel="stylesheet" href="{{ asset('assets/admin/css/category.css') }}">
    @endpush
    @push('scripts_at_top')
        <script type='text/javascript'>
            var quickadL10n = {
                "csrf_token":"12232412",
                "custom_fields":"{{ $fields }}",
                "selector":{
                    "all_selected":"All Category",
                    "nothing_selected":"No category selected"
                },
                "saved":"Custom fields saved"
            };
        </script>
        <script type="text/javascript">
            "use strict";
            var QuickMenu = {"page": "custom_fields"};
        </script>
    @endpush
@endsection
