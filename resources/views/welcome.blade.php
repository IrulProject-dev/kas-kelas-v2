<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kas Kelas - TRPL25A1</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:100,200,300,400,500,600,700,800,900" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        gray: {
                            900: '#030014',
                            800: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* === PERBAIKAN UTAMA DISINI === */
        /* Kita pasang background Aurora LANGSUNG di body */
        body {
            background-color: #020617; /* Dasar Hitam Kebiruan */
            background-image:
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;

            color: #e2e8f0;
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        /* Glassmorphism Card (Transparan agar Aurora terlihat tembus) */
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
        }

        .glass-nav {
            background: rgba(2, 6, 23, 0.7);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.3); }
    </style>
</head>
<body class="antialiased selection:bg-indigo-500 selection:text-white">

    <nav class="fixed top-0 w-full z-50 glass-nav transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <div class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-400">
                TRPL25A1
            </div>
            <div class="hidden md:flex space-x-8">
                <a href="#home" class="text-gray-300 hover:text-white transition-colors text-sm font-medium hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.5)]">Home</a>
                <a href="#excel-table" class="text-gray-300 hover:text-white transition-colors text-sm font-medium hover:drop-shadow-[0_0_8px_rgba(255,255,255,0.5)]">Data Kas</a>
            </div>
        </div>
    </nav>

    <div id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-indigo-500/10 rounded-full blur-[120px] -z-10 pointer-events-none"></div>

        <div class="container mx-auto px-6 text-center relative z-10">
            <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight drop-shadow-xl">
                Kas Kelas <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">TRPL25A1</span> <br> Jos Jis...
            </h1>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto mb-10 drop-shadow-md">
                Platform rekap Keuangan TRPL25A1. Transparansi, Akuntabilitas, dan Kemudahan dalam satu tempat.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#excel-table" class="px-8 py-4 rounded-full bg-white text-indigo-950 font-bold text-lg hover:bg-gray-200 transition-transform transform hover:scale-105 shadow-[0_0_25px_rgba(255,255,255,0.3)]">
                    Lihat Data Kas
                </a>
            </div>
        </div>
    </div>

    <div id="excel-table" class="container mx-auto px-4 py-20">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 drop-shadow-lg">Laporan Keuangan Real-time</h2>
            <p class="text-gray-400">Data pembayaran kas mingguan mahasiswa</p>
        </div>

        <!-- Desktop Table View -->
        <div class="hidden md:block w-full overflow-hidden rounded-2xl glass-card border border-white/10 relative">
            <!-- Scroll indicators -->
            <div class="absolute top-0 right-0 h-10 w-20 bg-gradient-to-l from-[#020617] to-transparent z-50 pointer-events-none"></div>
            <div class="absolute top-16 left-0 h-[calc(100%-4rem)] w-20 bg-gradient-to-r from-[#020617] to-transparent z-30 pointer-events-none shadow-[4px_0_15px_rgba(0,0,0,0.8)]"></div>
            <div class="absolute top-16 right-0 h-[calc(100%-4rem)] w-20 bg-gradient-to-l from-[#020617] to-transparent z-50 pointer-events-none"></div>

            <!-- Horizontal scroll buttons -->
            <div class="absolute top-1/2 left-2 transform -translate-y-1/2 z-50">
                <button onclick="scrollTable('left')" class="bg-[#020617]/80 hover:bg-[#0f172a] text-white p-2 rounded-full shadow-lg transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div class="absolute top-1/2 right-2 transform -translate-y-1/2 z-50">
                <button onclick="scrollTable('right')" class="bg-[#020617]/80 hover:bg-[#0f172a] text-white p-2 rounded-full shadow-lg transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div id="tableContainer" class="overflow-x-auto" style="max-height: 80vh;">
                <table class="w-full text-sm border-separate border-spacing-0">
                    <thead class="bg-[#020617] text-gray-200 uppercase sticky top-0 z-40 shadow-2xl">
                        <tr>
                            <th rowspan="2" class="p-4 border-b border-r border-white/10 sticky left-0 z-50 bg-[#020617] min-w-[60px] text-center shadow-[4px_0_15px_rgba(0,0,0,0.8)]">No</th>
                            <th rowspan="2" class="p-4 border-b border-r border-white/10 sticky left-[60px] z-50 bg-[#020617] min-w-[200px] text-left shadow-[4px_0_15px_rgba(0,0,0,0.8)]">Nama Lengkap</th>
                            <th rowspan="2" class="p-4 border-b border-r border-white/10 sticky left-[260px] z-50 bg-[#020617] min-w-[120px] text-center shadow-[4px_0_15px_rgba(0,0,0,0.8)]">NIM</th>

                            @foreach($months as $monthName => $weeksInMonth)
                                <th colspan="{{ count($weeksInMonth) }}" class="p-3 border-b border-r border-white/10 bg-indigo-950/40 text-center text-indigo-300 font-bold tracking-wider">
                                    {{ $monthName }}
                                </th>
                            @endforeach

                            <th rowspan="2" class="p-4 border-b border-l border-white/10 sticky right-0 z-50 bg-[#020617] min-w-[120px] text-center shadow-[-4px_0_15px_rgba(0,0,0,0.8)]">
                                Status
                            </th>
                        </tr>
                        <tr>
                            @foreach($months as $weeksInMonth)
                                @foreach($weeksInMonth as $week)
                                    <th class="p-2 border-b border-r border-white/10 bg-[#0f172a]/80 text-gray-400 text-[10px] text-center min-w-[70px]">
                                        {{ preg_replace('/ \([^)]+\)/', '', $week->name) }}
                                    </th>
                                @endforeach
                            @endforeach
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/5">
                        @foreach($members as $index => $member)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="p-4 border-r border-white/10 sticky left-0 z-30 bg-[#020617] group-hover:bg-[#0f172a] font-mono text-gray-500 text-center shadow-[4px_0_15px_rgba(0,0,0,0.8)] transition-colors">
                                {{ $index + 1 }}
                            </td>
                            <td class="p-4 border-r border-white/10 sticky left-[60px] z-30 bg-[#020617] group-hover:bg-[#0f172a] font-medium text-gray-200 shadow-[4px_0_15px_rgba(0,0,0,0.8)] whitespace-nowrap transition-colors">
                                {{ $member->name }}
                            </td>
                            <td class="p-4 border-r border-white/10 sticky left-[260px] z-30 bg-[#020617] group-hover:bg-[#0f172a] text-gray-500 text-center font-mono text-xs shadow-[4px_0_15px_rgba(0,0,0,0.8)] transition-colors">
                                {{ $member->nim }}
                            </td>

                            @foreach($months as $weeksInMonth)
                                @foreach($weeksInMonth as $week)
                                    @php
                                        $trx = $member->transaction_members->firstWhere('week_id', $week->id);
                                        $amount = $trx ? $trx->amount : 0;
                                        $target = $week->nominal;

                                        if ($amount >= $target) {
                                            $badgeClass = 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20';
                                        } elseif ($amount > 0) {
                                            $badgeClass = 'bg-amber-500/10 text-amber-400 border border-amber-500/20 hover:bg-amber-500/20';
                                        } else {
                                            $badgeClass = 'text-gray-600 border border-dashed border-gray-800 hover:border-gray-600';
                                        }
                                    @endphp

                                    <td class="p-2 border-r border-white/5 text-center align-middle">
                                        <div
                                            onclick="openInputModal({{ $member->id }}, {{ $week->id }}, {{ $amount }}, {{ $target }})"
                                            class="w-full h-8 flex items-center justify-center rounded cursor-pointer transition-all {{ $badgeClass }} min-h-[32px]">
                                            <span class="text-[10px] font-bold">
                                                @if($amount > 0)
                                                    {{ number_format($amount/1000, 0) }}k
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                    </td>
                                @endforeach
                            @endforeach

                            <td class="p-4 border-l border-white/10 sticky right-0 z-30 bg-[#020617] group-hover:bg-[#0f172a] text-center shadow-[-4px_0_15px_rgba(0,0,0,0.8)] transition-colors">
                                <span class="px-2 py-1 rounded bg-indigo-500/10 text-indigo-400 text-[10px] border border-indigo-500/20">
                                    Active
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4">
            @foreach($members as $index => $member)
            <div class="glass-card rounded-xl border border-white/10 p-4 bg-[#020617]/80">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-bold text-white text-lg">{{ $member->name }}</h3>
                        <p class="text-gray-400 text-sm">NIM: {{ $member->nim }}</p>
                    </div>
                    <span class="px-2 py-1 rounded bg-indigo-500/10 text-indigo-400 text-xs border border-indigo-500/20">
                        Active
                    </span>
                </div>

                <div class="space-y-2 max-h-60 overflow-y-auto">
                    @foreach($months as $monthName => $weeksInMonth)
                        <div class="border-t border-white/10 pt-2">
                            <h4 class="text-indigo-300 font-bold text-sm mb-1">{{ $monthName }}</h4>
                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                @foreach($weeksInMonth as $week)
                                    @php
                                        $trx = $member->transaction_members->firstWhere('week_id', $week->id);
                                        $amount = $trx ? $trx->amount : 0;
                                        $target = $week->nominal;

                                        if ($amount >= $target) {
                                            $badgeClass = 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20';
                                        } elseif ($amount > 0) {
                                            $badgeClass = 'bg-amber-500/10 text-amber-400 border border-amber-500/20';
                                        } else {
                                            $badgeClass = 'text-gray-600 border border-dashed border-gray-800';
                                        }
                                    @endphp
                                    <div
                                        onclick="openInputModal({{ $member->id }}, {{ $week->id }}, {{ $amount }}, {{ $target }})"
                                        class="p-2 rounded text-center cursor-pointer transition-all {{ $badgeClass }} min-h-[40px] flex items-center justify-center"
                                    >
                                        <div class="text-xs">
                                            <div class="font-bold">{{ preg_replace('/ \([^)]+\)/', '', $week->name) }}</div>
                                            <div class="font-semibold">
                                                @if($amount > 0)
                                                    {{ number_format($amount/1000, 0) }}k
                                                @else
                                                    -
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- <div id="features" class="container mx-auto px-6 py-20">
        <h2 class="text-4xl font-bold text-center text-white mb-16 drop-shadow-lg">Key Features</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="glass-card p-8 rounded-2xl text-center hover:bg-white/5 transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 bg-indigo-500/20 rounded-full flex items-center justify-center mx-auto mb-6 text-indigo-400 ring-1 ring-indigo-500/30 shadow-[0_0_15px_rgba(99,102,241,0.2)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Real-time Tracking</h3>
                <p class="text-gray-400 leading-relaxed">Pantau transaksi keuangan kelas secara langsung dengan update otomatis tanpa delay.</p>
            </div>

            <div class="glass-card p-8 rounded-2xl text-center hover:bg-white/5 transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 bg-emerald-500/20 rounded-full flex items-center justify-center mx-auto mb-6 text-emerald-400 ring-1 ring-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Secure & Transparent</h3>
                <p class="text-gray-400 leading-relaxed">Data tersimpan aman dan dapat diakses oleh seluruh anggota kelas untuk transparansi.</p>
            </div>

            <div class="glass-card p-8 rounded-2xl text-center hover:bg-white/5 transition-all duration-300 hover:-translate-y-2">
                <div class="w-16 h-16 bg-amber-500/20 rounded-full flex items-center justify-center mx-auto mb-6 text-amber-400 ring-1 ring-amber-500/30 shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-white mb-4">Detailed Reports</h3>
                <p class="text-gray-400 leading-relaxed">Laporan pemasukan dan pengeluaran yang detail untuk memudahkan rekapitulasi.</p>
            </div>
        </div>
    </div> --}}

    {{-- <div id="gallery" class="container mx-auto px-6 py-20">
        <h2 class="text-4xl font-bold text-center text-white mb-16 drop-shadow-lg">Gallery Kegiatan</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @for ($i = 1; $i <= 3; $i++)
            <div class="group relative overflow-hidden rounded-2xl glass-card aspect-video cursor-pointer">
                <img src="https://picsum.photos/seed/trpl{{ $i }}/600/400" alt="Gallery" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-70 group-hover:opacity-100">
                <div class="absolute inset-0 bg-gradient-to-t from-[#020617] via-transparent to-transparent opacity-60 group-hover:opacity-90 transition-opacity"></div>
                <div class="absolute bottom-0 left-0 p-6 translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                    <h4 class="text-white font-bold text-lg mb-1">Kegiatan Kelas {{ $i }}</h4>
                    <p class="text-gray-300 text-xs">Dokumentasi kebersamaan TRPL25A1</p>
                </div>
            </div>
            @endfor
        </div>
    </div> --}}

    <footer class="bg-[#020617]/80 backdrop-blur border-t border-white/10 pt-16 pb-8">
        <div class="container mx-auto px-6 text-center">
            <h3 class="text-2xl font-bold text-white mb-4">Kas Kelas TRPL25A1</h3>
            <p class="text-gray-400 mb-8">Teknologi Rekayasa Perangkat Lunak</p>
            <p class="text-gray-400 mb-8"><a href="/admin">login admin</a></p>
            <p class="text-gray-600 text-sm">© {{ date('Y') }} TRPL25A1. All rights reserved.</p>
        </div>
    </footer>

    <div id="paymentModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm hidden flex items-center justify-center z-[100] transition-opacity">
        <div class="glass-card rounded-2xl p-6 w-96 max-w-[90vw] transform transition-all scale-100 shadow-2xl border border-white/20">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Edit Payment</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-white text-xl">✕</button>
            </div>

            <form id="paymentForm">
                <input type="hidden" id="memberId" name="member_id">
                <input type="hidden" id="weekId" name="week_id">

                <div class="mb-4">
                    <label class="block text-gray-400 mb-2 text-xs uppercase tracking-wider font-semibold">Nama Mahasiswa</label>
                    <input type="text" id="memberName" class="w-full p-3 rounded-lg bg-white/5 border border-white/10 text-white focus:outline-none focus:border-indigo-500 font-medium" readonly placeholder="Nama Mahasiswa">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-gray-400 mb-2 text-xs uppercase tracking-wider font-semibold">Target</label>
                        <input type="text" id="targetAmount" class="w-full p-3 rounded-lg bg-white/5 border border-white/10 text-gray-300 font-mono text-sm" readonly>
                    </div>
                    <div>
                        <label class="block text-indigo-400 mb-2 text-xs uppercase tracking-wider font-semibold">Bayar (Rp)</label>
                        <input type="number" id="currentAmount" name="amount" class="w-full p-3 rounded-lg bg-[#0f172a] border border-indigo-500/50 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono text-sm shadow-[0_0_15px_rgba(99,102,241,0.2)]">
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-white/10">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg bg-white/5 text-gray-300 hover:bg-white/10 transition-colors text-sm font-medium">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-500 transition-colors shadow-lg shadow-indigo-500/30 text-sm font-bold">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openInputModal(memberId, weekId, currentAmount, targetAmount) {
            document.getElementById('memberId').value = memberId;
            document.getElementById('weekId').value = weekId;
            document.getElementById('currentAmount').value = currentAmount;

            // Logic ambil nama dari tabel untuk ditampilkan di modal
            // (Workaround tanpa kirim parameter nama)
            let memberName = '-';
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const idCell = row.querySelector('td:first-child');
                // Asumsi kolom pertama adalah nomor urut (visual),
                // jika memberId sesuai dengan urutan index blade:
                if (idCell && parseInt(idCell.innerText) === memberId) {
                   const nameCell = row.querySelector('td:nth-child(2)');
                   if(nameCell) memberName = nameCell.innerText.trim();
                }
            });
            // Update jika nama ditemukan (atau kosongkan agar tidak membingungkan)
             document.getElementById('memberName').value = memberName !== '-' ? memberName : 'Mahasiswa #' + memberId;

            document.getElementById('targetAmount').value = parseInt(targetAmount).toLocaleString('id-ID');
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        document.getElementById('paymentModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {
                member_id: formData.get('member_id'),
                week_id: formData.get('week_id'),
                amount: formData.get('amount')
            };

            fetch('/api/transactions/update-payment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    alert('Data berhasil disimpan!');
                    location.reload();
                } else {
                    alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error koneksi server');
            });
        });

        function scrollTable(direction) {
            const container = document.getElementById('tableContainer');
            const scrollAmount = 300; // Amount to scroll in pixels

            if (direction === 'left') {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            } else if (direction === 'right') {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            }
        }

        // Add touch swipe functionality for mobile
        let touchStartX = 0;
        let touchEndX = 0;

        document.addEventListener('touchstart', e => {
            touchStartX = e.changedTouches[0].screenX;
        }, false);

        document.addEventListener('touchend', e => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        }, false);

        function handleSwipe() {
            const minSwipeDistance = 50;
            const swipeDistance = touchStartX - touchEndX;

            if (Math.abs(swipeDistance) > minSwipeDistance) {
                if (swipeDistance > 0) {
                    // Swipe left - scroll table right
                    scrollTable('right');
                } else {
                    // Swipe right - scroll table left
                    scrollTable('left');
                }
            }
        }
    </script>
</body>
</html>
