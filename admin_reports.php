<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="LOGO.png">
    <title>Admin Panel</title>
</head>
<body>

<!-- full_container -->
<div class="flex">
<!-- option_panel -->
<div class="w-2/12 h-dvh bg-indigo-600">

<div class="flex justify-center"><img src="ress/male-avatar.png" alt="" height="165px" width="165px"> </div>

<!-- bio -->
<div class="text-sm text-center text-white">@admin</div>
<div class="text-sm text-center text-white">System Administrator</div>

<a href="admin.php"><div class="flex items-center text-white hover:bg-white hover:text-black cursor-pointer p-2 mt-5"><i class="fa fa-dashboard mr-1" style="font-size:20px"></i>Dashboard</div></a>
<a href="admin_customers.php"><div class="flex items-center text-white hover:bg-white hover:text-black cursor-pointer p-2"><i class='fa fa-users mr-1' style='font-size:17px'></i>Customers</div></a>
<a href="admin_orders.php"><div class="flex items-center text-white hover:bg-white hover:text-black cursor-pointer p-2"><i class='fa fa-shopping-cart mr-1.5' style='font-size:20px'></i>Orders</div></a>
 <a href="admin_products.php"><div class="flex items-center text-white hover:bg-white hover:text-black cursor-pointer p-2 mb-1 rounded"><i class='fa fa-cubes mr-2' style='font-size:20px'></i>Products</div></a>
       
<a href="admin_comments.php"><div class="flex items-center text-white hover:bg-white hover:text-black cursor-pointer p-2"> <i class='fa fa-comment mr-1' style='font-size:19px'></i>Comments</div></a>
<a href="admin_reports.php"><div class="flex items-center text-black    bg-white hover:text-black cursor-pointer p-2"><i class='fa fa-exclamation-triangle mr-1.5' style='font-size:19px'></i>Reports</div></a>
<a href="admin_settings.php"><div class="flex items-center text-white hover:bg-white hover:text-black cursor-pointer p-2"><i class="fa fa-gear mr-1" style="font-size:24px"></i>Settings</div></a>



 </div>





<!-- dashboard -->
<div class="w-10/12 h-dvh p-8">
    
<!-- logout_panel -->
    <div class="flex justify-end"><a href="http://localhost/Project/login.php"><button class="pt-1 pb-1 pl-2 pr-2 rounded-lg bg-blue-600 text-white">Logout</button></a></div>


      <div class="text-4xl flex justify-center">Reports Panel Coming Soon!</div>






</div>



<!-- customers -->
<!-- <div class="w-10/12 h-dvh p-6">
    
</div> -->


<!-- products -->
<!-- <div class="w-10/12 h-dvh p-6">
    
</div> -->


<!-- comments -->
<!-- <div class="w-10/12 h-dvh p-6">
    
</div> -->


<!-- settings -->
<!-- <div class="w-10/12 h-dvh p-6">
    
</div> -->



</div>




<!-- 
<style>
  *{

    outline: 1px solid red;
  }
</style> -->


</body>
</html>