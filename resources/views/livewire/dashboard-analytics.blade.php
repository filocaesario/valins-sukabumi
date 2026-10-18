<div>
    <!-- Tambahkan CDN ApexCharts khusus di komponen ini -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        
        <!-- KANVAS GRAFIK 1: PIE CHART -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Distribusi Status Valins & Port</h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded-full">Real-time</span>
            </div>
            <div id="pieChart" class="flex justify-center"></div>
        </div>

        <!-- KANVAS GRAFIK 2: BAR CHART -->
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Tren Kendala per STO</h3>
                <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded-full">Monitoring</span>
            </div>
            <div id="barChart"></div>
        </div>

    </div>

    <!-- SCRIPT PENGGERAK GRAFIK -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            
            // Konfigurasi Pie Chart (Donut)
            var pieOptions = {
                series: {!! $pieData !!},
                labels: {!! $pieLabels !!},
                chart: { type: 'donut', height: 320 },
                colors: ['#10B981', '#F59E0B', '#EF4444', '#6366F1', '#8B5CF6'], // Hijau, Kuning, Merah, dsb
                plotOptions: {
                    pie: { donut: { size: '65%' } }
                },
                dataLabels: { enabled: false },
                legend: { position: 'bottom' }
            };
            var pieChart = new ApexCharts(document.querySelector("#pieChart"), pieOptions);
            pieChart.render();

            // Konfigurasi Bar Chart
            var barOptions = {
                series: [{ name: 'Total Kendala', data: {!! $stoData !!} }],
                chart: { type: 'bar', height: 320, toolbar: { show: false } },
                xaxis: { 
                    categories: {!! $stoLabels !!},
                    labels: { style: { fontWeight: 'bold' } }
                },
                colors: ['#DC2626'], // Merah khas Telkom
                plotOptions: {
                    bar: { borderRadius: 6, columnWidth: '40%', distributed: true }
                },
                dataLabels: { enabled: true, style: { colors: ['#fff'] } },
                legend: { show: false }
            };
            var barChart = new ApexCharts(document.querySelector("#barChart"), barOptions);
            barChart.render();
            
        });
    </script>
</div>
