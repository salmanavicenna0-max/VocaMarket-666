            <!-- Tab Atur Pembayaran -->
            <div id="tab-aturpembayaran" class="bg-white rounded-xl shadow-sm border border-gray-200 tab-content hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Atur Pembayaran (Admin)</h2>
                        <p class="text-gray-500 text-sm mt-1">Kelola metode pembayaran yang tersedia untuk pembeli.</p>
                    </div>
                    <button onclick="document.getElementById('modalAddPaymentMethod').classList.remove('hidden')" class="bg-primary hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg transition shadow-sm flex items-center gap-2">
                        <i class="ph-bold ph-plus"></i> Tambah Metode
                    </button>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="border-b border-gray-200 text-gray-500 bg-gray-50">
                                    <th class="py-3 px-4 font-semibold rounded-tl-lg">Nama Bank/E-Wallet</th>
                                    <th class="py-3 px-4 font-semibold">Nomor Rekening</th>
                                    <th class="py-3 px-4 font-semibold">Atas Nama</th>
                                    <th class="py-3 px-4 font-semibold text-center">Status</th>
                                    <th class="py-3 px-4 font-semibold text-right rounded-tr-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paymentMethods as $pm)
                                <tr class="border-b border-gray-100 hover:bg-gray-50/50">
                                    <td class="py-3 px-4 font-medium">{{ $pm->name }}</td>
                                    <td class="py-3 px-4">{{ $pm->account_number }}</td>
                                    <td class="py-3 px-4">{{ $pm->account_name }}</td>
                                    <td class="py-3 px-4 text-center">
                                        @if($pm->is_active)
                                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Aktif</span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <button onclick="editPaymentMethod({{ $pm->id }}, '{{ addslashes($pm->name) }}', '{{ addslashes($pm->account_number) }}', '{{ addslashes($pm->account_name) }}', {{ $pm->is_active ? 'true' : 'false' }})" class="text-blue-600 hover:bg-blue-50 p-2 rounded transition">
                                                <i class="ph-bold ph-pencil-simple"></i>
                                            </button>
                                            <form action="{{ route('payment_method.destroy', $pm->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus metode pembayaran ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded transition">
                                                    <i class="ph-bold ph-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500">Belum ada metode pembayaran.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
