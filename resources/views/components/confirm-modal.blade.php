{{-- Custom Confirmation Modal (Black & White) --}}
<div id="confirmModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>
    
    {{-- Modal --}}
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-lg shadow-2xl max-w-md w-full transform transition-all">
            {{-- Content --}}
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4" id="confirmTitle">Confirm Action</h3>
                <p class="text-gray-600 mb-6" id="confirmMessage">Are you sure?</p>
                
                {{-- Buttons --}}
                <div class="flex gap-3 justify-end">
                    <button onclick="closeConfirmModal(false)" class="px-6 py-2 border border-gray-300 text-gray-700 font-bold rounded-md hover:bg-gray-100 transition-colors">
                        Cancel
                    </button>
                    <button onclick="closeConfirmModal(true)" class="px-6 py-2 bg-black text-white font-bold rounded-md hover:bg-gray-800 transition-colors">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let confirmCallback = null;

function showConfirmModal(message, title = 'Confirm Action') {
    return new Promise((resolve) => {
        confirmCallback = resolve;
        document.getElementById('confirmTitle').textContent = title;
        document.getElementById('confirmMessage').textContent = message;
        document.getElementById('confirmModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });
}

function closeConfirmModal(result) {
    document.getElementById('confirmModal').classList.add('hidden');
    document.body.style.overflow = '';
    if (confirmCallback) {
        confirmCallback(result);
        confirmCallback = null;
    }
}
</script>
