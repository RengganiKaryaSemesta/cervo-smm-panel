<main>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
        <x-widget-statistic color="warning" title="Total Like Success" total="{{ $total_like->Completed }}" progressbar="0"
            increase_from_last_month_in_percent="0" />
        <x-widget-statistic color="danger" title="Total Like Failed" total="{{ $total_like->Failed }}" progressbar="0"
            increase_from_last_month_in_percent="0" />
            <x-widget-statistic color="success" title="Total Comments Success" total="{{ $total_coment->Completed  }}" progressbar="0"
            increase_from_last_month_in_percent="0" />
             <x-widget-statistic color="danger" title="Total Comments Failed" total="{{ $total_coment->Failed }}" progressbar="0"
            increase_from_last_month_in_percent="0" />
            <x-widget-statistic color="primary" title="Total Following Success" total="{{ $total_follow->Completed  }}" progressbar="0"
            increase_from_last_month_in_percent="0" />
             <x-widget-statistic color="danger" title="Total Following Failed" total="{{ $total_follow->Failed  }}" progressbar="0"
            increase_from_last_month_in_percent="0" />
        {{-- <x-widget-progressbars title="Stok Terkini per Gudang" :items="$latest_stock" />
        <div class="card md:col-span-2">
            <div class="p-6">
                <h3 class="card-title">Grafik Tren Stok</h3>
                <canvas id="lineChart"></canvas>
            </div>
        </div> --}}
    </div>
    {{-- 
    <section class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-5">
        <div class="card">
            <div class="p-6">
                <h3 class="card-title">Stok Berdasarkan Gudang</h3>
                <canvas id="stokGudangChart"></canvas>
            </div>
        </div>
        <div class="card">
            <div class="p-6">
                <h3 class="card-title">Stok Berdasarkan Grade</h3>
                <canvas id="stokGradeChart"></canvas>
            </div>
        </div>
    </section>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mt-5">
        <div class="card md:col-span-2">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="card-title">Mutasi Stok Terbaru</h3>
                    <div>
                        <button data-fc-target="dropdown-pergerakan-stock" data-fc-type="dropdown" type="button"
                            data-fc-placement="bottom-end" class="fc-dropdown">
                            <i class="mdi mdi-dots-vertical text-xl"></i>
                        </button>

                        <div id="dropdown-pergerakan-stock"
                            class="hidden bg-white shadow rounded border dark:border-slate-700 fc-dropdown-open:translate-y-0 translate-y-3 origin-center transition-all duration-300 py-2 dark:bg-gray-800 fc-dropdown">
                            <a class="flex items-center py-1.5 px-5 text-sm transition-all duration-300 bg-transparent text-gray-800 dark:text-white hover:bg-stone-100 dark:hover:bg-slate-700 dark:hover:text-gray-200"
                                href="javascript:void(0)">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <div class="min-w-full inline-block align-middle">
                        <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead>
                                    <tr class="border-b-2 dark:border-gray-700">
                                        <th scope="col"
                                            class="px-4 py-4 text-start font-semibold text-gray-500 dark:text-gray-200">
                                            Tanggal</th>
                                        <th scope="col"
                                            class="px-4 py-4 text-start font-semibold text-gray-500 dark:text-gray-200">
                                            Material</th>
                                        <th scope="col"
                                            class="px-4 py-4 text-start font-semibold text-gray-500 dark:text-gray-200">
                                            Gudang Asal</th>
                                        <th scope="col"
                                            class="px-4 py-4 text-start font-semibold text-gray-500 dark:text-gray-200">
                                            Gudang Tujuan</th>
                                        <th scope="col"
                                            class="px-4 py-4 text-start font-semibold text-gray-500 dark:text-gray-200">
                                            Jumlah</th>
                                        <th scope="col"
                                            class="px-4 py-4 text-start font-semibold text-gray-500 dark:text-gray-200">
                                            Status</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr class="transition-all hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">27 Sept
                                            2024</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            C24202442 -
                                            Cengkeh</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">Gudang
                                            A
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">Gudang
                                            B
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">522 kg
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            <span
                                                class="text-xs text-white bg-success rounded-md px-1 py-0.5">Selesai</span>
                                        </td>
                                    </tr>
                                    <tr class="transition-all hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">07 Okt
                                            2024
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            C2420253 -
                                            Cengkeh</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">Gudang
                                            C
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">Gudang
                                            B
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">532 kg
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            <span
                                                class="text-xs text-white bg-danger rounded-md px-1 py-0.5">Batal</span>
                                        </td>
                                    </tr>

                                    <tr class="transition-all hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">25 Jul
                                            2024
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            C2453253 -
                                            Saos</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">Gudang
                                            B
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">Gudang
                                            A
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">52 kg
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            <span class="text-xs text-white bg-purple rounded-md px-1 py-0.5">Menunggu
                                                Persetujuan</span>
                                        </td>
                                    </tr>
                                    <tr class="transition-all hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">15 Jul
                                            2024
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            C2453213 -
                                            Tembakau</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">Gudang
                                            D
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">Gudang
                                            C
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">52 kg
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-gray-500 dark:text-gray-400">
                                            <span
                                                class="text-xs text-white bg-warning rounded-md px-1 py-0.5">Proses</span>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card md:col-span-2">
            <div class="p-6">
                <h3 class="card-title">Stok Mendekati Habis</h3>
                <canvas id="stokHabisChart"></canvas>
            </div>
        </div>
        <div class="card">
            <div class="p-6">
                <h3 class="card-title">Status Purchase Order</h3>
                <canvas id="pieChartSupplierA"></canvas>
            </div>
        </div>
        <div class="card md:col-span-2">
            <div class="p-6">
                <h3 class="card-title">Kinerja PO Supplier</h3>
                <canvas id="barChart"></canvas>
            </div>
        </div>
        <x-widget-progressbars title="Kinerja Suplier Berdasarkan Penyusutan" :items="$kinerja_supplier_berdasarkan_penyusutan" />
    </div>
    @script
        <script>
            const stokGudangLabels = @json($stokGudang->pluck('gudang'));
            const stokGudangValues = @json($stokGudang->pluck('total_stok'));

            // Data untuk stok berdasarkan grade
            const stokGradeLabels = @json($stokGrade->pluck('grade'));
            const stokGradeValues = @json($stokGrade->pluck('total_stok'));

            // Grafik Stok Berdasarkan Gudang
            const ctxGudang = document.getElementById('stokGudangChart').getContext('2d');
            new Chart(ctxGudang, {
                type: 'bar',
                data: {
                    labels: stokGudangLabels,
                    datasets: [{
                        label: 'Total Stok',
                        backgroundColor: '#42A5F5',
                        data: stokGudangValues
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Grafik Stok Berdasarkan Grade
            const ctxGrade = document.getElementById('stokGradeChart').getContext('2d');
            new Chart(ctxGrade, {
                type: 'bar',
                data: {
                    labels: stokGradeLabels,
                    datasets: [{
                        label: 'Total Stok',
                        backgroundColor: ['#66BB6A', '#FFA726', '#EF5350'],
                        data: stokGradeValues
                    }]
                },
                options: {
                    responsive: true,
                }
            });

            const ctx = document.getElementById('stokHabisChart').getContext('2d');
            const stokNames = @json($stock_almost_out->pluck('name'));
            const stokValues = @json($stock_almost_out->pluck('stock'));
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: stokNames,
                    datasets: [{
                        label: 'Stok Saat Ini',
                        backgroundColor: '#FF7043',
                        data: stokValues
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const ctxBar = document.getElementById('barChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Supplier A', 'Supplier B', 'Supplier C'],
                    datasets: [{
                            label: 'PO Selesai',
                            backgroundColor: '#4CAF50',
                            data: [20, 15, 25]
                        },
                        {
                            label: 'PO Terlambat',
                            backgroundColor: '#FFC107',
                            data: [5, 2, 7]
                        },
                        {
                            label: 'PO Gagal',
                            backgroundColor: '#F44336',
                            data: [1, 0, 3]
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Pie Chart for Supplier A
            const ctxPieSupplierA = document.getElementById('pieChartSupplierA').getContext('2d');
            new Chart(ctxPieSupplierA, {
                type: 'pie',
                data: {
                    labels: ['PO Selesai', 'PO Terlambat', 'PO Gagal'],
                    datasets: [{
                        backgroundColor: ['#4CAF50', '#FFC107', '#F44336'],
                        data: [20, 5, 1]
                    }]
                },
                options: {
                    responsive: true
                }
            });
            const ctxLine = document.getElementById('lineChart').getContext('2d');

            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: @json($grafikTren['dates']),
                    datasets: [{
                            label: 'Stok Masuk',
                            borderColor: '#4CAF50',
                            backgroundColor: 'rgba(76, 175, 80, 0.2)',
                            data: @json($grafikTren['stok_masuk']),
                            fill: true,
                            tension: 0.1
                        },
                        {
                            label: 'Stok Keluar',
                            borderColor: '#F44336',
                            backgroundColor: 'rgba(244, 67, 54, 0.2)',
                            data: @json($grafikTren['stok_keluar']),
                            fill: true,
                            tension: 0.1
                        },
                        {
                            label: 'Stok Akhir',
                            borderColor: '#FFC107',
                            backgroundColor: 'rgba(255, 193, 7, 0.2)',
                            data: @json($grafikTren['stok_akhir']),
                            fill: true,
                            tension: 0.1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Stok'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            }
                        }
                    }
                }
            });
        </script>
    @endscript --}}
</main>
