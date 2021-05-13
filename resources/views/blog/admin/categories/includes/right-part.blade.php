<div class="card">
    <div class="card-body">
        <button class="btn btn-primary" type="submit">Save category</button>
    </div>
</div>
@if($category->exists)
    <div class="card my-2">
        <div class="card-body">
            <p>
                ID: {{$category->id}}
            </p>
        </div>
        <div class="card-body">
            <p>
                Created at: {{$category->created_at}}
            </p>
        </div>
        <div class="card-body">
            <p>
                Updated at: {{$category->updated_at}}
            </p>
        </div>
        <div class="card-body">
            <p>
                Deleted at: {{$category->deleted_at}}
            </p>
        </div>
    </div>
@endif
