<a href="{{ route('admin.services.others.index', ['code' => $smmProvider->code]) }}" class="btn bg-danger text-white">
    Back
</a>
<button type="submit" x-on:click="save" class="btn bg-primary">
    Process
</button>
