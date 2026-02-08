<?php $title = "Browse Properties — DD Associates";
include __DIR__ . "/includes/header.php"; ?>

<style>
  :root {
    --gold: #D4AF37;
    --dark: #0f0f10;
  }

  /* Luxury UI Elements */
  .filter-chip {
    transition: all 0.3s ease;
    border: 1px solid #eee;
  }

  .filter-chip:hover {
    border-color: var(--gold);
    color: var(--gold);
  }

  .search-input:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.1);
  }

  /* Property Card Hover */
  .property-card {
    transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
  }

  .property-card:hover {
    transform: translateY(-8px);
  }

  /* Custom Checkbox */
  .locationCheck {
    accent-color: var(--gold);
    cursor: pointer;
  }

  /* Animated Sidebar Overlay */
  #overlay {
    backdrop-filter: blur(4px);
    transition: opacity 0.3s ease;
  }
</style>

<section class="bg-[#fcfcfc] min-h-screen">
  <div class="bg-[#0f0f10] pt-10 md:pt-28 pb-16 px-4">
    <div class="max-w-7xl mx-auto">
      <nav class="flex text-[10px] font-bold uppercase tracking-[0.3em] text-gray-500 mb-4">
        <span>Portfolio</span> <span class="mx-2">/</span> <span class="text-gold">Properties</span>
      </nav>

      <h1 class="text-4xl md:text-6xl font-black text-white uppercase tracking-tighter mb-4">
        Our <span class="text-gold">Property Portfolio</span>
      </h1>

      <p class="text-gray-400 max-w-xl font-light">
        A handpicked collection of signature residential and commercial properties, showcasing design, location, and
        long-term value.
      </p>
    </div>
  </div>


  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
    <div class="bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4 border border-gray-100">
      <div class="flex-1 relative">
        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
        <input id="searchText" type="text" placeholder="Search by title or location..."
          class="search-input w-full rounded-xl border-gray-100 pl-12 pr-4 py-4 text-sm focus:outline-none transition-all" />
      </div>
      <button id="toggleFilters"
        class="flex items-center gap-2 px-8 py-4 bg-[#0f0f10] text-gold rounded-xl font-bold uppercase tracking-widest text-xs transition-all shadow-lg">
        <i class="fas fa-sliders-h"></i> Filters
      </button>
    </div>

    <div class="mt-10 flex items-center justify-between border-b border-gray-100 pb-4">
      <div class="flex items-center gap-2">
        <span class="w-2 h-2 bg-gold rounded-full animate-pulse"></span>
        <p class="text-[11px] font-black uppercase tracking-widest text-gray-500">Live Catalog: <span id="resultsCount"
            class="text-gray-900">0</span> Properties</p>
      </div>
      <div id="activeFiltersContainer" class="hidden md:flex gap-2">
      </div>
    </div>

    <div id="propertiesGrid" class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 pb-20">
      <div class="animate-pulse bg-white h-96 rounded-2xl"></div>
      <div class="animate-pulse bg-white h-96 rounded-2xl"></div>
      <div class="animate-pulse bg-white h-96 rounded-2xl"></div>
    </div>
    <!-- Pagination -->
    <div id="pagination" class="flex justify-center items-center gap-3 mt-12 pb-20"></div>

  </div>
</section>

<div id="filterSidebar"
  class="fixed top-0 left-0 w-80 h-full bg-white shadow-2xl transform -translate-x-full transition-transform duration-500 z-[100] overflow-y-auto">
  <div class="p-8 border-b border-gray-100 flex items-center justify-between bg-[#0f0f10]">
    <div>
      <h2 class="text-gold font-black uppercase tracking-widest text-sm">Refine Search</h2>
      <p class="text-[9px] text-gray-500 uppercase tracking-widest">Adjust your parameters</p>
    </div>
    <button id="closeFilters"
      class="w-8 h-8 rounded-full bg-white/10 text-white hover:bg-gold hover:text-black transition flex items-center justify-center font-light">&times;</button>
  </div>

  <div class="p-8 space-y-8">
    <div class="hidden">
      <label class="text-[10px] uppercase font-black tracking-widest text-gray-400 block mb-4">Project Status</label>
      <select id="statusFilter"
        class="w-full rounded-xl border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:ring-gold focus:border-gold">
        <option value="all">All Properties</option>
        <option value="new">Newly Launched</option>
        <option value="complete">Ready to Move</option>
      </select>
    </div>

    <div>
      <label class="text-[10px] uppercase font-black tracking-widest text-gray-400 block mb-4">Minimum
        Configuration</label>
      <div class="grid grid-cols-2 gap-2">
        <select id="bedsFilter"
          class="col-span-2 w-full rounded-xl border-gray-100 bg-gray-50 px-4 py-3 text-sm focus:ring-gold">
          <option value="0">Any BHK</option>
          <option value="1">1+ BHK</option>
          <option value="2">2+ BHK</option>
          <option value="3">3+ BHK</option>
          <option value="4">4+ BHK</option>
        </select>
      </div>
    </div>

    <div>
      <label class="text-[10px] uppercase font-black tracking-widest text-gray-400 block mb-4">Preferred
        Locations</label>
      <div id="locationFilter" class="space-y-3 bg-gray-50 p-4 rounded-xl max-h-60 overflow-y-auto custom-scrollbar">
      </div>
    </div>

    <div class="pt-6">
      <button id="resetFilters"
        class="w-full bg-gray-100 hover:bg-red-50 hover:text-red-600 text-[10px] font-black uppercase tracking-widest py-4 rounded-xl transition-all">
        Clear All Filters
      </button>
    </div>
  </div>
</div>

<div id="overlay" class="fixed inset-0 bg-black/60 hidden z-[90]"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(function () {
    let properties = [];
    let currentPage = 1;
    const itemsPerPage = 9; // 3x3 grid
    let filteredCache = [];


    // Logic Preserved: Load JSON and locations
    $.getJSON('property_api.php', function (data) {
      properties = Array.isArray(data)
        ? data.filter(p => p.property_type === "portfolio")
        : [];
      const locations = [...new Set(properties.map(p => p.location))];

      let locHtml = "";
      locations.forEach(loc => {
        locHtml += `
        <label class="flex items-center gap-3 group cursor-pointer">
          <input type="checkbox" value="${loc}" class="locationCheck w-4 h-4 rounded border-gray-300">
          <span class="text-sm text-gray-600 group-hover:text-gold transition font-medium">${loc}</span>
        </label>`;
      });
      $("#locationFilter").html(locHtml);
      filteredCache = properties;
      renderPage();

    });

    // Logic Preserved: Sidebar toggle
    $('#toggleFilters').click(() => {
      $('#filterSidebar').removeClass('-translate-x-full');
      $('#overlay').removeClass('hidden').addClass('block');
    });
    $('#closeFilters, #overlay').click(() => {
      $('#filterSidebar').addClass('-translate-x-full');
      $('#overlay').addClass('hidden').removeClass('block');
    });

    // Logic Preserved: Filter inputs
    $(document).on("change", ".locationCheck", function () { applyFilters(); });
    $('#searchText, #bedsFilter, #statusFilter').on('input change', function () { applyFilters(); });

    $('#resetFilters').click(function () {
      $('#searchText').val('');
      $('#bedsFilter').val('0');
      $('#statusFilter').val('all');
      $('.locationCheck').prop('checked', false);
      applyFilters();
    });

    function applyFilters() {
      const search = $('#searchText').val().toLowerCase();
      const beds = parseInt($('#bedsFilter').val()) || 0;
      const status = $('#statusFilter').val();
      const selectedLocations = $('.locationCheck:checked')
        .map(function () { return this.value; }).get();

      filteredCache = properties.filter(p => {
        return (
          (p.title.toLowerCase().includes(search) ||
            p.location.toLowerCase().includes(search)) &&
          p.beds >= beds &&
          (status === "all" || p.status === status) &&
          (selectedLocations.length === 0 ||
            selectedLocations.includes(p.location))
        );
      });

      currentPage = 1; // reset page on filter change
      renderPage();
    }

    function renderPage() {
      const start = (currentPage - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      const pageItems = filteredCache.slice(start, end);

      renderProperties(pageItems);
      renderPagination(filteredCache.length);
    }

function renderPagination(totalItems) {
  const totalPages = Math.ceil(totalItems / itemsPerPage);
  const pagination = $('#pagination');
  pagination.empty();

  if (totalPages <= 1) return;

  const maxVisible = 5; // window size
  let start = Math.max(2, currentPage - 1);
  let end = Math.min(totalPages - 1, currentPage + 1);

  // Adjust window near edges
  if (currentPage <= 3) {
    start = 2;
    end = Math.min(totalPages - 1, maxVisible);
  }
  if (currentPage >= totalPages - 2) {
    start = Math.max(2, totalPages - maxVisible + 1);
    end = totalPages - 1;
  }

  // Prev
  pagination.append(`
    <button ${currentPage === 1 ? 'disabled' : ''}
      data-page="${currentPage - 1}"
      class="px-4 py-2 rounded-full text-xs font-black uppercase
      ${currentPage === 1
        ? 'bg-gray-100 text-gray-400'
        : 'bg-white border border-gray-200 hover:border-gold hover:text-gold'}">
      Prev
    </button>
  `);

  // First page
  pagination.append(pageButton(1));

  // Left ellipsis
  if (start > 2) {
    pagination.append(`<span class="px-2 text-gray-400 font-black">…</span>`);
  }

  // Middle pages
  for (let i = start; i <= end; i++) {
    pagination.append(pageButton(i));
  }

  // Right ellipsis
  if (end < totalPages - 1) {
    pagination.append(`<span class="px-2 text-gray-400 font-black">…</span>`);
  }

  // Last page
  if (totalPages > 1) {
    pagination.append(pageButton(totalPages));
  }

  // Next
  pagination.append(`
    <button ${currentPage === totalPages ? 'disabled' : ''}
      data-page="${currentPage + 1}"
      class="px-4 py-2 rounded-full text-xs font-black uppercase
      ${currentPage === totalPages
        ? 'bg-gray-100 text-gray-400'
        : 'bg-white border border-gray-200 hover:border-gold hover:text-gold'}">
      Next
    </button>
  `);
}

function pageButton(page) {
  return `
    <button data-page="${page}"
      class="w-10 h-10 rounded-full text-xs font-black
      ${page === currentPage
        ? 'bg-gold text-black shadow-lg'
        : 'bg-white border border-gray-200 hover:border-gold hover:text-gold'}">
      ${page}
    </button>
  `;
}

    $(document).on('click', '#pagination button:not([disabled])', function () {
      currentPage = parseInt($(this).data('page'));
      renderPage();
      $('html, body').animate({
        scrollTop: $('#propertiesGrid').offset().top - 120
      }, 300);
    });


    function renderProperties(list) {
      const grid = $('#propertiesGrid');
      grid.empty();
      $('#resultsCount').text(list.length);

      if (list.length === 0) {
        grid.html('<div class="col-span-full py-20 text-center"><i class="fas fa-search text-4xl text-gray-200 mb-4"></i><p class="text-gray-400 uppercase tracking-widest text-xs font-bold">No properties match your selection</p></div>');
        return;
      }

      list.forEach(p => {
        const card = `
      <a href="portfolio_details.php?id=${p.id}" class="property-card group block bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl border border-gray-50">
        <div class="relative h-64 overflow-hidden">
          <img src="${p.image_thumbnail}" alt="${p.title}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
          <div class="absolute top-4 left-4">
             <span class="px-4 py-1.5 text-[9px] font-black uppercase tracking-[0.2em] rounded-full shadow-lg  bg-gray-200 text-black">
               ${p.property_type}
             </span>
          </div>
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
             <span class="text-white text-xs font-bold uppercase tracking-widest">View Property Details —</span>
          </div>
        </div>

        <div class="p-8">
          <div class="flex justify-between items-start mb-2">
              <h2 class="font-black text-xl text-gray-900 uppercase tracking-tighter leading-tight">${p.title}</h2>
          </div>
          
          <div class="flex items-center text-gold text-[10px] mb-4">
            ${[1, 2, 3, 4, 5].map(i => `<i class="fa-solid fa-star ${p.rating >= i ? '' : 'text-gray-200'}"></i>`).join('')}
            <span class="ml-2 text-gray-400 font-bold">(${p.rating})</span>
          </div>

          <p class="text-xs text-gray-400 font-bold uppercase tracking-widest flex items-center gap-2 mb-6">
            <i class="fas fa-location-dot text-gold"></i> ${p.location}
          </p>
          
          <div class="flex items-center justify-between pt-2 border-t border-gray-50">
            <div class="flex gap-4">
                <div class="text-center">
                    <span class="block text-[12px] font-black text-gray-900">${p.type}</span>
                </div>
                <div class="w-[1px] h-6 bg-gray-100"></div>
                <div class="text-center">
                    <span class="block text-[12px] font-black text-gray-900">${p.area} Sq YD</span>
                </div>
            </div>
            <i class="fas fa-arrow-right text-gray-400 group-hover:text-gold transition-colors"></i>
          </div>
        </div>
      </a>`;
        grid.append(card);
      });
    }
  });
</script>

<?php include __DIR__ . "/includes/footer.php"; ?>