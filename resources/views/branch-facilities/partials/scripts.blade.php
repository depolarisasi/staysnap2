<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi modal
        const modalEl = document.getElementById('iconPickerModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        
        const iconList = document.getElementById('iconList');
        const iconSearch = document.getElementById('iconSearch');
        const iconInput = document.getElementById('iconInput');
        const iconPreview = document.getElementById('iconPreview');
        const loading = document.getElementById('loadingIcons');
        let allIcons = [];
    
        // Load icons
        async function loadIcons() {
            try {
                loading.style.display = 'block';
                const response = await fetch('https://raw.githubusercontent.com/FortAwesome/Font-Awesome/master/metadata/icons.json');
                const data = await response.json();
                
                allIcons = Object.entries(data)
                    .filter(([_, meta]) => meta.styles.includes('solid'))
                    .map(([name]) => `fas fa-${name}`);
                    
                renderIcons();
            } catch (error) {
                console.error('Failed to load icons:', error);
            } finally {
                loading.style.display = 'none';
            }
        }
    
        // Render icons
        function renderIcons(filter = '') {
            iconList.innerHTML = '';
            const filteredIcons = allIcons.filter(icon => 
                icon.toLowerCase().includes(filter.toLowerCase())
            );
    
            filteredIcons.forEach(icon => {
                const col = document.createElement('div');
                col.className = 'col-3 col-md-2 mb-3';
                
                const iconItem = document.createElement('div');
                iconItem.className = 'icon-item';
                iconItem.innerHTML = `
                    <i class="${icon}"></i>
                    <span>${icon.replace('fas fa-', '')}</span>
                `;
                
                // Click handler dengan penanganan modal yang benar
                iconItem.addEventListener('click', () => {
                    iconInput.value = icon;
                    iconPreview.innerHTML = `<i class="${icon} icon-preview"></i>`;
                    modal.hide(); // Solusi 1: Gunakan method hide() dari instance modal
                });
    
                col.appendChild(iconItem);
                iconList.appendChild(col);
            });
        }
    
        // Backup cleanup untuk pastikan backdrop dihapus
        modalEl.addEventListener('hidden.bs.modal', () => {
            // Hapus semua backdrop
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            // Reset body style
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
    
        // Search functionality dengan debounce
        let searchTimeout;
        iconSearch.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                renderIcons(e.target.value);
            }, 300);
        });
    
        // Initial load
        loadIcons();
    });
    </script>