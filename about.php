 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
 </head>
 <body>

 <?php
 session_start();
  include 'db_connection.php';
include 'navbar.php';
 ?>
  
  

 
 <!-- About Section -->
 <section id="about" class="container mx-auto px-4 py-16">
    <div class="text-center mb-8">
      
      <h2 class="text-4xl font-bold">
        Learn More <span class="text-red-600">About Us</span>
      </h2>
    </div>

    <div id="book_a_table" class="flex flex-col md:flex-row gap-12 items-start">
      <!-- Left Image & Box -->
      <div class="md:w-3/5 space-y-6">
        <img
          src="images/about.jpg"
          alt="Restaurant Interior"
          class="rounded-lg shadow"
        />
        <a href="contact.php" class="block border-2 border-gray-300 p-4 text-center hover:bg-red-600 hover:text-white transition-all duration-300">
            <h4 class="text-lg font-semibold mb-1">Order Now</h4>
            <p class="text-xl font-bold">+88 01747 536594</p>
          </a>
          
          
      </div>

      <!-- Right Text & Video -->
      <div class="md:w-2/5 space-y-6">
        <p class="text-gray-600">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
          eiusmod tempor incididunt ut labore et dolore magna aliqua.
        </p>

        <ul class="space-y-3">
          <li class="flex items-start">
            <span class="text-red-600 mr-2 text-lg">✔️</span> Ullamco laboris
            nisi ut aliquip ex ea commodo consequat.
          </li>
          <li class="flex items-start">
            <span class="text-red-600 mr-2 text-lg">✔️</span> Duis aute irure
            dolor in reprehenderit in voluptate velit.
          </li>
          <li class="flex items-start">
            <span class="text-red-600 mr-2 text-lg">✔️</span> Ullamco laboris
            nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate tridenta storacalaperda mastiro dolore
            eu fugiat nulla pariatur.
          </li>
        </ul>

        <p class="text-gray-600">
          Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
          irure dolor in reprehenderit in voluptate velit esse cillum dolore
          eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident.
        </p>

        <div class="relative">
          <img
            src="images/about-2.jpg"
            alt="Food Dishes"
            class="rounded-lg"
          />
          <!-- <button onclick="alert('Play Video')" class="absolute inset-0 flex items-center justify-center text-white text-4xl bg-black bg-opacity-50 hover:bg-opacity-60 transition">
          ▶️
        </button> -->
          <a
            href="https://www.youtube.com/watch?v=kRCH8kD1GD0"
            target="_blank"
            class="absolute inset-0 flex items-center justify-center text-white text-5xl bg-black bg-opacity-50 hover:bg-opacity-60 transition duration-300"
          >
            ▶️
          </a>
        </div>
      </div>
    </div>
  </section>



  
<!-- footer section -->
<footer>
    <div class="bg-black  px-8 py-16">
  
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