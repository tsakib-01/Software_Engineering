<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body>

<!-- navbar_start --> <?php
 session_start();
  include 'db_connection.php';
include 'navbar.php';
 ?>
  
  <!-- navbar_end -->
  

    
    <!-- chefs section -->
    <section class="text-center py-16" id="chefs">

        <h2 class="text-4xl font-bold text-red-500 mb-12">
          Our Professional Chefs
        </h2>
  
        <div
          class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10 px-6"
        >
          <!-- Chef Card -->
          <div
            class="relative bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105"
          >
            <img
              src="https://bootstrapmade.com/demo/templates/Yummy/assets/img/chefs/chefs-1.jpg"
              alt="Chef 1"
              class="w-full object-cover"
            />
            <div
              class="relative z-10 mt-[-30px] bg-white p-6 rounded-t-[2rem] text-center"
            >
              <h3 class="text-lg font-bold text-gray-800">Walter White</h3>
              <p class="text-sm text-gray-500">Master Chef</p>
              <p class="mt-2 text-sm italic text-gray-600">
                Velit aut quia fugit et et. Dolorum ea voluptate vel tempore
                tenetur ipsa quae aut. Ipsum exercitationem iure minima enim
                corporis et voluptate.
              </p>
            </div>
            <div
              class="absolute top-4 right-4 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition duration-300"
            >
              <a
                href="https://facebook.com"
                target="_blank"
                class="text-blue-600 text-xl"
                ><i class="fab fa-facebook-f"></i
              ></a>
              <a
                href="https://instagram.com"
                target="_blank"
                class="text-white text-xl"
                ><i class="fab fa-instagram"></i
              ></a>
              <a
                href="https://wa.me"
                target="_blank"
                class="text-green-500 text-xl"
                ><i class="fab fa-whatsapp"></i
              ></a>
            </div>
          </div>
  
          <!-- Chef Card -->
          <div
            class="relative bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 group"
          >
            <img
              src="https://bootstrapmade.com/demo/templates/Yummy/assets/img/chefs/chefs-2.jpg"
              alt="Chef 2"
              class="w-full object-cover"
            />
            <div
              class="relative z-10 mt-[-30px] bg-white p-6 rounded-t-[2rem] text-center"
            >
              <h3 class="text-lg font-bold text-gray-800">Sarah Jhonson</h3>
              <p class="text-sm text-gray-500">Patissier</p>
              <p class="mt-2 text-sm italic text-gray-600">
                Quo esse repellendus quia id. Est eum et accusantium pariatur
                fugit nihil minima suscipit corporis. Voluptate sed quas
                reiciendis animi neque sapiente.
              </p>
            </div>
            <div
              class="absolute top-4 right-4 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition duration-300"
            >
              <a
                href="https://facebook.com"
                target="_blank"
                class="text-blue-600 text-xl"
                ><i class="fab fa-facebook-f"></i
              ></a>
              <a
                href="https://instagram.com"
                target="_blank"
                class="text-white text-xl"
                ><i class="fab fa-instagram"></i
              ></a>
              <a
                href="https://wa.me"
                target="_blank"
                class="text-green-500 text-xl"
                ><i class="fab fa-whatsapp"></i
              ></a>
            </div>
          </div>
  
          <!-- Chef Card -->
          <div
            class="relative bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 group"
          >
            <img
              src="https://bootstrapmade.com/demo/templates/Yummy/assets/img/chefs/chefs-3.jpg"
              alt="Chef 3"
              class="w-full object-cover"
            />
            <div
              class="relative z-10 mt-[-30px] bg-white p-6 rounded-t-[2rem] text-center"
            >
              <h3 class="text-lg font-bold text-gray-800">William Anderson</h3>
              <p class="text-sm text-gray-500">Cook</p>
              <p class="mt-2 text-sm italic text-gray-600">
                Vero omnis enim consequatur. Voluptas consectetur unde qui
                molestiae deserunt. Voluptates enim aut architecto porro
                aspernatur molestiae modi.
              </p>
            </div>
            <div
              class="absolute top-4 right-4 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition duration-300"
            >
              <a
                href="https://facebook.com"
                target="_blank"
                class="text-blue-600 text-xl"
                ><i class="fab fa-facebook-f"></i
              ></a>
              <a
                href="https://instagram.com"
                target="_blank"
                class="text-white text-xl"
                ><i class="fab fa-instagram"></i
              ></a>
              <a
                href="https://wa.me"
                target="_blank"
                class="text-green-500 text-xl"
                ><i class="fab fa-whatsapp"></i
              ></a>
            </div>
          </div>
        </div>
      </section>
  
    
</body>


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
</html>