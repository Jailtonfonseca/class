@extends('admin.layouts.main')
@section('title', ___('Reviews'))
@section('content')
    <div class="quick-card card">
        <div class="card-body">
            <div class="dataTables_wrapper">
                <table class="table table-striped" id="ajax_datatable" data-jsonfile="{{ route('admin.reviews.index', ['reviewId' => $reviewId ?? '']) }}" data-order-dir="asc">
                    <thead>
                    <tr>
                        <th data-priority="1">#ID</th>
                        <th class="no-sort">{{ ___('Post') }}</th>
                        <th class="no-sort">{{ ___('Ratings') }}</th>
                        <th class="no-sort">{{ ___('Comments') }}</th>
                        <th class="no-sort">{{ ___('Status') }}</th>
                        <th width="20" class="no-sort" data-priority="1"></th>
                        <th class="no-sort w-px-20" data-priority="1">
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
            <button type="button" id="quick-delete-button" data-action="{{ route('admin.reviews.delete') }}"
                    class="btn btn-danger btn-floating animation-slide-bottom">
                <i class="icon icon-feather-trash-2" aria-hidden="true"></i>
            </button>
        </div>
        <button type="button" class="back-icon btn btn-primary btn-floating">
            <i class="icon-feather-x animation-scale-up" aria-hidden="true"></i>
        </button>
    </div>
    @push('scripts_at_top')
        <script type="text/javascript">
            "use strict";
            var QuickMenu = {"page": "posts", "subpage": "reviews"};
            var reviewValue = "{{ $reviewId }}";
            console.log('review:', reviewValue);
        </script>
    @endpush
@endsection
