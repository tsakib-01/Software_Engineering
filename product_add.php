<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

    <div class="container mx-auto p-8">
        <!-- Back Button at the Top -->
       <a href="admin.php"> <button class="back-btn bg-gray-600 text-white py-2 px-4 rounded-lg mb-8">Back</button>
       </a>
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-semibold text-gray-900">Product Management</h1>
            <p class="text-gray-600 mt-2">Efficiently manage your products with the tools below.</p>
        </div>

        <!-- Add New Product Form -->
        <form class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-xl space-y-6">
            <h2 class="text-2xl font-semibold text-gray-800">Add New Product</h2>
            
            <!-- Product Name -->
            <div>
                <label for="product-name" class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" id="product-name" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter product name" required>
            </div>

            <!-- Price -->
            <div>
                <label for="product-price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" id="product-price" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter price" required>
            </div>

            <!-- Quantity -->
            <div>
                <label for="product-quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="number" id="product-quantity" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter quantity" required>
            </div>

            <!-- Description -->
            <div>
                <label for="product-description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="product-description" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter product description" rows="4" required></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Add Product</button>
        </form>

        <!-- Product List Table -->
        <div class="mt-12">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Product List</h2>

            <div class="overflow-x-auto bg-white rounded-lg shadow-lg">
                <table class="min-w-full table-auto">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Product Image</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Product Name</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Product Subtitle</th>
                           
                            <th class="px-6 py-3 text-left text-sm font-semibold">Price</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Quantity</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    
                    <tbody class="text-gray-800">
                        <!-- Sample Products -->
                        <tr class="border-t">
                            <td class="px-6 py-4 text-sm">
                                <img src="images/Breakfast/Omelette.jpg" alt="Classic Omelette" class="w-16 h-16 object-cover rounded">
                            </td>
                            <td class="px-6 py-4 text-sm">Special Omelette</td>
                            <td class="px-6 py-4 text-sm">Special Omelette Sub</td>
                            <td class="px-6 py-4 text-sm">Tk. 250.00</td>
                            <td class="px-6 py-4 text-sm">50</td>
                            <td class="px-6 py-4 text-sm flex items-center space-x-4">
                                <button class="text-blue-500 hover:text-blue-700">Edit</button>
                                <button class="text-red-500 hover:text-red-700">Delete</button>
                                <input type="file" class="text-sm text-gray-500" />
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm">
                                <img src="images\Beverages\Fresh Orange Juice.jpg" alt="Classic Omelette" class="w-16 h-16 object-cover rounded">
                            </td>
                            <td class="px-6 py-4 text-sm">Orange Juice</td>
                            <td class="px-6 py-4 text-sm">Orange Juice Sub</td>
                            <td class="px-6 py-4 text-sm">Tk. 1200.00</td>
                            <td class="px-6 py-4 text-sm">30</td>
                            <td class="px-6 py-4 text-sm flex items-center space-x-4">
                                <button class="text-blue-500 hover:text-blue-700">Edit</button>
                                <button class="text-red-500 hover:text-red-700">Delete</button>
                                <input type="file" class="text-sm text-gray-500" />
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-sm">
                                <img src="images\Beverages\Lemon juice.jpg" alt="Classic Omelette" class="w-16 h-16 object-cover rounded">
                            </td>
                            <td class="px-6 py-4 text-sm">Lemon Juice</td>
                            <td class="px-6 py-4 text-sm">Lemon Juice Sub</td>
                            <td class="px-6 py-4 text-sm">Tk. 100.00</td>
                            <td class="px-6 py-4 text-sm">75</td>
                            <td class="px-6 py-4 text-sm flex items-center space-x-4">
                                <button class="text-blue-500 hover:text-blue-700">Edit</button>
                                <button class="text-red-500 hover:text-red-700">Delete</button>
                                <input type="file" class="text-sm text-gray-500" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Save Button at the Bottom Right -->
        <!-- <button class="save-btn bg-green-600 text-white py-2 px-4 rounded-lg fixed bottom-8 right-8 shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">Save</button>
    </div> -->


     <a href="create_product.php"><button class="save-btn bg-green-600 text-white py-2 px-4 rounded-lg fixed bottom-8 right-8 shadow-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">New Product Create</button>
    </div></a>

</body>
</html>
