// Fungsi untuk memperbarui informasi tanggal
function updateDateInfo(startDate, endDate) {
    const dateInfo = document.getElementById('dateInfo');
    if (!dateInfo) return;

    if (!startDate || !endDate) {
        dateInfo.innerHTML = '';
        return;
    }

    // Format tanggal ke format Indonesia
    const formatDate = (date) => {
        return new Date(date).toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    };

    // Hitung jumlah malam
    const nights = Math.ceil((new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24));

    // Buat HTML untuk informasi tanggal
    const html = `
        <div class="flex flex-col space-y-2">
            <div class="flex justify-between items-center">
                <div class="flex-1">
                    <div class="text-sm text-gray-500">Check-in</div>
                    <div class="font-medium">${formatDate(startDate)}</div>
                </div>
                <div class="flex-1 text-right">
                    <div class="text-sm text-gray-500">Check-out</div>
                    <div class="font-medium">${formatDate(endDate)}</div>
                </div>
            </div>
            <div class="flex justify-center">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    ${nights} Malam
                </span>
            </div>
        </div>
    `;

    dateInfo.innerHTML = html;
}

// Fungsi untuk memperbarui teks tombol tanggal
function updateDateButtonText(startDate, endDate) {
    const selectedDateText = document.getElementById('selectedDateText');
    if (!selectedDateText) return;

    if (!startDate || !endDate) {
        selectedDateText.textContent = 'Pilih Tanggal';
        return;
    }

    // Format tanggal ke format Indonesia
    const formatDate = (date) => {
        return new Date(date).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'short'
        });
    };

    // Hitung jumlah malam
    const nights = Math.ceil((new Date(endDate) - new Date(startDate)) / (1000 * 60 * 60 * 24));

    selectedDateText.textContent = `${formatDate(startDate)} - ${formatDate(endDate)} (${nights} Malam)`;
}

// Fungsi untuk menyimpan tanggal ke URL
function saveDatesToUrl(startDate, endDate) {
    const url = new URL(window.location.href);
    if (startDate) url.searchParams.set('start_date', startDate);
    if (endDate) url.searchParams.set('end_date', endDate);
    window.history.pushState({}, '', url);
}

// Fungsi untuk mengambil tanggal dari URL
function getDatesFromUrl() {
    const url = new URL(window.location.href);
    return {
        startDate: url.searchParams.get('start_date'),
        endDate: url.searchParams.get('end_date')
    };
}

// Export fungsi-fungsi
window.dateInfoUtils = {
    updateDateInfo,
    updateDateButtonText,
    saveDatesToUrl,
    getDatesFromUrl
}; 