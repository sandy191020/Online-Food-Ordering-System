<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

<h1>🍔 Online Food Ordering System</h1>
<p class="center"><i>A modern, interactive full-stack food ordering platform built with <b>PHP</b>, <b>MySQL</b>, <b>HTML</b>, <b>CSS</b>, and <b>JavaScript</b>.</i></p>

<div class="center">
    <span class="badge php">PHP 8.2</span>
    <span class="badge mysql">MySQL 8.0</span>
    <span class="badge js">JavaScript ES6</span>
    <span class="badge html">HTML5</span>
    <span class="badge css">CSS3</span>
</div>

<h2>📌 Project Overview</h2>
<p>This <b>Online Food Ordering System</b> allows users to:</p>
<ul>
    <li>Browse restaurants and menus</li>
    <li>Add items to cart</li>
    <li>Checkout via QR code payment</li>
    <li>View order confirmation</li>
</ul>
<p>Restaurants can register/login and manage their menu items. The project includes <b>dark mode, animations, and interactive UI</b> for a modern experience.</p>

<h2>🛠️ Technology Stack</h2>
<table>
<tr>
<th>Frontend</th>
<th>Backend</th>
<th>Database</th>
</tr>
<tr>
<td>HTML5, CSS3, JavaScript, Bootstrap 5</td>
<td>PHP</td>
<td>MySQL</td>
</tr>
</table>

<h2>⚡ Database Setup (Copy-Paste Ready)</h2>
<p>Before running the project, <b>you must create the database and tables</b>. Copy the following code and run it in <b>phpMyAdmin</b>:</p>
<pre>
-- Create database
CREATE DATABASE IF NOT EXISTS food_ordering;
USE food_ordering;

-- Users table
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Restaurants table
CREATE TABLE restaurants (
    restaurant_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    location VARCHAR(255),
    rating DECIMAL(2,1) DEFAULT 0.0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Menus table
CREATE TABLE menus (
    menu_id INT AUTO_INCREMENT PRIMARY KEY,
    restaurant_id INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(restaurant_id) ON DELETE CASCADE
);

-- Orders table
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Order Items table
CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menus(menu_id) ON DELETE CASCADE
);
</pre>
<p>✅ <b>Important:</b> Run this before opening the project in your browser.</p>

<h2>⚡ Installation Instructions</h2>
<ol>
    <li>Clone the repository:
        <pre>git clone https://github.com/yourusername/online-food-ordering.git</pre>
    </li>
    <li>Start XAMPP and ensure <b>Apache</b> and <b>MySQL</b> are running.</li>
    <li>Open <b>localhost/phpmyadmin</b>, create the database and tables using the SQL above.</li>
    <li>Open <code>connect.php</code> and update database credentials:
        <pre>
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "food_ordering";
        </pre>
    </li>
    <li>Copy project files to <code>htdocs</code> (or equivalent) folder.</li>
    <li>Open browser and visit:
        <pre>http://localhost/online-food-ordering/</pre>
    </li>
    <li>Start exploring your Online Food Ordering System!</li>
</ol>


<h2>🚀 Future Improvements</h2>
<ul>
<li>Auto-generated <code>schema.sql</code> file for easier setup</li>
<li>Admin dashboard to manage users and restaurants</li>
<li>Email/SMS notifications for order confirmation</li>
<li>Improved mobile responsiveness</li>
<li>Enhanced 3D animations and UI interactions</li>
</ul>

<h2>📫 Contact</h2>
<p>Made with ❤️ by <b>Sandeep Singh</b><br>
📧 Email: your.email@example.com<br>
📱 Instagram: <a href="https://www.instagram.com/s_.andeeep" target="_blank">@s_.andeeep</a></p>

<p class="center">✨ Thank you for checking out my project! Enjoy ordering! 🍕🍔🍟</p>

</body>
</html>
