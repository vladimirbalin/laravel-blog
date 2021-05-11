<div class="card">
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="title">Category title</label>
                <input
                    type="text"
                    class="form-control"
                    id="title"
                    name="title"
                    placeholder="Заголовка нет..."
                    value="{{ old('title', $category->title) }}">
            </div>
            <div class="form-group col-md-12">
                <label for="slug">Slug</label>
                <input
                    type="text"
                    class="form-control"
                    id="slug"
                    name="slug"
                    placeholder="Заголовка нет..."
                    value="{{ old('slug', $category->slug) }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="parent_id">Parent category</label>
                <select name="parent_id" id="parent_id" class="form-control">
                    @foreach($categoryList as $categoryItem)
                        @php /** @var \App\Models\BlogCategory $categoryItem */  @endphp
                        @if($categoryItem->id === $category->id) @else
                            <option
                                value="{{$categoryItem->id}}"
                                @if($categoryItem->id === $category->parent_id) selected @endif>
                                {{"$categoryItem->id. $categoryItem->title"}}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-12">
                <label for="description">Description</label>
                <textarea
                    name="description"
                    id="description"
                    class="form-control"
                    rows="3">{{ old('description', $category->description) }}</textarea>
            </div>

        </div>

    </div>
</div>
