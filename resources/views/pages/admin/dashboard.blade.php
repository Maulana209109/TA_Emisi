@extends('layouts.admin')

@section('content')
<!-- Header Stats -->
<div class="relative bg-pink-600 md:pt- pb-32 pt-12">
    <div class="px-4 md:px-10 mx-auto w-full">
        <div>
            <!-- Card stats -->
            <div class="flex flex-wrap">
                <!-- Card 1: Total Entries -->
                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                        Total Konsumsi
                                    </h5>
                                    <span class="font-semibold text-xl text-blueGray-700">
                                        {{ number_format($totalEntries) }}
                                    </span>
                                </div>
                                <div class="relative w-auto pl-4 flex-initial">
                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                                        <i class="far fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-blueGray-400 mt-4">
                                <span class="whitespace-nowrap">Total input user</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Total Users -->
                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                        Total Users
                                    </h5>
                                    <span class="font-semibold text-xl text-blueGray-700">
                                        {{ number_format($totalUsers) }}
                                    </span>
                                </div>
                                <div class="relative w-auto pl-4 flex-initial">
                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-orange-500">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-blueGray-400 mt-4">
                                <span class="text-emerald-500 mr-2">
                                    +{{ $newUsersThisMonth }}
                                </span>
                                <span class="whitespace-nowrap">Bulan ini</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Total Factors -->
                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                        Faktor Emisi
                                    </h5>
                                    <span class="font-semibold text-xl text-blueGray-700">
                                        {{ number_format($totalFactors) }}
                                    </span>
                                </div>
                                <div class="relative w-auto pl-4 flex-initial">
                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-pink-500">
                                        <i class="fas fa-leaf"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-blueGray-400 mt-4">
                                <span class="whitespace-nowrap">Total tersedia</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Total Categories -->
                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                        <div class="flex-auto p-4">
                            <div class="flex flex-wrap">
                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                        Kategori
                                    </h5>
                                    <span class="font-semibold text-xl text-blueGray-700">
                                        {{ number_format($totalCategories) }}
                                    </span>
                                </div>
                                <div class="relative w-auto pl-4 flex-initial">
                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-lightBlue-500">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-blueGray-400 mt-4">
                                <span class="whitespace-nowrap">Total kategori</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content -->
<div class="px-4 md:px-10 mx-auto w-full -m-24">
    <div class="flex flex-wrap">
        <!-- Line Chart -->
        <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4 ">
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-blueGray-700">
                <div class="rounded-t mb-0 px-4 py-3 bg-white">
                    <div class="flex flex-wrap items-center ">
                        <div class="relative w-full max-w-full flex-grow flex-1">
                            <h6 class="uppercase text-black mb-1 text-xs font-semibold">
                                Tren Tahun Ini
                            </h6>
                            <h2 class="text-black text-xl font-semibold">
                                Input Konsumsi per Bulan
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="p-4 flex-auto bg-white">
                    <div class="relative h-350-px">
                        <canvas id="line-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="w-full xl:w-4/12 px-4">
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="rounded-t mb-0 px-4 py-3 bg-transparent">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full max-w-full flex-grow flex-1">
                            <h6 class="uppercase text-blueGray-400 mb-1 text-xs font-semibold">
                                Pertumbuhan
                            </h6>
                            <h2 class="text-blueGray-700 text-xl font-semibold">
                                Registrasi User Baru
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="p-4 flex-auto">
                    <div class="relative h-350-px">
                        <canvas id="bar-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables -->
    <div class="flex flex-wrap mt-4">
        <!-- Top Users Table -->
        <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-blueGray-700">
                                Top 5 User Paling Aktif
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-x-auto">
                    <table class="items-center w-full bg-transparent border-collapse">
                        <thead>
                            <tr>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Nama User
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Email
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Total Input
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topUsers as $user)
                            <tr>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ $user->name }}
                                </td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ $user->email }}
                                </td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    <i class="fas fa-arrow-up text-emerald-500 mr-2"></i>
                                    {{ $user->consumption_entries_count }} entries
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">
                                    Belum ada data
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Categories Stats Table -->
        <div class="w-full xl:w-4/12 px-4">
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-blueGray-700">
                                Sebaran Kategori Emisi
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-x-auto">
                    <table class="items-center w-full bg-transparent border-collapse">
                        <thead>
                            <tr>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Kategori
                                </th>
                                <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                    Jumlah Faktor
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $colors = ['red', 'emerald', 'purple', 'lightBlue', 'orange'];
                            @endphp
                            @forelse($categoriesStats as $index => $category)
                            <tr>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    {{ $category->category_name }}
                                </td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                    <div class="flex items-center">
                                        <span class="mr-2">{{ $category->factors_count }}</span>
                                        <div class="relative w-full">
                                            <div class="overflow-hidden h-2 text-xs flex rounded bg-{{ $colors[$index % 5] }}-200">
                                                <div style="width: {{ min(($category->factors_count / max($categoriesStats->max('factors_count'), 1)) * 100, 100) }}%" 
                                                     class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-{{ $colors[$index % 5] }}-500">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">
                                    Belum ada data
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

<script>
    Chart.defaults.global.defaultFontColor = "#e5e7eb";
    Chart.defaults.global.defaultFontFamily = "Arial, sans-serif";

    // Line Chart - Input Konsumsi per Bulan
    var entriesData = @json($entriesData);

    var lineConfig = {
        type: "line",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Oct", "Nov", "Des"],
            datasets: [{
                label: new Date().getFullYear(),
                backgroundColor: "rgba(99, 102, 241, 0.2)",
                borderColor: "#6366f1",
                pointBackgroundColor: "#6366f1",
                pointBorderColor: "#111827",
                data: entriesData,
                fill: true,
            }],
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                position: "bottom",
                labels: {
                    fontColor: "#e5e7eb",
                },
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: "#9ca3af",
                    },
                    gridLines: {
                        color: "rgba(255,255,255,0.05)",
                        drawBorder: false,
                    },
                }],
                yAxes: [{
                    ticks: {
                        fontColor: "#9ca3af",
                    },
                    gridLines: {
                        color: "rgba(255,255,255,0.08)",
                        borderDash: [4],
                        drawBorder: false,
                    },
                }],
            },
        },
    };

    var lineCtx = document.getElementById("line-chart").getContext("2d");
    new Chart(lineCtx, lineConfig);


    // Bar Chart - Registrasi User Baru
    var usersData = @json($usersData);

    var barConfig = {
        type: "bar",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Oct", "Nov", "Des"],
            datasets: [{
                label: new Date().getFullYear(),
                backgroundColor: "#ec4899",
                borderColor: "#ec4899",
                data: usersData,
                barThickness: 10,
            }],
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                position: "bottom",
                labels: {
                    fontColor: "#e5e7eb",
                },
            },
            scales: {
                xAxes: [{
                    ticks: {
                        fontColor: "#9ca3af",
                    },
                    gridLines: {
                        display: false,
                    },
                }],
                yAxes: [{
                    ticks: {
                        fontColor: "#9ca3af",
                    },
                    gridLines: {
                        color: "rgba(255,255,255,0.08)",
                        borderDash: [4],
                        drawBorder: false,
                    },
                }],
            },
        },
    };

    var barCtx = document.getElementById("bar-chart").getContext("2d");
    new Chart(barCtx, barConfig);
</script>

@endpush
@endsection