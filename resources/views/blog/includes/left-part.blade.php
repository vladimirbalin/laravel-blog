<div class="card">
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="title">*Category title</label>
                <input
                    type="text"
                    class="form-control"
                    id="title"
                    name="title"
                    placeholder="Please enter the title"
                    value="{{ old('title', $item->title) }}">
            </div>
            <div class="form-group col-md-12">
                <label for="slug">Slug/Unique Identifier</label>
                <input
                    type="text"
                    class="form-control"
                    id="slug"
                    name="slug"
                    placeholder="Please enter the slug identifier"
                    value="{{ old('slug', $item->slug) }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="parent_id">*Parent category</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    @foreach($dropDownListCategories as $categoryItem)
                        @php /** @var \App\Models\BlogCategory $categoryItem */  @endphp
                        @if($categoryItem->id === $item->id) @else
                            <option
                                value="{{$categoryItem->id}}"
                                @if($categoryItem->id === $item->parent_id) selected @endif>
                                {{"$categoryItem->select_title"}}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-12">
                <label for="description">*Description</label>
                <textarea
                    name="description"
                    id="description"
                    class="form-control"
                    rows="3">{{ old('description', $item->description) }}</textarea>
            </div>
        </div>
    </div>
</div>
