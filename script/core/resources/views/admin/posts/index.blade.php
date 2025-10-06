@extends('admin.layouts.main')
@section('title', $page_title ?? ___('Listings'))
@section('header_buttons')
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary ms-2"><i class="icon-feather-plus me-2"></i> {{ ___('Add New') }}</a>
@endsection
@section('content')
    <div class="quick-card card">
        <div class="card-body">
            <div class="dataTables_wrapper">
                <table class="table table-striped" id="ajax_datatable" data-jsonfile="{{ route('admin.posts.index', ['status' => $status ?? '']) }}">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ ___('Details') }}</th>
                        <th>{{ ___('Created By') }}</th>
                        <th>{{ ___('Status') }}</th>
                        <th>{{ ___('Added date') }}</th>
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
            <button type="button" id="quick-delete-button" data-action="{{ route('admin.posts.delete') }}"
                    class="btn btn-danger btn-floating animation-slide-bottom">
                <i class="icon icon-feather-trash-2" aria-hidden="true"></i>
            </button>
        </div>
        <button class="front-icon btn btn-primary btn-floating"
        onclick="window.location = '{{ route('admin.posts.create') }}'">
         <i class="icon-feather-plus animation-scale-up" aria-hidden="true"></i>
     </button>
        <button type="button" class="back-icon btn btn-primary btn-floating">
            <i class="icon-feather-x animation-scale-up" aria-hidden="true"></i>
        </button>
    </div>
    @push('scripts_at_top')
        <script id="quick-sidebar-menu-js-extra">
            "use strict";
            var statusValue = "{{ $status }}";
            console.log('Status:', statusValue);
            // Set the QuickMenu page and subpage dynamically based on current status
            @php 
                $currentPage = 'posts';
                $currentSubpage ='';
                if (request()->segment(4) == 'active') {
                    $currentSubpage = 'approved_ads';
                } elseif(request()->segment(4) == 'pending'){
                    $currentSubpage = 'pending_ads';
                } elseif(request()->segment(4) == 'rejected'){
                    $currentSubpage = 'rejected_ads';
                } elseif(request()->segment(4) == 'expired'){
                    $currentSubpage = 'expired_ads';
                } else {
                    $currentSubpage = 'all-posts';
                }
            @endphp
            const QuickMenu = {"page": "{{$currentPage}}", "subpage": "{{$currentSubpage}}"};
            // console.log(QuickMenu.page);
        </script>
    @endpush
@endsection
