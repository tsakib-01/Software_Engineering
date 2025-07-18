# Software_Engineering

# Project Title: Restaurant Management System

## 🔍 Short Description
A web-based restaurant management system where customers can view the menu, make reservations, and admins can manage products and reservations.

## 👥 Team Members
- **Tasnim Anjum Sakib** – Frontend & Backend Developer (TailwindCSS, PHP, MySQL)
- **Sujoy Das Arnab** – Frontend & Backend Developer (TailwindCSS, PHP, MySQL)


## ⚙️ Setup and Installation
1. Clone the repo: `git clone https://github.com/tsakib-01/Software_Engineering.git`
2. Import the `database/rms_project.sql` into your MySQL server.
3. Configure your `db_connection.php` file with your database credentials.
4. Run the project using XAMPP or your preferred local server.


Import the database

   * Locate and import `database/rms_project.sql` into your MySQL server using phpMyAdmin or CLI.

Configure your database connection

   * Open `db_connection.php` and update with your MySQL credentials:

     ```php
     $servername = "localhost";
     $username = "your_username";
     $password = "your_password";
     $dbname = "rms_project";
     ```

Start your local server

   * Use **XAMPP** or any local PHP server and navigate to the project directory.

---
## 🖼️ Project Preview

Here are screenshots showcasing various features of our Restaurant Management System:

---

### 🌐 General Pages

#### 🏠 Home Page (Index)
A visually engaging homepage with navigation to menu, login, signup, and more.
<img width="940" height="433" alt="Index" src="https://github.com/user-attachments/assets/815cd70b-8d77-4002-9f5b-a6d60d8bed02" />

#### 📝 Signup Page
Simple registration form with required input fields and validation.
<img width="625" height="347" alt="Signup" src="https://github.com/user-attachments/assets/12b028a5-0ed4-48f5-92a4-4919032d452c" />

#### 📝 Register Page
Alternative user registration view for new customers.
<img width="574" height="411" alt="Register" src="https://github.com/user-attachments/assets/f5f6c4e6-1e09-4365-a8c4-67af7ea87325" />

#### 🔐 Login Page
Secure login interface with error handling and redirection.
<img width="941" height="424" alt="Login Page" src="https://github.com/user-attachments/assets/e82a59b1-8a24-470a-aa60-f00e289e4cc1" />

#### 📆 Table Booking Reservation
Allows users to select date/time and reserve tables.
<img width="928" height="428" alt="Booking Reservation" src="https://github.com/user-attachments/assets/713c9cab-eb49-46c2-b679-65215102ca4b" />

#### 📋 Menu Filter
Dynamically filter dishes by category or availability.
<img width="365" height="252" alt="Menu Filter" src="https://github.com/user-attachments/assets/3024ba85-95e8-41bb-8aee-efd65a4971ab" />

#### 🔎 Searchable Product
Instant search with real-time filtering of menu items.
<img width="943" height="422" alt="Searchable Product" src="https://github.com/user-attachments/assets/dc82866c-3558-41b6-8473-d8c4122c12ed" />

#### 🛍️ Product Page & Reviews
Displays detailed product info with user-generated reviews.
<img width="360" height="413" alt="Product Page" src="https://github.com/user-attachments/assets/a5f77e91-c279-4141-8a0d-38a7283965fa" />

---

### 👤 User Panel

#### 🛒 User Cart
Interactive cart page showing selected items with pricing.
<img width="904" height="277" alt="User Cart" src="https://github.com/user-attachments/assets/45b381ef-ada3-4dbd-98e6-21e31f979fcc" />

#### 💬 Comments & Reviews
Users can post comments and rate food items.
<img width="940" height="413" alt="Comments" src="https://github.com/user-attachments/assets/332300af-475e-4f1b-b467-daaa393e5b37" />

#### ❤️ Wishlist
Save favorite dishes for easy future ordering.
<img width="929" height="331" alt="Wishlist" src="https://github.com/user-attachments/assets/fa41378b-53be-4e63-b058-262df44ae2b1" />

#### 📆 Booking History
Displays the user's past and upcoming table reservations.
<img width="946" height="347" alt="User Booking" src="https://github.com/user-attachments/assets/a332041f-1512-4f83-b7f5-267c2b2c3489" />

#### ⚙️ User Settings
Manage profile details, password updates, and preferences.
<img width="900" height="368" alt="User Settings" src="https://github.com/user-attachments/assets/34b0d95e-8392-4a09-8ce2-76c23d51aae2" />

#### 💳 Checkout Panel 1 – Order Summary
<img width="950" height="234" alt="Checkout 1" src="https://github.com/user-attachments/assets/63b9bd64-7182-4752-867b-d4b77a7f4d24" />

#### 💳 Checkout Panel 2 – Payment Method
<img width="290" height="317" alt="Checkout 2" src="https://github.com/user-attachments/assets/1c95ac52-7ee2-47cd-9baa-c5a8a0c99508" />

#### 💳 Checkout Panel 3 – Confirmation
<img width="274" height="116" alt="Checkout 3" src="https://github.com/user-attachments/assets/0045f0a7-63eb-41e5-94ec-2ef82d6445a6" />

---

### 🛠️ Admin Panel

#### 📊 Admin Dashboard
Quick overview of total users, orders, and key metrics.
<img width="820" height="302" alt="Admin Dashboard" src="https://github.com/user-attachments/assets/77cd6397-1b4d-4baf-92a6-b8e8625bdfa1" />

#### 📦 Inventory Overview
View, edit, and manage the product catalog.
<img width="934" height="399" alt="Inventory" src="https://github.com/user-attachments/assets/c19e3663-8c9a-4c65-9114-2488a9862bfb" />

#### ➕ Add Products
Form to add new items to the menu with validations.
<img width="887" height="437" alt="Add Product" src="https://github.com/user-attachments/assets/ab292337-d547-42fa-a0de-0959be321caa" />

#### ✏️ Edit Products
Modify product details, availability, and pricing.
<img width="668" height="431" alt="Edit Product" src="https://github.com/user-attachments/assets/3e190013-9258-474b-8c3d-ec9e120fbbb5" />

#### 👥 Manage Customers
View and manage user profiles and activity.
<img width="958" height="182" alt="Customers" src="https://github.com/user-attachments/assets/057d2ea2-b1a4-429e-adf1-ebe6469e334f" />

#### 🧾 Manage Orders
Track pending, delivered, and cancelled orders.
<img width="934" height="229" alt="Orders" src="https://github.com/user-attachments/assets/993c32e1-4592-47d9-9a5d-2b3de20407b9" />

#### 📆 Booking Management
Admin view of table reservation requests and history.
<img width="913" height="207" alt="Admin Bookings" src="https://github.com/user-attachments/assets/67ac5df3-b678-40d5-a004-79f3a9a440d7" />

#### 💬 Comment Moderation
Manage and moderate customer reviews and feedback.
<img width="856" height="404" alt="Admin Comments" src="https://github.com/user-attachments/assets/2339a08b-a090-4aa5-857c-d5008c8a5633" />

#### ⚙️ Admin Settings
Control system-level settings, password management, and more.
<img width="941" height="338" alt="Admin Settings" src="https://github.com/user-attachments/assets/2dc5a5e6-984e-48f6-9201-33d82bec8782" />



---

## 📄 License

This project is for academic purposes only. For commercial use, please contact the authors.





