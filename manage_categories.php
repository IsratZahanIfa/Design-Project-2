<?php
session_start();
include 'db.php';

// ------------------ ADD CATEGORY ------------------
if (isset($_POST['add_category'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $icon = $_POST['icon'];

    $stmt = $conn->prepare("INSERT INTO categories (name, description, icon) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $description, $icon);
    $stmt->execute();
}

// ------------------ UPDATE CATEGORY ------------------
if (isset($_POST['update_category'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $icon = $_POST['icon'];

    $stmt = $conn->prepare("UPDATE categories SET name=?, description=?, icon=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $description, $icon, $id);
    $stmt->execute();
}

// ------------------ DELETE CATEGORY ------------------
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: manage_categories.php");
    exit;
}

// ------------------ FETCH ALL CATEGORIES ------------------
$result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $result->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Categories</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<div class="top-bar">
    <h2>Manage Categories</h2>
    <button class="add-btn" onclick="openAddModal()">+ Add Category</button>
</div>

<div class="categories-container">

<?php foreach ($categories as $cat): ?>
    <div class="category-card">
        <div class="icon-box"><?= htmlspecialchars($cat['icon']) ?></div>
        <h3><?= htmlspecialchars($cat['name']) ?></h3>
        <p><?= htmlspecialchars($cat['description']) ?></p>

        <div class="info">
            <span><?= htmlspecialchars($cat['items_count']) ?> items</span>

            <button class="edit-btn" 
                    onclick='openEditModal(<?= json_encode($cat) ?>)'>Edit</button>

            <a href="?delete=<?= $cat['id'] ?>" 
               style="color:red; margin-left:10px;" 
               onclick="return confirm('Delete category?')">Delete</a>
        </div>
    </div>
<?php endforeach; ?>

</div>


<!-- ---------------- ADD/EDIT MODAL ---------------- -->
<div class="modal" id="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modal-title">Add Category</h3>
            <span class="close" onclick="closeModal()">✖</span>
        </div>

        <form method="post">

            <input type="hidden" name="id" id="cat-id">

            <label>Category Name</label>
            <input type="text" id="cat-name" name="name" required>

            <label>Description</label>
            <textarea id="cat-desc" name="description"></textarea>

            <label>Icon</label>
            <input type="text" id="cat-icon" name="icon" placeholder="Emoji">

            <button class="save-btn" name="add_category" id="add-btn">Add Category</button>
            <button class="save-btn" name="update_category" id="update-btn" style="display:none;">Update Category</button>

        </form>
    </div>
</div>


<script>
function openAddModal() {
    document.getElementById("modal").style.display = "flex";

    document.getElementById("modal-title").innerText = "Add Category";
    document.getElementById("add-btn").style.display = "block";
    document.getElementById("update-btn").style.display = "none";

    document.getElementById("cat-id").value = "";
    document.getElementById("cat-name").value = "";
    document.getElementById("cat-desc").value = "";
    document.getElementById("cat-icon").value = "";
}

function openEditModal(cat) {
    document.getElementById("modal").style.display = "flex";

    document.getElementById("modal-title").innerText = "Edit Category";
    document.getElementById("add-btn").style.display = "none";
    document.getElementById("update-btn").style.display = "block";

    document.getElementById("cat-id").value = cat.id;
    document.getElementById("cat-name").value = cat.name;
    document.getElementById("cat-desc").value = cat.description;
    document.getElementById("cat-icon").value = cat.icon;
}

function closeModal() {
    document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>
