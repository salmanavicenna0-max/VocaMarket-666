    <!-- Modal Tambah Payment Method -->
    <div id="modalAddPaymentMethod" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="document.getElementById('modalAddPaymentMethod').classList.add('hidden')"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-900">Tambah Metode Pembayaran</h3>
                    <button type="button" onclick="document.getElementById('modalAddPaymentMethod').classList.add('hidden')" class="text-gray-400 hover:text-gray-500 bg-white hover:bg-gray-100 rounded-full p-1.5 transition-colors">
                        <i class="ph-bold ph-x"></i>
                    </button>
                </div>
                <form action="{{ route('payment_method.store') }}" method="POST">
                    @csrf
                    <div class="px-6 py-5 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Bank/E-Wallet</label>
                            <input type="text" name="name" required placeholder="Contoh: BCA, OVO, DANA" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Rekening</label>
                            <input type="text" name="account_number" required placeholder="Contoh: 1234567890" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Atas Nama</label>
                            <input type="text" name="account_name" required placeholder="Contoh: Budi Santoso" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <input type="checkbox" name="is_active" id="is_active_add" value="1" checked class="rounded border-gray-300 text-primary focus:ring-primary">
                            <label for="is_active_add" class="text-sm text-gray-700">Aktifkan metode ini</label>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('modalAddPaymentMethod').classList.add('hidden')" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary rounded-lg hover:bg-blue-700 transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Payment Method -->
    <div id="modalEditPaymentMethod" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="document.getElementById('modalEditPaymentMethod').classList.add('hidden')"></div>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="relative bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-md sm:w-full">
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-900">Edit Metode Pembayaran</h3>
                    <button type="button" onclick="document.getElementById('modalEditPaymentMethod').classList.add('hidden')" class="text-gray-400 hover:text-gray-500 bg-white hover:bg-gray-100 rounded-full p-1.5 transition-colors">
                        <i class="ph-bold ph-x"></i>
                    </button>
                </div>
                <form id="formEditPaymentMethod" method="POST">
                    @csrf
                    <div class="px-6 py-5 space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Bank/E-Wallet</label>
                            <input type="text" name="name" id="edit_pm_name" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nomor Rekening</label>
                            <input type="text" name="account_number" id="edit_pm_account_number" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Atas Nama</label>
                            <input type="text" name="account_name" id="edit_pm_account_name" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <input type="checkbox" name="is_active" id="edit_pm_is_active" value="1" class="rounded border-gray-300 text-primary focus:ring-primary">
                            <label for="edit_pm_is_active" class="text-sm text-gray-700">Aktifkan metode ini</label>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                        <button type="button" onclick="document.getElementById('modalEditPaymentMethod').classList.add('hidden')" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-primary rounded-lg hover:bg-blue-700 transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function editPaymentMethod(id, name, account_number, account_name, is_active) {
            const modal = document.getElementById('modalEditPaymentMethod');
            const form = document.getElementById('formEditPaymentMethod');
            
            form.action = `/payment-method/${id}`;
            document.getElementById('edit_pm_name').value = name;
            document.getElementById('edit_pm_account_number').value = account_number;
            document.getElementById('edit_pm_account_name').value = account_name;
            document.getElementById('edit_pm_is_active').checked = is_active;
            
            modal.classList.remove('hidden');
        }
    </script>
