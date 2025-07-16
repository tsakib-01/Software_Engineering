<?php
// Start session if needed
session_start();
$first_name = $_SESSION['first_name'] ?? '';
$email = $_SESSION['email'] ?? '';

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";  // your DB password here
$database = "rms_project";

// Connect to DB
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ 1. Handle Add to Cart submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productID'])) {
    $userEmail = $_SESSION['email'] ?? ($_POST['email'] ?? '');
    $firstName = $_SESSION['first_name'] ?? ($_POST['first_name'] ?? '');

    if (!$userEmail || !$firstName) {
        echo "Error: User not logged in or missing info.";
        exit();
    }
$productIMG = isset($_POST['productIMG']) ? urldecode(mysqli_real_escape_string($conn, $_POST['productIMG'])) : '';
$productIMG_2 = isset($_POST['productIMG_2']) ? urldecode(mysqli_real_escape_string($conn, $_POST['productIMG_2'])) : '';
$productIMG_3 = isset($_POST['productIMG_3']) ? urldecode(mysqli_real_escape_string($conn, $_POST['productIMG_3'])) : '';
$category = isset($_POST['category']) ? mysqli_real_escape_string($conn, $_POST['category']) : '';
$subtitles = isset($_POST['subtitles']) ? mysqli_real_escape_string($conn, $_POST['subtitles']) : '';
$titles = isset($_POST['titles']) ? mysqli_real_escape_string($conn, $_POST['titles']) : '';
$price = isset($_POST['price']) ? floatval($_POST['price']) : 0;
$discount = isset($_POST['discount']) ? floatval($_POST['discount']) : 0;

    $productID = intval($_POST['productID']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    if ($quantity <= 0) {
        echo "Error: Invalid quantity.";
        exit();
    }

    // Check if product already in cart
    $checkQuery = "SELECT * FROM cart_table WHERE cart_email = '$userEmail' AND cart_productID = $productID";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult && $checkResult->num_rows > 0) {
        $row = $checkResult->fetch_assoc();
        $newQuantity = $row['cart_quantity'] + $quantity;

        $updateQuery = "UPDATE cart_table SET cart_quantity = $newQuantity WHERE cart_email = '$userEmail' AND cart_productID = $productID";

        if ($conn->query($updateQuery) === TRUE) {
          //  header("Location: product.php?id=$productID&first_name=" . urlencode($firstName) . "&email=" . urlencode($userEmail) . "&msg=new_pro");
header("Location: product.php?id=$productID&first_name=" . urlencode($firstName) . "&email=" . urlencode($userEmail));
        exit();
        } else {
            echo "Error updating cart: " . $conn->error;
            exit();
        }
      } else {
      $insertQuery = "INSERT INTO cart_table (
      cart_email, cart_productID, cart_productIMG, cart_productIMG_2, cart_productIMG_3, cart_category, 
      cart_subtitles, cart_titles, cart_price, cart_discount, cart_quantity, added_to_cart
  ) VALUES (
      '$userEmail', $productID, '$productIMG', '$productIMG_2', '$productIMG_3', '$category',
      '$subtitles', '$titles', '$price', '$discount', $quantity, NOW()
  )";

      if ($conn->query($insertQuery) === TRUE) {
         header("Location: product.php?id=$productID&first_name=" . urlencode($firstName) . "&email=" . urlencode($userEmail));
      exit();
        } else {
            echo "Error inserting product into cart: " . $conn->error;
            exit();
        }
    }
}

// ✅ 2. Load product from GET ?id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}
$productID = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM product_table WHERE productID = ?");
$stmt->bind_param("i", $productID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found.");
}

$product = $result->fetch_assoc();

// Optional: Calculate discounted price
$price = $product['price'];
$discount = $product['discount'];

// Close DB resources
$stmt->close();
$conn->close();
?>



<?php
include 'db_connection.php';
include 'navbar.php';

// Fetch product details...
// Fetch related products...
// Fetch average review
$stmt = $conn->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE productID = ?");
$stmt->bind_param("i", $product['productID']);
$stmt->execute();
$result = $stmt->get_result();
$ratingData = $result->fetch_assoc();
$avgRating = round($ratingData['avg_rating'], 1);
$totalReviews = $ratingData['total_reviews'];
?>

<!-- your HTML for displaying product and average rating -->

<?php
$conn->close(); // ← Close here only after all queries are done
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($product['titles']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function showTab(tabId) {
      const tabs = document.querySelectorAll('.tab-content');
      tabs.forEach(tab => tab.classList.add('hidden'));
      document.getElementById(tabId).classList.remove('hidden');

      const buttons = document.querySelectorAll('.tab-button');
      buttons.forEach(btn => btn.classList.remove('text-red-600', 'border-red-500'));
      document.querySelector(`[data-tab='${tabId}']`).classList.add('text-red-600', 'border-red-500');
    }
  </script>
</head>
<body class="bg-white text-gray-800 font-sans">

  <!-- Breadcrumb -->
  <div class="bg-cyan-100 py-3 px-4">
    <div class="max-w-6xl mx-auto text-sm text-gray-700">
      <a href="index.php" class="hover:underline">Home</a> / 
      <a href="#" class="hover:underline"><?= htmlspecialchars($product['category']) ?></a> / 
      <?= htmlspecialchars($product['titles']) ?>
    </div>
  </div>

  <!-- Product Section -->
  <div class="max-w-6xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-2 gap-8">

    <!-- Product Images -->
    <div class="space-y-4">
<!-- Main product image -->
<!-- Main product image -->
<img
  id="mainProductImage"
  src="data:image/jpeg;base64,<?= $product['productIMG'] ?>"
  alt="Main Product Image"
  class="w-full rounded mb-3 object-cover"
/>

<!-- Thumbnail images container -->
<div class="flex space-x-2">
  <?php if (!empty($product['productIMG'])): ?>
    <img
      src="data:image/jpeg;base64,<?= $product['productIMG'] ?>"
      alt="<?= htmlspecialchars($product['titles']) ?> Image 1"
      class="w-16 h-16 rounded cursor-pointer object-cover border border-gray-300"
      onclick="document.getElementById('mainProductImage').src=this.src"
    />
  <?php endif; ?>

  <?php if (!empty($product['productIMG_2'])): ?>
    <img
      src="data:image/jpeg;base64,<?= $product['productIMG_2'] ?>"
      alt="<?= htmlspecialchars($product['titles']) ?> Image 2"
      class="w-16 h-16 rounded cursor-pointer object-cover border border-gray-300"
      onclick="document.getElementById('mainProductImage').src=this.src"
    />
  <?php endif; ?>

  <?php if (!empty($product['productIMG_3'])): ?>
    <img
      src="data:image/jpeg;base64,<?= $product['productIMG_3'] ?>"
      alt="<?= htmlspecialchars($product['titles']) ?> Image 3"
      class="w-16 h-16 rounded cursor-pointer object-cover border border-gray-300"
      onclick="document.getElementById('mainProductImage').src=this.src"
    />
  <?php endif; ?>
</div>


    </div>

    <!-- Product Info -->
    <div>
      <?php if ($discount > 0 && $discount < $price): ?>
        <p class="text-sm text-red-500 font-medium mb-1">Sale</p>
      <?php endif; ?>

      <h1 class="text-2xl font-bold mb-2"><?= htmlspecialchars($product['titles']) ?></h1>
      <p class="text-gray-700 mb-4"><?= htmlspecialchars($product['subtitles']) ?></p>

<?php if ($totalReviews > 0): ?>
  <div class="flex items-center gap-2 mb-5">
    <div class="text-yellow-500 text-2xl">
      <?php
        $fullStars = floor($avgRating);
        $halfStar = ($avgRating - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

        echo str_repeat('★', $fullStars);
        if ($halfStar) echo '½';
        echo str_repeat('☆', $emptyStars);
      ?>
    </div>
    <span class="text-sm text-gray-600 font-medium">
      <?= $avgRating ?>/5 <span class="text-gray-400">·</span> <?= $totalReviews ?> review<?= $totalReviews > 1 ? 's' : '' ?>
    </span>
  </div>
<?php else: ?>
  <p class="text-sm text-gray-400 italic mb-4">No reviews yet</p>
<?php endif; ?>


    <div class="mb-1">
  <?php if ($discount > 0 && $discount < $price): ?>
    <?php
      $discountPercent = round((($price - $discount) / $price) * 100);


    ?>
    <span class="line-through text-gray-400 mr-2">Tk.<?= number_format($price, 2) ?></span>
    <span class="text-xl font-semibold text-red-600 mr-2">
      Tk.<?= number_format($discount, 2) ?>
    </span>
    <span class="inline-block bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded">
      -<?= $discountPercent ?>%
    </span>
  <?php else: ?>
    <span class="text-xl font-semibold text-gray-900">Tk.<?= number_format($price, 2) ?></span>
  <?php endif; ?>
</div>


     <div class="mb-4 text-green-600 text-sm">
  <?= htmlspecialchars($product['quantity']) ?> in stock
</div>

<form method="POST" action="product.php?id=<?php echo $productID; ?>" class="space-y-4">
   <input type="hidden" name="productID" value="<?php echo $productID; ?>">
  <input type="hidden" name="quantity" value="1">
  <input type="hidden" name="productIMG" value="<?php echo urlencode($product['productIMG']); ?>">
  <input type="hidden" name="productIMG_2" value="<?php echo urlencode($product['productIMG_2']); ?>">
  <input type="hidden" name="productIMG_3" value="<?php echo urlencode($product['productIMG_3']); ?>">
  <input type="hidden" name="category" value="<?php echo htmlspecialchars($product['category']); ?>">
  <input type="hidden" name="subtitles" value="<?php echo htmlspecialchars($product['subtitles']); ?>">
  <input type="hidden" name="titles" value="<?php echo htmlspecialchars($product['titles']); ?>">
  <input type="hidden" name="discount" value="<?php echo htmlspecialchars($product['discount']); ?>">
  <input type="hidden" name="price" value="<?php echo htmlspecialchars($product['price']); ?>">
 
  <div class="flex items-center gap-4">
    <label for="quantity" class="font-medium text-gray-700">Quantity:</label>
    <input 
      type="number" 
      name="quantity" 
      id="quantity" 
      value="1" 
      min="1" 
      max="<?= htmlspecialchars($product['quantity']) ?>" 
      required 
      class="w-24 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500"
    >
  </div>
  

  <button 
    type="submit" 
    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg transition duration-200 shadow-md"
  >
    Add to Cart
  </button>
</form>


<?php if (isset($_GET['msg']) && $_GET['msg'] === 'added_to_cart'): ?>
    <p style="color: green;">Product added to cart!</p>
<?php endif; ?>

<form id="wishlistForm" action="add_to_wishlist.php" method="get">
    <input type="hidden" name="productID" value="<?= $product['productID'] ?>">
    <input type="hidden" name="email" value="<?= $_SESSION['email'] ?>">
    <input type="hidden" name="titles" value="<?= htmlspecialchars($product['titles']) ?>">

    <button id="addWishlistBtn"
  type="button"
  class="w-full mt-3 bg-white hover:bg-red-100 text-red-600 border border-red-400 font-semibold py-2.5 rounded-lg flex items-center justify-center gap-2 transition duration-200 shadow-sm">
  <img src="ress/heart.png" alt="Heart Icon" class="h-5 w-5">
  <span>Add to Wishlist</span>
</button>


    <!-- Wishlist Modal (unchanged) -->
    <div id="wishlistModal"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
      <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full text-center relative">
        <img src="ress/heart.png" alt="Heart Icon" class="w-10 h-10 mx-auto mb-4">
        <p class="text-gray-800 text-lg mb-6">Product added to Wishlist</p>
        <div class="flex justify-center gap-3">
          <button onclick="closeWishlistModal()"
              class="bg-gray-200 text-black px-4 py-2 rounded flex items-center gap-1 hover:bg-gray-300 transition focus:outline-none focus:ring-0">
            <img src="ress/close-icon.png" alt="Close" class="h-3 w-3"> Close
          </button>
          <a href="user_mycart.php?first_name=<?= urlencode($_SESSION['first_name']) ?>&email=<?= urlencode($_SESSION['email']) ?>&showWishlist=1#wishlistContent"
             class="bg-black text-white px-4 py-2 rounded flex items-center gap-1 hover:bg-gray-800 transition">
            <img src="ress/heart.png" alt="Heart" class="h-4 w-4"> View Wishlist
          </a>
        </div>
      </div>
    </div>
</form>

<script>
  document.getElementById('addWishlistBtn').addEventListener('click', function() {
    const form = document.getElementById('wishlistForm');
    // Submit form data via fetch GET
    const params = new URLSearchParams(new FormData(form)).toString();
    fetch(form.action + '?' + params)
      .then(response => {
        if (response.ok) {
          // Show modal on successful add
          document.getElementById('wishlistModal').classList.remove('hidden');
        } else {
          alert('Failed to add to wishlist');
        }
      })
      .catch(() => alert('Network error adding to wishlist'));
  });

  function closeWishlistModal() {
    document.getElementById('wishlistModal').classList.add('hidden');
  }
</script>



      <div class="mt-4 text-sm text-gray-700">
        <p>Order by Phone/Whatsapp or Facebook</p>
        <p>📞 01747536594</p>
        <p>💬 info@yummy.com</p>
      </div>
    </div>
  </div>

<!-- Product Description Tabs -->
<div class="max-w-6xl mx-auto px-4 mt-10">
  <div class="border-b border-gray-200">
    <nav class="flex space-x-4">
      <button class="py-2 px-4 tab-button text-red-600 border-b-2 border-red-500 font-medium" data-tab="description" onclick="showTab('description')">Description</button>
      <button class="py-2 px-4 tab-button text-gray-600 hover:text-red-600" data-tab="additional" onclick="showTab('additional')">Additional information</button>
      <button class="py-2 px-4 tab-button text-gray-600 hover:text-red-600" data-tab="reviews" onclick="showTab('reviews')">Reviews</button>
    </nav>
  </div>

  <!-- Description Tab -->
  <div id="description" class="tab-content mt-4 text-sm text-gray-700">
    <p><strong>Product Description:</strong></p>
    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
  </div>

  <!-- Additional Information Tab -->
  <div id="additional" class="tab-content hidden mt-4 text-sm text-gray-700">
    <p><strong>Additional Information:</strong></p>
    <p><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></p>
    <p><strong>Quantity Available:</strong> <?= htmlspecialchars($product['quantity']) ?></p>
    <!-- Add more fields as necessary -->
  </div>

  <!-- Reviews Tab -->
  <div id="reviews" class="tab-content hidden mt-4 text-sm text-gray-700">
    <?php
    include('db_connection.php'); 
    $productID = $_GET['id'] ?? 0;

    $stmt = $conn->prepare("SELECT reviewID, name, email, rating, comment, created_at FROM reviews WHERE productID = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();

   if ($result->num_rows > 0) {
    while ($review = $result->fetch_assoc()) {
        ?>
        <div class="mb-4 border-b pb-2">
            <strong><?= htmlspecialchars($review['name']) ?></strong>
            <span class="ml-2 text-yellow-500"><?= str_repeat('★', (int)$review['rating']) ?></span>
            <p class="mt-1"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
            <small class="text-gray-400"><?= $review['created_at'] ?></small>

            <?php if (isset($_SESSION['email']) && $_SESSION['email'] === $review['email']): ?>
                <form action="delete_review.php" method="post" onsubmit="return confirm('Delete this review?');" class="inline-block ml-4">
                    <input type="hidden" name="reviewID" value="<?= $review['reviewID'] ?>">
                    <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                </form>
            <?php endif; ?>
        </div>
        <?php
    }
} else {
    echo "<p>No reviews yet. Be the first to review this product!</p>";
}
?>


    <?php if (isset($_SESSION['email'])): ?>
        <form action="submit_review.php" method="post" class="mt-6 space-y-3">
            <input type="hidden" name="productID" value="<?= htmlspecialchars($productID) ?>">
            
            <label for="rating" class="block font-medium">Rating:</label>
            <select name="rating" id="rating" required class="w-full p-2 border rounded">
                <option value="">Select rating</option>
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Poor</option>
                <option value="1">1 - Terrible</option>
            </select>
            
            <label for="comment" class="block font-medium">Your Review:</label>
            <textarea name="comment" id="comment" rows="4" required placeholder="Write your review..." class="w-full p-2 border rounded"></textarea>
            
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Submit Review</button>
        </form>
    <?php else: ?>
        <p class="mt-4 text-red-600">Please <a href="login.php" class="underline">log in</a> to submit a review.</p>
    <?php endif; ?>
  </div>
</div>

<script>
  function showTab(tabName) {
    // Hide all tab contents
    const tabs = document.querySelectorAll('.tab-content');
    tabs.forEach(tab => tab.classList.add('hidden'));

    // Remove active styling from all buttons
    const buttons = document.querySelectorAll('.tab-button');
    buttons.forEach(btn => {
      btn.classList.remove('text-red-600', 'border-red-500', 'border-b-2', 'font-medium');
      btn.classList.add('text-gray-600', 'hover:text-red-600');
    });

    // Show selected tab content
    document.getElementById(tabName).classList.remove('hidden');

    // Highlight active tab button
    const activeBtn = document.querySelector(`.tab-button[data-tab="${tabName}"]`);
    if (activeBtn) {
      activeBtn.classList.add('text-red-600', 'border-red-500', 'border-b-2', 'font-medium');
      activeBtn.classList.remove('text-gray-600', 'hover:text-red-600');
    }
  }

  // Show Description tab by default on page load
  document.addEventListener('DOMContentLoaded', () => {
    showTab('description');
  });
</script>


<?php
// Example: product.php?id=123
$productID = intval($_GET['id'] ?? 0);

// Fetch current product info
$stmt = $conn->prepare("SELECT * FROM product_table WHERE productID = ?");
$stmt->bind_param("i", $productID);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "Product not found!";
    exit;
}

$currentCategory = $product['category'];
$stmt2 = $conn->prepare("SELECT * FROM product_table WHERE category = ? AND productID != ? LIMIT 10");
$stmt2->bind_param("si", $currentCategory, $productID);
$stmt2->execute();
$relatedResult = $stmt2->get_result();


?>
<?php if ($relatedResult->num_rows > 0): ?>
  <section class="max-w-6xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold mb-6">Related Products</h2>

    <div class="products-container grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
      <?php while ($row = $relatedResult->fetch_assoc()): ?>

        <?php
          // Query average rating and count for this product
          $stmt = $conn->prepare("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE productID = ?");
          $stmt->bind_param("i", $row['productID']);
          $stmt->execute();
          $res = $stmt->get_result()->fetch_assoc();

          $avg = $res['avg_rating'];
          $total = $res['total_reviews'];
          $full = floor($avg);
          $half = ($avg - $full) >= 0.5;
          $empty = 5 - $full - ($half ? 1 : 0);
        ?>

        <div class="bg-white p-4 rounded shadow flex flex-col h-full">
          <img src="data:image/jpeg;base64,<?= $row['productIMG']; ?>" alt="Product Image" class="h-48 w-full object-cover rounded mb-3">

          <p class="text-sm text-gray-500 mb-1 line-clamp-2"><?= htmlspecialchars($row['subtitles']) ?></p>

          <?php if ($total > 0): ?>
            <div class="flex items-center gap-1 text-yellow-500 text-xl mb-2">
              <?php for ($i = 0; $i < $full; $i++): ?><span>★</span><?php endfor; ?>
              <?php if ($half): ?><span>⯪</span><?php endif; ?>
              <?php for ($i = 0; $i < $empty; $i++): ?><span class="text-gray-300">★</span><?php endfor; ?>
              <span class="text-gray-500 text-xs ml-1">(<?= number_format($avg,1) ?>/5)</span>
            </div>
          <?php endif; ?>

          <h2 class="font-semibold text-lg mb-1"><?= htmlspecialchars($row['titles']) ?></h2>

          <p class="text-orange-600 font-semibold mb-4">Tk.<?= htmlspecialchars($row['price']) ?></p>

          <div class="mt-auto">
            <a href="product.php?id=<?= $row['productID'] ?>&first_name=<?= urlencode($first_name) ?>&email=<?= urlencode($email) ?>">
              <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded w-full">
                View Product
              </button>
            </a>
          </div>
        </div>

      <?php endwhile; ?>
    </div>
  </section>
<?php endif; ?>





  <!-- Footer -->
  <!-- Paste your footer code here -->

   <!-- Footer -->
<!-- footer section -->
<footer>
  <div class="bg-black mt-5 px-8 py-16">

    <!-- part-A -->
    <div class="text-red-50 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-8">

      <!-- column-1 -->
      <div>
        <div class="pb-2 font-semibold">About</div>
        <div class="text-gray-400">Company</div>
        <div class="text-gray-400">Orders</div>
        <div class="text-gray-400">Quality</div>
        <div class="text-gray-400">Privacy Policy</div>
        <div class="text-gray-400">Gift Cards</div>
      </div>

      <!-- column-2 -->
      <div>
        <div class="pb-2 font-semibold">Help</div>
        <div class="text-gray-400">My Account</div>
        <div class="text-gray-400">Customer Help</div>
        <div class="text-gray-400">Contact Us</div>
        <div class="text-gray-400">Terms & Conditions</div>
        <div class="text-gray-400">FAQ</div>
      </div>

      <!-- column-3 -->
      <div>
        <div class="pb-2 font-semibold">Follow</div>
        <div class="text-gray-400">Facebook</div>
        <div class="text-gray-400">Instagram</div>
        <div class="text-gray-400">Pinterest</div>
        <div class="text-gray-400">Youtube</div>
      </div>

      <!-- column-4 -->
      <div>
        <div class="pb-2 font-semibold">Address</div>
        <div class="text-gray-400">
          BA-2/3/A (1st Floor), South Badda<br>
          (Near Sahaba Mosque via Police Plaza Bypass<br>
          Road), Hatir Jheel, Dhaka – 1212, Bangladesh.<br>
          Phone / Whatsapp : +88 01747 536594
        </div>
      </div>

    </div>

    <!-- part-B -->
    <div class="text-white pt-14">
      <hr class="border-gray-700">
      <div class="flex justify-center text-center pt-3 text-sm">
        All Rights Reserved © Yummy.com 2025
      </div>
    </div>

  </div>
</footer>



</body>
</html>
