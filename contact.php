<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';

    $sql = "INSERT INTO contact (full_name, email, subject, message) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $fullName, $email, $subject, $message);

    if ($stmt->execute()) {
        $successMessage = "Your message has been sent. Thank you!";
    } else {
        $errorMessage = "Failed to send message. Please try again.";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
    <!-- navbar_start -->
     <?php
 session_start();
  include 'db_connection.php';
include 'navbar.php';
 ?>
      <!-- navbar_end -->


<body>

    <!-- Google Map Embed -->
<div class="w-full h-[400px]   overflow-hidden ">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d57903.02583803915!2d91.81983548314598!3d24.900058347722897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x375054d3d270329f%3A0xf58ef93431f67382!2sSylhet%2C%20Bangladesh!5e0!3m2!1sen!2sus!4v1745686971692!5m2!1sen!2sus" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
  

    <section class="min-h-screen bg-gray-50 flex items-center justify-center px-6 md:px-12 py-16">
        <div class="w-full max-w-7xl bg-white rounded-3xl shadow-lg overflow-hidden grid grid-cols-1 md:grid-cols-2">
      
          <!-- Left Info Side -->
          <div class="bg-gradient-to-br from-orange-100 to-orange-200 p-10 flex flex-col justify-center space-y-12">
            <!-- Phone -->
            <div class="flex items-center space-x-4">
              <div class="bg-white p-4 rounded-full text-orange-500">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M6.62 10.79a15.534 15.534 0 006.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.24.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                </svg>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-gray-700">Phone</h4>
                <p class="text-gray-600">+88 01747 536594</p>
                <p class="text-gray-600">+88 01747 111111</p>
              </div>
            </div>
      
            <!-- Email -->
            <div class="flex items-center space-x-4">
              <div class="bg-white p-4 rounded-full text-orange-500">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 13.5l-11-7v11c0 1.1.9 2 2 2h18c1.1 0 2-.9 2-2v-11l-11 7zm0-2.5l11-7h-22l11 7z"/>
                </svg>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-gray-700">Email</h4>
                <p class="text-gray-600">info@yummy.com</p>
                <p class="text-gray-600">tsakibxxx9111@gmail.com</p>
              </div>
            </div>
      
            <!-- Address -->
            <div class="flex items-center space-x-4">
              <div class="bg-white p-4 rounded-full text-orange-500">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 2C8.14 2 5 5.14 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.86-3.14-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.76-2.24 5-5 5s-5-2.24-5-5z"/>
                </svg>
              </div>
              <div>
                <h4 class="text-lg font-semibold text-gray-700">Address</h4>
                <p class="text-gray-600">BA-2/3/A (1st Floor), South Badda
                    (Near Sahaba Mosque via Police Plaza Bypass
                    Road), Hatir Jheel, Dhaka – 1212, Bangladesh.</p>
              </div>
            </div>
          </div>
      
          <!-- Right Form Side -->
          <div class="p-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Get In Touch</h2>
            <p class="text-gray-500 mb-8">We'd love to hear from you. Please fill out the form below!</p>
            <form action="contact.php" method="POST" class="space-y-6">

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
  <input type="text" name="full_name" placeholder="Full Name" class="w-full border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-orange-400">
  <input type="email" name="email" placeholder="Email Address" class="w-full border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-orange-400">
</div>

<input type="text" name="subject" placeholder="Subject" class="w-full border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-orange-400">

<textarea name="message" rows="5" placeholder="Your Message" class="w-full border border-gray-300 rounded-xl p-4 focus:ring-2 focus:ring-orange-400"></textarea>

<button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 rounded-xl transition duration-300">
  Send Message
</button>

</form>
<?php if (!empty($successMessage)): ?>
    <p class="text-green-600 font-bold mt-4"><?php echo $successMessage; ?></p>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <p class="text-red-600 font-bold mt-4"><?php echo $errorMessage; ?></p>
<?php endif; ?>


          </div>
      
        </div>
      </section>
      
<!-- footer section -->
<footer>
    <div class="bg-black  px-8 py-16">
  
      <!-- part-A -->
      <div class="text-red-50 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div>
          <div class="pb-2 font-semibold">About</div>
          <div class="text-gray-400">Company</div>
          <div class="text-gray-400">Orders</div>
          <div class="text-gray-400">Quality</div>
          <div class="text-gray-400">Privacy Policy</div>
          <div class="text-gray-400">Gift Cards</div>
        </div>
        <div>
          <div class="pb-2 font-semibold">Help</div>
          <div class="text-gray-400">My Account</div>
          <div class="text-gray-400">Customer Help</div>
          <div class="text-gray-400">Contact Us</div>
          <div class="text-gray-400">Terms & Conditions</div>
          <div class="text-gray-400">FAQ</div>
        </div>
        <div>
          <div class="pb-2 font-semibold">Follow</div>
          <div class="text-gray-400">Facebook</div>
          <div class="text-gray-400">Instagram</div>
          <div class="text-gray-400">Pinterest</div>
          <div class="text-gray-400">Youtube</div>
        </div>
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

<!-- Toggle Script -->
<script>
  document.getElementById('menu-btn').addEventListener('click', function () {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
  });
</script>

<script>
document.getElementById("contactForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch("submit_contact.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast("Your message has been sent. Thank you!");
            form.reset();
        } else {
            showToast("Failed to send message. Please try again.");
        }
    })
    .catch(() => {
        showToast("Something went wrong. Please try again.");
    });
});

function showToast(message) {
    const toast = document.createElement("div");
    toast.className = "fixed bottom-5 right-5 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg animate-fade-in-out z-50";
    toast.textContent = message;

    document.body.appendChild(toast);

    setTimeout(() => toast.remove(), 4000);
}
</script>

<style>
@keyframes fade-in-out {
  0% {opacity: 0; transform: translateY(20px);}
  10% {opacity: 1; transform: translateY(0);}
  90% {opacity: 1;}
  100% {opacity: 0; transform: translateY(20px);}
}
.animate-fade-in-out {
  animation: fade-in-out 4s ease-in-out;
}
</style>


</body>
</html>
