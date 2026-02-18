@extends('layouts.student')

@section('title', 'Performance Analytics')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<style>
    /* ================= ANIMATIONS ================= */
    .animate-enter {
        animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }

    /* Card Hover Effect */
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="max-w-7xl mx-auto space-y-8">

    <div class="flex items-center justify-between animate-enter">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Performance Analytics</h1>
            <p class="text-gray-500 mt-1">Real-time analysis of your academic standing.</p>
        </div>
        <div class="hidden md:block">
            <span class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 shadow-sm">
                Last Updated: {{ now()->format('M d, Y') }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-enter stagger-1">
        
        {{-- Attendance Card --}}
        <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-500 font-medium">Attendance</h3>
                    <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="flex items-end gap-2">
                    <span class="text-4xl font-bold text-gray-900">{{ $performance['attendancePercentage'] }}%</span>
                    <span class="text-sm text-blue-600 font-medium mb-1">Present</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-4">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $performance['attendancePercentage'] }}%"></div>
                </div>
            </div>
        </div>

        {{-- Marks Card --}}
        <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-purple-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-500 font-medium">Academic Marks</h3>
                    <div class="p-2 bg-purple-100 rounded-lg text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
                <div class="flex items-end gap-2">
                    <span class="text-4xl font-bold text-gray-900">{{ $performance['marksPercentage'] }}%</span>
                    <span class="text-sm text-purple-600 font-medium mb-1">Avg. Score</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-4">
                    <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ $performance['marksPercentage'] }}%"></div>
                </div>
            </div>
        </div>

        {{-- Final Score Card --}}
        @php
            $scoreColor = match($performance['category']) {
                'Excellent' => 'emerald',
                'Good' => 'blue',
                'Average' => 'yellow',
                default => 'red'
            };
        @endphp
        <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-{{ $scoreColor }}-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-500 font-medium">Overall Performance</h3>
                    <div class="p-2 bg-{{ $scoreColor }}-100 rounded-lg text-{{ $scoreColor }}-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                </div>
                <div class="flex items-end gap-2">
                    <span class="text-4xl font-bold text-{{ $scoreColor }}-600">{{ $performance['performanceScore'] }}%</span>
                    <span class="text-sm text-{{ $scoreColor }}-600 font-bold mb-1 uppercase tracking-wide bg-{{ $scoreColor }}-50 px-2 py-0.5 rounded">
                        {{ $performance['category'] }}
                    </span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-4">
                    <div class="bg-{{ $scoreColor }}-500 h-1.5 rounded-full" style="width: {{ $performance['performanceScore'] }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 animate-enter stagger-2">
        
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Performance Meter</h3>
            <div id="performanceRadialChart" class="flex justify-center"></div>
            <p class="text-center text-sm text-gray-500 mt-[-20px]">Combined Score Efficiency</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Comparison: Attendance vs Academics</h3>
            <div id="comparisonBarChart"></div>
        </div>

    </div>

    <div class="animate-enter stagger-3">
        <div class="bg-gradient-to-r from-gray-50 to-white p-6 rounded-xl border-l-4 border-{{ $scoreColor }}-500 shadow-sm flex items-start gap-4">
            <div class="flex-shrink-0 p-3 bg-white rounded-full shadow-sm">
                <svg class="w-8 h-8 text-{{ $scoreColor }}-500 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">AI Performance Insight</h3>
                <div class="text-gray-600 leading-relaxed">
                    @if($performance['category'] === 'Excellent')
                        <span class="text-green-700 font-medium">Outstanding work!</span> You are maintaining a perfect balance between attendance and academics. Keep up this momentum to secure top ranks.
                    @elseif($performance['category'] === 'Good')
                        <span class="text-blue-700 font-medium">Great job!</span> Your performance is solid. Focusing slightly more on your weaker subjects could push you into the 'Excellent' category.
                    @elseif($performance['category'] === 'Average')
                        <span class="text-yellow-700 font-medium">Moderate Performance.</span> You are doing okay, but consistency is key. Try to improve your daily attendance or revise course material more often.
                    @else
                        <span class="text-red-700 font-medium">Attention Required.</span> Your score indicates you are falling behind. Please consult your faculty advisor to create a recovery plan immediately.
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Radial Bar Chart (Overall Score)
        var radialOptions = {
            series: [{{ $performance['performanceScore'] }}],
            chart: {
                height: 350,
                type: 'radialBar',
                fontFamily: 'inherit',
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -135,
                    endAngle: 135,
                    hollow: {
                        margin: 15,
                        size: '65%',
                        image: undefined,
                        imageWidth: 64,
                        imageHeight: 64,
                        imageClipped: false,
                    },
                    dataLabels: {
                        show: true,
                        name: { offsetY: -10, show: true, color: '#888', fontSize: '15px' },
                        value: { offsetY: 5, color: '#111', fontSize: '30px', show: true, fontWeight: 'bold' }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'horizontal',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#4f46e5'], // Indigo end color
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                }
            },
            stroke: { lineCap: 'round' },
            colors: ['#22c55e'], // Initial color (will blend)
            labels: ['Final Score'],
        };

        var radialChart = new ApexCharts(document.querySelector("#performanceRadialChart"), radialOptions);
        radialChart.render();


        // 2. Column Chart (Comparison)
        var barOptions = {
            series: [{
                name: 'Percentage',
                data: [{{ $performance['attendancePercentage'] }}, {{ $performance['marksPercentage'] }}]
            }],
            chart: {
                type: 'bar',
                height: 320,
                toolbar: { show: false },
                fontFamily: 'inherit'
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    columnWidth: '45%',
                    distributed: true, // Different colors per bar
                }
            },
            dataLabels: { enabled: false },
            legend: { show: false },
            colors: ['#3b82f6', '#a855f7'], // Blue for Attendance, Purple for Marks
            xaxis: {
                categories: ['Attendance', 'Marks'],
                labels: {
                    style: { fontSize: '14px', fontWeight: 600 }
                }
            },
            yaxis: {
                max: 100,
                tickAmount: 5,
            },
            grid: {
                borderColor: '#f1f1f1',
                padding: { top: 0, right: 0, bottom: 0, left: 10 }
            },
            tooltip: {
                y: { formatter: function (val) { return val + "%" } }
            }
        };

        var barChart = new ApexCharts(document.querySelector("#comparisonBarChart"), barOptions);
        barChart.render();
    });
</script>

@endsection