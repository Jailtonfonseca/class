@extends('admin.layouts.main')
@section('title', ___('Categories'))
@section('content')
    <div class="quick-card card">
        <div class="card-body">

            <div id="quickad-tbs" class="wrap">
                <div class="quickad-tbs-body">
                    <div class="row">
                        <div id="quickad-sidebar" class="col-sm-4">
                            <div id="quickad-categories-list" class="quickad-nav">
                                <div class="quickad-nav-item active quickad-category-item quickad-js-all-services" data-action="{{ route('admin.categories.getsubcategories', 0) }}">
                                    <div class="quickad-padding-vertical-xs">{{ ___('All Categories') }}</div>
                                </div>
                                <ul id="quickad-category-item-list" class="ui-sortable" data-action="{{ route('admin.categories.reorder') }}">

                                    @foreach ($categories as $category)

                                    <li class="quickad-nav-item quickad-category-item item-{{ $category->id }}" data-category-id="{{ $category->id }}" data-action="{{ route('admin.categories.getsubcategories', $category->id) }}">
                                        <div class="quickad-flexbox">
                                            <div class="quickad-flex-cell quickad-vertical-middle" style="width: 1%">
                                                <i class="icon-feather-menu quickad-js-handle quickad-icon-draghandle quickad-margin-right-sm quickad-cursor-move ui-sortable-handle" title="Reorder"></i>
                                            </div>
                                            <div class="quickad-flex-cell quickad-vertical-middle">
                                                <span class="displayed-value" style="display: inline;">
                                                    <i class="quickad-cat-icon quickad-margin-right-sm {{ $category->icon }}" title="{{ $category->name }}"></i>
                                                    <span class="quickad-cat-name">{{ $category->name }}</span>
                                                </span>
                                            </div>
                                            <div class="quickad-flex-cell quickad-vertical-middle" style="width: 1%;">
                                                <a href="#" class="icon-feather-edit quickad-margin-horizontal-xs quickad-edit-category" data-id="{{ $category->id }}"></a>
                                                <form method="post" class="edit-category-form" id="form-{{ $category->id }}" action="{{ route('admin.categories.update', $category->id) }}" style="display: none">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group mb-3">
                                                        <div class="mb-3">
                                                            <label class="form-label d-flex align-items-center" for="cat-name">
                                                                {{ ___('Name') }}
                                                                <div class="d-flex align-items-center translate-picker">
                                                                    <i class="fa fa-language"></i>
                                                                    <select class="custom-select custom-select-sm ml-1">
                                                                        <option value="default">{{ ___('Default') }}</option>
                                                                        @foreach ($admin_languages as $language)
                                                                            <option value="{{ $language->code }}">{{ $language->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </label>
                                                            <div class="translate-fields translate-fields-default">
                                                                <input class="form-control" id="cat-name" type="text" name="name" value="{{ $category->name }}">
                                                            </div>
                                                            @foreach ($admin_languages as $language)
                                                                <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                                                                    <input type="text" class="form-control" name="translations[{{ $language->code }}][name]" value="{{ !empty($category->translations()->{$language->code}->title)
                        ? $category->translations()->{$language->code}->title
                        : $category->name }}">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label d-flex align-items-center" for="cat-slug">
                                                                {{ ___('Slug') }}
                                                                <div class="d-flex align-items-center translate-picker">
                                                                    <i class="fa fa-language"></i>
                                                                    <select class="custom-select custom-select-sm ml-1">
                                                                        <option value="default">{{ ___('Default') }}</option>
                                                                        @foreach ($admin_languages as $language)
                                                                            <option value="{{ $language->code }}">{{ $language->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </label>

                                                            <div class="translate-fields translate-fields-default">
                                                                <input class="form-control" id="cat-slug" type="text" name="slug" value="{{ $category->slug }}">
                                                            </div>
                                                            @foreach ($admin_languages as $language)
                                                                <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                                                                    <input type="text" class="form-control" name="translations[{{ $language->code }}][slug]" value="{{ !empty($category->translations()->{$language->code}->slug)
                        ? $category->translations()->{$language->code}->slug
                        : $category->slug }}">
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="cat-icon">{{ ___('Category icon class') }}</label>
                                                            <input class="form-control" id="cat-icon" type="text" name="icon" placeholder="{{ ___('Add icon class') }}" value="{{ $category->icon }}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label" for="cat-picture">{{ ___('Picture') }}</label>
                                                            <input class="form-control" id="cat-picture" type="text" name="picture" value="{{ $category->picture }}">
                                                        </div>
                                                        <input class="form-control" id="cat-id" type="hidden" name="id" value="{{ $category->id }}" >
                                                    </div>
                                                    <div class="text-right">
                                                        <button type="submit" class="btn btn-primary confirm">{{ ___('Save') }}</button>
                                                        <button type="button" class="btn btn-default cancel-button">{{ ___('Cancel') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="quickad-flex-cell quickad-vertical-middle" style="width: 1%;">
                                                <a href="#" class="icon-feather-trash-2 text-danger quickad-js-delete"
                                                   data-action="{{ route('admin.categories.destroy', $category->id) }}"
                                                   title="{{ ___('Delete') }}"></a>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="form-group">
                                <button id="quickad-new-category" type="button" class="btn btn-lg btn-block btn-success-outline"><i class="icon-feather-plus"></i>{{ ___('New Category') }}
                                </button>
                            </div>
                            <form method="post" id="new-category-form" action="{{ route('admin.categories.store') }}" style="display: none">
                                @csrf
                                <div class="form-group mb-3">
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center" for="quickad-category-name">
                                            {{ ___('Name') }}
                                            <div class="d-flex align-items-center translate-picker">
                                                <i class="fa fa-language"></i>
                                                <select class="custom-select custom-select-sm ml-1">
                                                    <option value="default">{{ ___('Default') }}</option>
                                                    @foreach ($admin_languages as $language)
                                                        <option value="{{ $language->code }}">{{ $language->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </label>
                                        <div class="translate-fields translate-fields-default">
                                            <input class="form-control" id="quickad-category-name" type="text" name="name"/>
                                        </div>
                                        @foreach ($admin_languages as $language)
                                            <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                                                <input type="text" class="form-control" name="translations[{{ $language->code }}][name]">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label d-flex align-items-center" for="quickad-category-slug">
                                            {{ ___('Slug') }}
                                            <div class="d-flex align-items-center translate-picker">
                                                <i class="fa fa-language"></i>
                                                <select class="custom-select custom-select-sm ml-1">
                                                    <option value="default">{{ ___('Default') }}</option>
                                                    @foreach ($admin_languages as $language)
                                                        <option value="{{ $language->code }}">{{ $language->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </label>
                                        <div class="translate-fields translate-fields-default">
                                            <input class="form-control" id="quickad-category-slug" type="text" name="slug"/>
                                        </div>
                                        @foreach ($admin_languages as $language)
                                            <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                                                <input type="text" class="form-control" name="translations[{{ $language->code }}][slug]">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="quickad-category-name">{{ ___('Icon class for Category') }}</label>
                                        <input class="form-control" id="quickad-category-icon" type="text" name="icon" placeholder="fa fa-usd"/>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="quickad-category-name">{{ ___('Picture url') }}</label>
                                        <input class="form-control" id="quickad-category-icon" type="text" name="picture"/>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary confirm">{{ ___('Save') }}</button>
                                    <button type="button" id="cancel-button" class="btn btn-default">{{ ___('Cancel') }}</button>
                                </div>
                            </form>
                        </div>

                        <div id="quickad-services-wrapper" class="col-sm-8">
                            <div class="panel panel-default quickad-main">
                                <div class="panel-body">
                                    <h4 class="quickad-block-head">
                                        <span class="quickad-category-title">{{ ___('All Categories') }}</span>
                                        <button type="button" class="new-subcategory ladda-button pull-right btn btn-success" data-spinner-size="40" data-style="zoom-in">
                                            <span class="ladda-label"><i class="icon-feather-plus"></i>{{ ___('Add Sub-Category') }}</span>
                                        </button>
                                    </h4>
                                    <form method="post" id="new-subcategory-form" action="{{ route('admin.categories.subcategories.add') }}" style="display: none">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label d-flex align-items-center" for="new-subcategory-name">
                                                {{ ___('Name') }}
                                                <div class="d-flex align-items-center translate-picker">
                                                    <i class="fa fa-language"></i>
                                                    <select class="custom-select custom-select-sm ml-1">
                                                        <option value="default">{{ ___('Default') }}</option>
                                                        @foreach ($admin_languages as $language)
                                                            <option value="{{ $language->code }}">{{ $language->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </label>
                                            <div class="translate-fields translate-fields-default">
                                                <input class="form-control" id="new-subcategory-name" type="text" name="name"/>
                                            </div>
                                            @foreach ($admin_languages as $language)
                                                <div class="translate-fields translate-fields-{{ $language->code }}" style="display: none">
                                                    <input type="text" class="form-control" name="translations[{{ $language->code }}][name]">
                                                </div>
                                            @endforeach

                                            <input type="hidden" id="cat-id" name="id" value="0">
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary confirm">{{ ___('Save') }}</button>
                                            <button type="button" id="cancel-button" class="btn btn-default">{{ ___('Cancel') }}</button>
                                        </div>
                                    </form>

                                    <p class="quickad-margin-top-xlg no-result" style="display: none;">{{ ___('No services found. Please add services') }}</p>

                                    <div class="quickad-margin-top-xlg" id="ab-services-list">
                                        <div class="panel-group ui-sortable" id="services_list" role="tablist" aria-multiselectable="true" data-action="{{ route('admin.categories.subcategories.reorder') }}">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" id="quickad-delete" class="btn btn-danger ladda-button"
                                                data-action="{{ route('admin.categories.subcategories.delete') }}"
                                                data-spinner-size="40" data-style="zoom-in"><span class="ladda-label">
                                                <i class="icon-feather-trash"></i> {{ ___('Delete') }}</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="quickad-alert" class="quickad-alert"></div>
            </div>

        </div>
    </div>

    @push('scripts_at_top')
        <script type="text/javascript">
            "use strict";
            var QuickMenu = {"page": "category"};
        </script>
    @endpush
    @push('styles_vendor')
        <link rel="stylesheet" href="{{ asset('assets/admin/css/category.css') }}">
    @endpush
    @push('scripts_vendor')
        <script src="{{ asset('assets/admin/js/category.js') }}"></script>
        <script src="{{ asset('assets/admin/js/alert.js') }}"></script>
    @endpush
@endsection
