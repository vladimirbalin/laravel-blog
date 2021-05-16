<div class="card">
    <div class="card-body">
        <button class="btn btn-primary" type="submit">Save category</button>
    </div>
</div>
@if($item->exists)
    <div class="card my-2">
        <div class="card-body">
            <p>
                ID: {{$item->id}}
            </p>
        </div>
        <div class="card-body">
            <p>
                Created at: {{$item->created_at}}
            </p>
        </div>
        <div class="card-body">
            <p>
                Updated at: {{$item->updated_at}}
            </p>
        </div>
        <div class="card-body">
            <p>
                Deleted at: {{$item->deleted_at}}
            </p>
        </div>
    </div>
@endif
