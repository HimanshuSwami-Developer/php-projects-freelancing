<?php
$title = "Portfolio Project — DD ASSOCIATES";
include __DIR__ . "/includes/header.php";
?>

<style>
  /* Portfolio Details Font Enhancements */
  #portfolioDetails h1 {
    font-size: 3.2rem; /* was ~2.25–3rem */
    line-height: 1.15;
  }

  #location {
    font-size: 0.9rem;
    letter-spacing: 0.15em;
  }

  #description {
    font-size: 1.05rem;
    line-height: 1.8;
  }

  #portfolioDetails p,
  #portfolioDetails span {
    font-size: 0.95rem;
  }

  #portfolioDetails .text-xs {
    font-size: 0.7rem;
  }

  #portfolioDetails .text-sm {
    font-size: 0.9rem;
  }
</style>


<section class="pt-10 md:pt-28 pb-24 bg-gray-50 min-h-screen">
  <div class="max-w-7xl mx-auto px-6">

    <!-- Breadcrumb -->
    <div class="mb-10 text-sm uppercase tracking-widest text-gray-400">
      <a href="/" class="hover:text-gold">Home</a> /
      <a href="/portfolio.php" class="hover:text-gold">Portfolio</a> /
      <span class="text-gray-700">Details</span>
    </div>

    <div id="portfolioDetails" class="hidden">
      <!-- Title -->
      <h1 id="title" class="text-4xl lg:text-5xl font-bold mb-4"></h1>
      <p id="location" class="text-gray-400 uppercase text-sm mb-10"></p>

      <!-- Gallery + Info -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

        <!-- Image Gallery -->
        <div class="lg:col-span-2">
          <img id="mainImage"
                class="rounded-xl shadow-xl w-full h-64 sm:h-80 lg:h-[420px] object-cover mb-6">

          <div id="gallery"
               class="flex gap-4 overflow-x-auto no-scrollbar max-w-full">
          </div>
        </div>

        <!-- Property Info -->
        <div class="bg-white rounded-xl shadow p-8">
          <div class="text-gold font-bold uppercase tracking-widest text-xs mb-4">
            Portfolio Project
          </div>

          <p id="description" class="text-gray-500 mb-8 leading-relaxed"></p>

          <div class="grid grid-cols-2 gap-6 text-sm font-bold uppercase">
            <div>
              <p class="text-gray-400">Type</p>
              <p id="room_type"></p>
            </div>
            <div>
              <p class="text-gray-400">Area</p>
              <p id="area"></p>
            </div>
            <div>
              <p class="text-gray-400">Bedrooms</p>
              <p id="beds"></p>
            </div>
            <div>
              <p class="text-gray-400">Bathrooms</p>
              <p id="baths"></p>
            </div>
          </div>

          <div class="mt-8 border-t pt-6">
            <p class="text-gray-400 text-xs uppercase mb-2">Rating</p>
            <div id="rating" class="text-yellow-400 text-sm"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Error -->
    <div id="notFound" class="hidden text-center py-32">
      <h2 class="text-3xl font-bold mb-4">Portfolio Project Not Found</h2>
      <p class="text-gray-500 mb-6">
        This portfolio project does not exist or is not marked as portfolio.
      </p>
      <a href="/portfolio.php"
         class="inline-block px-8 py-3 bg-gold text-black rounded-full font-bold uppercase">
        Back to Portfolio
      </a>
    </div>

  </div>
</section>

<script>
$(function () {

  const id = new URLSearchParams(window.location.search).get('id');

  $.getJSON('/assets/data/portfolios.json', function (data) {

    // ✅ ONLY portfolio items
    const project = data.find(
      p => p.id == id
    );

    if (!project) {
      $('#notFound').removeClass('hidden');
      return;
    }

    $('#portfolioDetails').removeClass('hidden');

    $('#title').text(project.title);
    $('#location').text(project.location);
    $('#description').text(project.description);
    $('#room_type').text(project.room_type);
    $('#area').text(project.area + ' Sq.Yd');
    $('#beds').text(project.beds);
    $('#baths').text(project.baths);

    $('#mainImage').attr('src', project.image_thumbnail);

    // Rating
    $('#rating').html(
      '★'.repeat(Math.round(project.rating)) +
      `<span class="text-gray-500 ml-2">(${project.rating})</span>`
    );

    // Gallery
    project.images_gallery.forEach(img => {
      $('#gallery').append(`
       <img src="${img}"
     class="w-28 h-20 shrink-0 rounded-lg object-cover cursor-pointer hover:opacity-80"
     onclick="$('#mainImage').attr('src', '${img}')">

      `);
    });

  });
});
</script>

<?php include __DIR__ . "/includes/footer.php"; ?>
