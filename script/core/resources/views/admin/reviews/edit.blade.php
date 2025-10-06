<div class="slidePanel-content">
    <header class="slidePanel-header">
        <div class="slidePanel-overlay-panel">
            <div class="slidePanel-heading">
                <h2> Edit Review</h2>
            </div>
            <div class="slidePanel-actions">
                <button id="post_sidePanel_data" class="btn btn-icon btn-primary" title="{{___('Save')}}">
                    <i class="icon-feather-check"></i>
                </button>
                <button class="btn btn-icon btn-default slidePanel-close" title="{{___('Close')}}">
                    <i class="icon-feather-x"></i>
                </button>
            </div>
        </div>
    </header>
    <div class="slidePanel-inner">
        <form action="{{ route('admin.reviews.update', $review->id) }}" method="post" enctype="multipart/form-data" id="sidePanel_form">
            @csrf
            {{-- <input type="hidden" name="post_id" value="{{$review->post_id}}"> --}}
            <div class="mb-3">
                {{quick_switch(___('Publish *'), 'publish', $review->publish == '1')}}
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Comment') }} *</label>
                <textarea class="form-control" name="comments" id="" cols="20" rows="10">{{$review->comments}}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ ___('Rating') }} *</label>
                <select class="form-control" name="rating" id="" >
                    <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>1</option>
                    <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>2</option>
                    <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>3</option>
                    <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>4</option>
                    <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>5</option>
                </select>
            </div>
            </div>
        </form>
    </div>
</div>