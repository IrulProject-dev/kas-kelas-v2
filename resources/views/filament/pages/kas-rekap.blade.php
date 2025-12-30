<x-filament-panels::page>
    {{-- Container Utama dengan Background Transparan & Border Tipis --}}
    <div class="w-full overflow-x-auto border border-white/10 rounded-xl shadow-[0_0_40px_rgba(0,0,0,0.3)] bg-white/5 backdrop-blur-sm" style="max-height: 80vh;">

        <table class="w-full text-sm border-separate border-spacing-0 relative">

            {{-- HEADER TABLE --}}
            <thead class="sticky top-0 z-30 text-gray-200 font-semibold h-12">
                <tr>
                    {{-- Sticky Column: NO --}}
                    <th rowspan="2" class="p-3 border-b border-r border-white/10 sticky left-0 z-50 bg-[#020617] w-12 text-center shadow-[4px_0_10px_rgba(0,0,0,0.2)]">
                        No
                    </th>

                    {{-- Sticky Column: NAMA --}}
                    <th rowspan="2" class="p-3 border-b border-r border-white/10 sticky left-12 z-50 bg-[#020617] w-64 text-left shadow-[4px_0_10px_rgba(0,0,0,0.2)]">
                        Mahasiswa
                    </th>

                    {{-- Sticky Column: NIM --}}
                    <th rowspan="2" class="p-3 border-b border-r border-white/10 sticky left-72 z-50 bg-[#020617] w-32 text-center text-gray-400 font-mono shadow-[10px_0_20px_rgba(0,0,0,0.5)]">
                        NIM
                    </th>

                    {{-- Header Bulan (Looping) --}}
                    @foreach($groupedWeeks as $month => $weeksInMonth)
                        <th colspan="{{ count($weeksInMonth) }}" class="py-2 px-4 border-b border-r border-white/10 bg-indigo-500/20 text-indigo-300 text-center uppercase tracking-wider text-xs font-bold">
                            {{ $month }}
                        </th>
                    @endforeach
                </tr>
                <tr>
                    {{-- Sub-Header: Minggu (M1, M2, dst) --}}
                    @foreach($groupedWeeks as $weeksInMonth)
                        @foreach($weeksInMonth as $idx => $week)
                            <th class="p-2 border-b border-r border-white/5 min-w-[60px] bg-white/5 text-gray-400 text-[10px] text-center font-mono">
                                M{{ $idx + 1 }}
                            </th>
                        @endforeach
                    @endforeach
                </tr>
            </thead>

            {{-- BODY TABLE --}}
            <tbody class="divide-y divide-white/5">
                @foreach($members as $index => $member)
                <tr class="group transition-colors hover:bg-white/5">

                    {{-- DATA: No (Sticky) --}}
                    <td class="p-3 border-r border-white/5 sticky left-0 z-20 bg-[#020617]/95 backdrop-blur text-center text-gray-500 font-mono text-xs">
                        {{ $index + 1 }}
                    </td>

                    {{-- DATA: Nama (Sticky) --}}
                    <td class="p-3 border-r border-white/5 sticky left-12 z-20 bg-[#020617]/95 backdrop-blur text-left whitespace-nowrap">
                        <span class="text-gray-200 font-medium tracking-wide group-hover:text-blue-300 transition-colors">
                            {{ $member->name }}
                        </span>
                    </td>

                    {{-- DATA: NIM (Sticky + Shadow) --}}
                    <td class="p-3 border-r border-white/5 sticky left-72 z-20 bg-[#020617]/95 backdrop-blur text-center text-gray-500 font-mono text-xs shadow-[10px_0_20px_rgba(0,0,0,0.3)]">
                        {{ $member->nim }}
                    </td>

                    {{-- DATA: Transaksi Minggu --}}
                    @foreach($groupedWeeks as $weeksInMonth)
                        @foreach($weeksInMonth as $week)
                            @php
                                $trx = $member->transaction_members->firstWhere('week_id', $week->id);
                                $amt = $trx ? $trx->amount : 0;
                                $target = $week->nominal;

                                // --- LOGIKA WARNA BARU ---
                                if ($amt >= $target) {
                                    // KONDISI 1: LUNAS -> BIRU (Neon Blue)
                                    // Background biru transparan, teks biru muda, border biru
                                    $cellClass = 'bg-blue-600/20 text-blue-400 border-blue-500/50 shadow-[0_0_10px_rgba(59,130,246,0.15)]';

                                } elseif ($amt > 0 && $amt < $target) {
                                    // KONDISI 2: KURANG BAYAR -> MERAH (Rose/Red)
                                    // Background merah transparan, teks merah
                                    $cellClass = 'bg-red-600/20 text-red-400 border-red-500/50';

                                } else {
                                    // KONDISI 3: BELUM BAYAR (0) -> KOSONG
                                    // Border putus-putus abu-abu
                                    $cellClass = 'bg-transparent text-gray-600 border-dashed border-gray-700 hover:border-gray-500';
                                }
                            @endphp

                            <td class="p-1 border-r border-white/5 align-middle text-center cursor-pointer transition-transform hover:scale-105"
                                wire:click="openInput({{ $member->id }}, {{ $week->id }}, {{ $amt }}, {{ $target }})"
                                title="Target: {{ number_format($target) }} | Terbayar: {{ number_format($amt) }}">

                                <div class="h-8 w-full rounded flex items-center justify-center text-[10px] font-bold border {{ $cellClass }} mx-auto" style="max-width: 90%;">
                                    @if($amt > 0)
                                        {{-- Format angka: 2k, 5k --}}
                                        {{ number_format($amt / 1000, 0) }}k
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                        @endforeach
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>
