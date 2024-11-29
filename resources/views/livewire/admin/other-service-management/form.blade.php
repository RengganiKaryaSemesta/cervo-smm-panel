<section>
    <div class="grid md:grid-cols-3 mb-5 gap-2">
        <x-widget-statistic color="info" title="Saldo" total="{{ $balance->balance }}" progressbar="0"
            increase_from_last_month_in_percent="0" />
    </div>
    @livewire('admin.other-service-management.forms.' . $service['type']->getComponent(), ['service' => $service, 'smmProvider' => $smmProvider], key($service['service']))
</section>
