<?php
session_start();
require_once __DIR__ . "/config/db.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login");
    exit;
}

$db = new Database();
$conn = $db->getConnection();

/* ================= SAVE / UPDATE ================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ---------- DEFAULTS (IMPORTANT) ---------- */
    $oldThumb = null;
    $oldGallery = [];
    $galleryImages = [];
    $thumbnail = null;

    $slug = strtolower(str_replace(' ', '_', $_POST['title']));

    // if (
    //     !empty($_FILES['image_thumbnail']['name']) &&
    //     $_FILES['image_thumbnail']['size'] > 200 * 1024
    // ) {
    //     die('Thumbnail too large');
    // }


    function uploadImage($file, $folder, $filename = null)
    {
        if ($file['error'] !== UPLOAD_ERR_OK)
            return null;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $dir = __DIR__ . "/Uploads/$folder";

        if (!is_dir($dir))
            mkdir($dir, 0777, true);

        $name = ($filename ?: uniqid()) . "." . $ext;
        move_uploaded_file($file['tmp_name'], "$dir/$name");

        return "Uploads/$folder/$name";
    }

    /* ---------- FETCH OLD DATA IF EDIT ---------- */
    if (!empty($_POST['id'])) {
        $res = $conn->query(
            "SELECT image_thumbnail, images_gallery 
             FROM properties WHERE id=" . (int) $_POST['id']
        );

        if ($res && $res->num_rows) {
            $old = $res->fetch_assoc();
            $oldThumb = $old['image_thumbnail'];
            $oldGallery = json_decode($old['images_gallery'], true) ?: [];
        }
    }

    /* ---------- UPLOAD NEW THUMBNAIL ---------- */
    if (!empty($_FILES['image_thumbnail']['name'])) {
        $thumbnail = uploadImage($_FILES['image_thumbnail'], $slug, 'thumb');
    }

    // keep old thumbnail if not replaced
    if (!$thumbnail && $oldThumb) {
        $thumbnail = $oldThumb;
    }

    /* ---------- UPLOAD NEW GALLERY IMAGES ---------- */
    if (!empty($_FILES['images_gallery']['name'][0])) {
        foreach ($_FILES['images_gallery']['tmp_name'] as $i => $tmp) {
            if ($_FILES['images_gallery']['error'][$i] === 0) {
                $file = [
                    'name' => $_FILES['images_gallery']['name'][$i],
                    'tmp_name' => $tmp,
                    'error' => 0
                ];
                $img = uploadImage($file, $slug, $i + 1);
                if ($img)
                    $galleryImages[] = $img;
            }
        }
    }

    /* ---------- HANDLE DELETED GALLERY IMAGES ---------- */
    $deletedImages = [];
    if (!empty($_POST['delete_gallery_images'])) {
        $deletedImages = json_decode($_POST['delete_gallery_images'], true) ?: [];
    }

    if (!empty($deletedImages)) {
        // Remove from old gallery
        $oldGallery = array_values(array_diff($oldGallery, $deletedImages));

        // Delete files from disk
        foreach ($deletedImages as $imgPath) {
            $fullPath = __DIR__ . '/' . $imgPath;
            if (file_exists($fullPath))
                unlink($fullPath);
        }
    }

    /* ---------- MERGE OLD + NEW GALLERY ---------- */
    $galleryImages = array_merge($oldGallery, $galleryImages);
    $gallery = json_encode($galleryImages);

    /* ---------- SAVE TO DATABASE ---------- */
    if (!empty($_POST['id'])) {

        $stmt = $conn->prepare("
            UPDATE properties SET
            title=?, room_type=?, location=?, type=?, beds=?, baths=?, area=?,
            image_thumbnail=?, images_gallery=?, status=?, rating=?, property_type=?, description=?
            WHERE id=?
        ");

        $stmt->bind_param(
            "ssssiiisssdssi",
            $_POST['title'],
            $_POST['room_type'],
            $_POST['location'],
            $_POST['type'],
            $_POST['beds'],
            $_POST['baths'],
            $_POST['area'],
            $thumbnail,
            $gallery,
            $_POST['status'],
            $_POST['rating'],
            $_POST['property_type'],
            $_POST['description'],
            $_POST['id']
        );

    } else {

        $stmt = $conn->prepare("
            INSERT INTO properties
            (title, room_type, location, type, beds, baths, area,
             image_thumbnail, images_gallery, status, rating, property_type, description)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)
        ");

        $stmt->bind_param(
            "ssssiiisssdss",
            $_POST['title'],
            $_POST['room_type'],
            $_POST['location'],
            $_POST['type'],
            $_POST['beds'],
            $_POST['baths'],
            $_POST['area'],
            $thumbnail,
            $gallery,
            $_POST['status'],
            $_POST['rating'],
            $_POST['property_type'],
            $_POST['description']
        );
    }

    $stmt->execute();
    header("Location: add_property.php");
    exit;
}

/* ================= DELETE PROPERTY ================= */
if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM properties WHERE id=" . (int) $_GET['delete']);
    header("Location: add_property.php");
    exit;
}

/* ================= FETCH ================= */
$result = $conn->query("SELECT * FROM properties ORDER BY created_at DESC");

include __DIR__ . "/includes/header.php";
?>


<div class="flex">
    <?php include __DIR__ . "/includes/sidebar.php"; ?>

    <div class="ml-64 p-8 bg-gray-100 min-h-screen w-full">

        <!-- HEADER -->
        <div class="flex justify-between mb-6">
            <h1 class="text-2xl font-bold">Property Management</h1>
            <button onclick="openAddModal()"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow">
                + Add Property
            </button>
        </div>

        <!-- TABLE -->
        <table class="w-full bg-white rounded-xl shadow text-sm overflow-hidden">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-4 text-left">Title</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Rating</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="border-t hover:bg-gray-50 text-center">
                        <td class="p-4 font-semibold text-left"><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['location']) ?></td>
                        <td><?= $row['property_type'] ?></td>
                        <td>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
    <?= $row['status'] == 'active' ? 'bg-green-100 text-green-700' :
        ($row['status'] == 'inactive' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </td>
                        <td><?= $row['rating'] ?></td>
                        <td class="flex justify-center gap-2 p-2">
                            <button onclick='editProperty(<?= json_encode($row) ?>)'
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">Edit</button>

                            <button onclick='openGallery(
<?= json_encode($row["image_thumbnail"]) ?>,
<?= json_encode(json_decode($row["images_gallery"], true)) ?>
)' class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">Gallery</button>

                            <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this property?')"
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ================= ADD / EDIT MODAL ================= -->
<div id="propertyModal" class="fixed inset-0 bg-black bg-opacity-60 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl animate-fadeIn
            max-h-[90vh] flex flex-col">


        <div class="flex justify-between items-center px-6 py-4 border-b bg-gray-50 rounded-t-2xl">
            <h2 id="modalTitle" class="text-xl font-bold">Add Property</h2>
            <button onclick="closePropertyModal()" class="text-2xl text-gray-500 hover:text-red-600">&times;</button>
        </div>

        <form method="POST" id="propertyForm" class="p-6 space-y-5 overflow-y-auto max-h-[75vh]"
            enctype="multipart/form-data">

            <input type="hidden" name="id" id="id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input class="input" name="title" id="title" placeholder="Property Title" required>
                <input class="input" name="location" id="location" placeholder="Location">
                <input class="input" name="room_type" id="room_type" placeholder="Room Type (3BHK)">
                <input class="input" name="type" id="type" placeholder="Property Type">
                <input class="input" name="beds" id="beds" type="number" placeholder="Beds">
                <input class="input" name="baths" id="baths" type="number" placeholder="Baths">
                <input class="input" name="area" id="area" placeholder="Area (sq. yard)">
                <input class="input" name="rating" id="rating" placeholder="Rating (4.5)">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <select class="input" name="property_type" id="property_type">
                    <option value="portfolio">Portfolio</option>
                    <option value="sale">Sale</option>
                </select>

                <select class="input" name="status" id="status">
                    <option value="new">New</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <input type="hidden" name="delete_gallery_images" id="delete_gallery_images">

            <div class="space-y-2">
                <label class="font-medium">Thumbnail Image</label>

                <input type="file" name="image_thumbnail" accept="image/*" class="input">

                <div id="thumbPreviewBox" class="hidden mt-3">
                    <p class="text-xs text-gray-500 mb-1">Current Thumbnail</p>
                    <img id="thumbPreview" class="h-32 w-32 object-cover rounded-lg border shadow">
                </div>
            </div>


            <div class="space-y-2">
                <label class="font-medium">Gallery Images</label>

                <input type="file" name="images_gallery[]" multiple accept="image/*" class="input">

                <div id="galleryPreviewBox"
                    class="mt-3 max-h-48 overflow-y-auto grid grid-cols-3 gap-3 rounded-lg border p-2 bg-gray-50">
                </div>
            </div>



            <textarea class="input h-24" name="description" id="description"
                placeholder="Property Description"></textarea>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <button type="button" onclick="closePropertyModal()" class="px-4 py-2 rounded border">Cancel</button>
                <button class="px-6 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white">
                    Save Property
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= GALLERY MODAL ================= -->
<div id="galleryModal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-2xl animate-fadeIn
            max-h-[90vh] flex flex-col">

        <div class="flex justify-between items-center px-6 py-4 border-b bg-gray-50 rounded-t-2xl">
            <h2 class="text-xl font-bold">Property Gallery</h2>
            <button onclick="closeGallery()" class="text-2xl hover:text-red-600">&times;</button>
        </div>

        <div class="p-6">
            <div id="thumbnailBox" class="mb-6"></div>
            <div id="galleryImages" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
        </div>
    </div>
</div>
<div id="compressionStatus" class="fixed bottom-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg hidden">
    Compressing images... Please wait
</div>

<style>
    .input {
        width: 100%;
        padding: 10px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    .input:focus {
        outline: none;
        border-color: #6366f1;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, .2);
    }

    .animate-fadeIn {
        animation: fadeIn .25s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(.95)
        }

        to {
            opacity: 1;
            transform: scale(1)
        }
    }
</style>
<!-- In your HTML head or before your scripts -->
<script src="https://unpkg.com/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>
<script>
    let isCompressing = false;
    
    async function compressImages(input) {
        if (!input || !input.files || input.files.length === 0) return;
        
        isCompressing = true;
        console.log('Starting compression...');
        
        const files = Array.from(input.files);
        const compressedFiles = [];
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            
            try {
                // Skip if already small enough
                if (file.size <= 80 * 1024) {
                    console.log(`File ${file.name} is already ${(file.size/1024).toFixed(2)}KB, skipping compression`);
                    compressedFiles.push(file);
                    continue;
                }
                
                console.log(`Compressing ${file.name} (${(file.size/1024).toFixed(2)}KB)`);
                
                // Compression options
                const options = {
                    maxSizeMB: 0.08,           // 80KB
                    maxWidthOrHeight: 1024,     // Maximum dimension
                    initialQuality: 0.7,        // Start with 70% quality
                    useWebWorker: true,
                    fileType: 'image/jpeg',
                    alwaysKeepResolution: true
                };
                
                // Compress the image
                const compressedBlob = await imageCompression(file, options);
                
                // Create a proper File object from the Blob
                const compressedFile = new File([compressedBlob], file.name, {
                    type: 'image/jpeg',
                    lastModified: new Date().getTime()
                });
                
                console.log(`Compressed to ${(compressedFile.size/1024).toFixed(2)}KB`);
                
                // If still too large, compress more aggressively
                if (compressedFile.size > 85 * 1024) {
                    console.log('Second compression pass...');
                    const options2 = {
                        maxSizeMB: 0.07,
                        maxWidthOrHeight: 800,
                        initialQuality: 0.5,
                        useWebWorker: true
                    };
                    
                    const compressedBlob2 = await imageCompression(compressedBlob, options2);
                    const compressedFile2 = new File([compressedBlob2], file.name, {
                        type: 'image/jpeg',
                        lastModified: new Date().getTime()
                    });
                    
                    compressedFiles.push(compressedFile2);
                    console.log(`Recompressed to ${(compressedFile2.size/1024).toFixed(2)}KB`);
                } else {
                    compressedFiles.push(compressedFile);
                }
                
            } catch (error) {
                console.error('Failed to compress:', error);
                compressedFiles.push(file); // Use original if compression fails
            }
        }
        
        // Replace the original files with compressed ones
        if (compressedFiles.length > 0) {
            const dataTransfer = new DataTransfer();
            
            compressedFiles.forEach(file => {
                // Ensure it's a valid File object
                if (file && file instanceof File) {
                    dataTransfer.items.add(file);
                }
            });
            
            input.files = dataTransfer.files;
            console.log('Compression complete. Files updated.');
        }
        
        isCompressing = false;
    }
    
    // Initialize event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Listen for thumbnail input
        const thumbInput = document.querySelector('input[name="image_thumbnail"]');
        if (thumbInput) {
            thumbInput.addEventListener('change', function() {
                compressImages(this);
            });
        }
        
        // Listen for gallery input
        const galleryInput = document.querySelector('input[name="images_gallery[]"]');
        if (galleryInput) {
            galleryInput.addEventListener('change', function() {
                compressImages(this);
            });
        }
        
        // Prevent form submission during compression
        const form = document.getElementById('propertyForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (isCompressing) {
                    e.preventDefault();
                    alert('Please wait for images to finish compressing...');
                    return false;
                }
                return true;
            });
        }
    });
    
    // Also initialize when modal opens (for edit mode)
    if (typeof editProperty === 'function') {
        const originalEditProperty = editProperty;
        window.editProperty = function(data) {
            originalEditProperty(data);
            setTimeout(initCompressionListeners, 100);
        };
    }
    
    function initCompressionListeners() {
        // Re-initialize listeners for dynamically shown inputs
        const thumbInput = document.querySelector('input[name="image_thumbnail"]');
        const galleryInput = document.querySelector('input[name="images_gallery[]"]');
        
        if (thumbInput) {
            thumbInput.removeEventListener('change', compressImages);
            thumbInput.addEventListener('change', function() {
                compressImages(this);
            });
        }
        
        if (galleryInput) {
            galleryInput.removeEventListener('change', compressImages);
            galleryInput.addEventListener('change', function() {
                compressImages(this);
            });
        }
    }
</script>

<script>

    function openAddModal() {
        document.getElementById('modalTitle').innerText = 'Add Property';
        document.getElementById('propertyForm').reset();
        document.getElementById('id').value = '';
        //  document.getElementById('thumbPreview').classList.add('hidden');
        //  document.getElementById('galleryPreview').innerHTML='';
        document.getElementById('propertyModal').classList.remove('hidden');
    }

    function closePropertyModal() {
        document.getElementById('propertyModal').classList.add('hidden');
    }


    let deleteImages = [];

    function editProperty(data) {
        openAddModal();
        document.getElementById('modalTitle').innerText = 'Update Property';

        deleteImages = [];
        document.getElementById('delete_gallery_images').value = '';

        Object.keys(data).forEach(k => {
            if (document.getElementById(k) && typeof data[k] !== 'object') {
                document.getElementById(k).value = data[k];
            }
        });

        /* Thumbnail */
        const thumbBox = document.getElementById('thumbPreviewBox');
        const thumbImg = document.getElementById('thumbPreview');
        if (data.image_thumbnail) {
            thumbImg.src = data.image_thumbnail;
            thumbBox.classList.remove('hidden');
        }

        /* Gallery */
        const galleryBox = document.getElementById('galleryPreviewBox');
        galleryBox.innerHTML = '';

        try {
            const images = JSON.parse(data.images_gallery);
            images.forEach(img => {
                galleryBox.innerHTML += `
                <div class="relative group">
                    <img src="${img}"
                         class="h-24 w-full object-cover rounded border shadow-sm">

                    <button type="button"
                        onclick="markGalleryDelete('${img}', this)"
                        class="absolute top-1 right-1 bg-red-600 text-white text-xs rounded-full px-2 py-0.5 opacity-0 group-hover:opacity-100">
                        ✕
                    </button>
                </div>
            `;
            });
        } catch (e) { }
    }

    function markGalleryDelete(img, btn) {
        if (!confirm('Remove this image?')) return;

        deleteImages.push(img);
        document.getElementById('delete_gallery_images').value = JSON.stringify(deleteImages);

        // Remove preview instantly
        btn.parentElement.remove();
    }


    // function previewThumbnail(url){
    //  const img=document.getElementById('thumbPreview');
    //  if(url){ img.src=url; img.classList.remove('hidden'); }
    //  else{ img.classList.add('hidden'); }
    // }

    // function previewGallery(value){
    //  const box=document.getElementById('galleryPreview');
    //  box.innerHTML='';
    //  try{
    //   JSON.parse(value).forEach(i=>{
    //    box.innerHTML+=`<img src="${i}" class="h-24 w-full object-cover rounded shadow">`;
    //   });
    //  }catch(e){}
    // }

    function openGallery(thumbnail, images) {
        document.getElementById('galleryModal').classList.remove('hidden');
        document.getElementById('thumbnailBox').innerHTML = thumbnail
            ? `<h3 class="font-semibold mb-2">Thumbnail</h3>
     <img src="${thumbnail}" class="w-full h-64 object-cover rounded">` : '';
        let html = '';
        if (Array.isArray(images)) {
            images.forEach(i => {
                html += `<img src="${i}" class="w-full h-40 object-cover rounded shadow cursor-pointer hover:scale-105 transition"
          onclick="window.open('${i}','_blank')">`;
            });
        }
        document.getElementById('galleryImages').innerHTML = html;
    }

    function closeGallery() {
        document.getElementById('galleryModal').classList.add('hidden');
    }
</script>