<?php
// Make sure session is started before including this file
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// You must already have DB connection in $conn before including this navbar!

// Get user email and first name from session
$first_name = $_SESSION['first_name'] ?? '';
$email = $_SESSION['email'] ?? '';
$userEmail = $email;

$totalItems = 0;
$totalPrice = 0;
$profileIMG = '';

if (!empty($userEmail)) {
    // Calculate total items and total price with discount logic
    $sql = "SELECT 
                SUM(cart_quantity) AS total_items, 
                SUM(
                    cart_quantity * 
                    CASE 
                        WHEN cart_discount > 0 AND cart_discount < cart_price 
                        THEN cart_discount 
                        ELSE cart_price 
                    END
                ) AS total_price 
            FROM cart_table 
            WHERE cart_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    $totalItems = $result['total_items'] ?? 0;
    $totalPrice = $result['total_price'] ?? 0;

    // Fetch profile image
    $stmt = $conn->prepare("SELECT profileIMG FROM users WHERE email = ?");
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $userResult = $stmt->get_result()->fetch_assoc();
    $profileIMG = $userResult['profileIMG'] ?? '';
}
?>

<header class="sticky top-0 z-50 bg-white shadow-md">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center py-4">

      <!-- Logo -->
  <?php
include('db_connection.php');

$sql_logo = "SELECT logo FROM settings_table LIMIT 1";
$result_logo = $conn->query($sql_logo);

$logo_img = '';

if ($result_logo && $result_logo->num_rows > 0) {
    $row = $result_logo->fetch_assoc();
    if (!empty($row['logo'])) {
        $logo_img = 'data:image/png;base64,' . $row['logo'];
    }
}
?>
<?php if (!empty($logo_img)): ?>
    <div class="flex justify-center mb-2">
        <img src="<?= $logo_img ?>" alt="Logo" class="h-16 object-contain">
    </div>
<?php else: ?>
    <h1 class="text-4xl font-bold text-center mb-2">Yummy<span class="text-red-600">.</span></h1>
<?php endif; ?>

      <!-- Desktop Navigation -->
  <?php
// These must already be set
$first_name = $_SESSION['first_name'] ?? '';
$email = $_SESSION['email'] ?? '';
$encodedFirstName = urlencode($first_name);
$encodedEmail = urlencode($email);
?>
<nav class="hidden md:flex space-x-6 items-center">
<a href="welcome.php?first_name=<?= $encodedFirstName ?>&email=<?= $encodedEmail ?>" class="text-gray-700 font-medium hover:text-red-600">Home</a>
<a href="about.php?first_name=<?= $encodedFirstName ?>&email=<?= $encodedEmail ?>" class="text-gray-700 font-medium hover:text-red-600">About</a>
<a href="menu.php?first_name=<?= $encodedFirstName ?>&email=<?= $encodedEmail ?>" class="text-gray-700 font-medium hover:text-red-600">Menu</a>
<a href="chefs.php?first_name=<?= $encodedFirstName ?>&email=<?= $encodedEmail ?>" class="text-gray-700 font-medium hover:text-red-600">Chefs</a>
<a href="gallery.php?first_name=<?= $encodedFirstName ?>&email=<?= $encodedEmail ?>" class="text-gray-700 font-medium hover:text-red-600">Gallery</a>
<a href="contact.php?first_name=<?= $encodedFirstName ?>&email=<?= $encodedEmail ?>" class="text-gray-700 font-medium hover:text-red-600">Contact</a>
</nav>

      <!-- Right Actions (Search + Cart + Profile) -->
      <div class="hidden md:flex items-center space-x-4">

        <!-- Search Bar -->
        <div class="relative">
          <input
            type="text"
            id="searchInput"
            placeholder="Search..."
            class="w-48 border border-gray-300 rounded-full py-1.5 px-4 text-sm focus:ring-2 focus:ring-red-500 focus:outline-none"
            autocomplete="off"
          />
          <div id="searchResults" class="absolute z-50 mt-1 w-64 bg-white shadow-lg rounded-lg hidden"></div>
        </div>

        <!-- Cart -->
        <div class="flex items-center space-x-1.5 relative">
          <span class="text-sm font-medium text-gray-700">
            Tk. <?php echo number_format($totalPrice, 2); ?>
          </span>
          <div class="inline-block relative">
            <img src="ress/cart.png" alt="Cart" class="w-6 h-6 object-contain hover:opacity-80 transition duration-200" />
            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-semibold rounded-full px-1.5">
              <?php echo $totalItems; ?>
            </span>
          </div>
        </div>

        <!-- Profile Icon -->
        <a href="user_mycart.php?first_name=<?= urlencode($first_name) ?>&email=<?= urlencode($email) ?>" class="ml-4 inline-block">
          <div class="flex items-center space-x-2">
            <?php if (!empty($profileIMG)): ?>
              <img src="data:image/jpeg;base64,<?= $profileIMG ?>" alt="Profile Picture" class="w-8 h-8 rounded-full object-cover hover:opacity-80 transition duration-200" />
            <?php else: ?>
              <img src="ress/newprofileorange.png" alt="Default Profile" class="w-8 h-8 rounded-full object-cover hover:opacity-80 transition duration-200" />
            <?php endif; ?>
          </div>
        </a>
      </div>

      <!-- Mobile Menu Button -->
      <div class="md:hidden">
        <button id="menu-btn" class="text-gray-700 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

    </div>
  </div>
</header>

<!-- Mobile Menu -->
<div id="mobile-menu" class="md:hidden hidden bg-white text-gray-800">
  <ul class="space-y-2 py-2">
    <li><a href="index.php" class="block px-4 py-2 hover:text-blue-900">Home</a></li>
    <li><a href="about.php" class="block px-4 py-2 hover:text-blue-900">About</a></li>
    <li><a href="menu.php" class="block px-4 py-2 hover:text-blue-900">Menu</a></li>
    <li><a href="chefs.php" class="block px-4 py-2 hover:text-blue-900">Chefs</a></li>
    <li><a href="gallery.php" class="block px-4 py-2 hover:text-blue-900">Gallery</a></li>
    <li><a href="contact.php" class="block px-4 py-2 hover:text-blue-900">Contact</a></li>
    <li><a href="#" class="block px-4 py-2 hover:text-blue-900">Sign In</a></li>
  </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('searchInput');
  const searchResults = document.getElementById('searchResults');

  searchInput.addEventListener('input', function () {
    const query = this.value.trim();

    if (query.length === 0) {
      searchResults.innerHTML = '';
      searchResults.classList.add('hidden');
      return;
    }

    fetch(`search_products.php?search=${encodeURIComponent(query)}`)
      .then(response => response.json())
      .then(data => {
        searchResults.innerHTML = '';

        if (data.length === 0) {
          searchResults.innerHTML = '<div class="p-2 text-gray-500">No results found</div>';
        } else {
          data.forEach(item => {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 p-2 hover:bg-gray-100 cursor-pointer';
            div.innerHTML = `
              <img src="data:image/jpeg;base64,${item.img}" alt="${item.title}" class="w-10 h-10 rounded object-cover">
              <div>
                <div class="text-sm font-medium">${item.title}</div>
                <div class="text-xs text-gray-500">Price: ৳${item.price}</div>
              </div>
            `;
            div.onclick = () => window.location.href = `product.php?id=${item.id}&first_name=<?= urlencode($first_name) ?>&email=<?= urlencode($email) ?>`;
            searchResults.appendChild(div);
          });
        }

        searchResults.classList.remove('hidden');
      })
      .catch(error => {
        console.error('Search error:', error);
        searchResults.innerHTML = '<div class="p-2 text-red-500">Error loading results</div>';
        searchResults.classList.remove('hidden');
      });
  });

  // Hide results when clicking outside
  document.addEventListener('click', function (e) {
    if (!searchResults.contains(e.target) && e.target !== searchInput) {
      searchResults.classList.add('hidden');
    }
  });

  // Mobile menu toggle
  const menuBtn = document.getElementById('menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');
  menuBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });
});
</script>
