<div class="mb-2">
    <label class="block text-gray-600 mb-2" for="service">Category</label>
    <input type="text" class="form-input w-full" id="service" value="{{ $service['category'] }}" disabled>
</div>
<div class="mb-2">
    <label class="block text-gray-600 mb-2" for="service">Service</label>
    <input type="text" class="form-input w-full" id="service"
        value="[{{ $service['service'] }}]{{ $service['name'] }}" disabled>
</div>
