<?php
session_start();
require "header.php";
require "conn.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Allow viewing but redirect for purchases
}

// Insert comment into database
if (isset($_POST['comment'])) {
    $comment = trim($_POST['comment']);
    if (empty($comment)) {
        // Handle empty comment
    } else {
        try {
            $stmt = mysqli_prepare($conn, "INSERT INTO sug_comment (user_id, comment) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "is", $_SESSION['user_id'] ?? 0, $comment);
            mysqli_stmt_execute($stmt);
        } catch (Exception $e) {
            // Handle error silently
        }
    }
}

// Get categories
$catpost_exc = mysqli_query($conn, "SELECT * FROM sug_category ORDER BY id DESC");

// Get products
$propost_exc = mysqli_query($conn, "SELECT * FROM sug_product ORDER BY id DESC");
?>

<!-- Hero Section -->
<section style="min-height: auto;">
    <div class="container-fluid mb-3">
        <div class="row font-family">
            <?php 
            $hasCategory = false;
            while ($row = mysqli_fetch_assoc($catpost_exc)): 
                $hasCategory = true;
            ?>
                <div class="col-lg-6 col-md-6 col-sm-12 vh-50 bg-cover bg-center" style="background-image: url('Images/<?= $row['image'] ?>'); min-height: 400px;">
                    <nav class="navbar navbar-expand-md sticky-top w-100 position-relative">
                        <div class="container-fluid">
                            <div class="m-2 text-center">
                                <div class="navbar-brand">
                                    <a class="text-white fw-bolder fs-1 nav-link" href="#">Spurgeron.</a>
                                </div>
                            </div>
                            <button class="navbar-toggler navbar-dark" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a href="home.php" class="nav-link">HOME</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="my_account.php" class="nav-link">PROFILE</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">CATEGORIES</a>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Blog</a>
                                            <a class="dropdown-item" href="#">Location</a>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">ABOUT</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">CONTACT</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="register.php" class="nav-link">REGISTER</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="login.php" class="nav-link">LOGIN</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    
                    <!-- Hero Content -->
                    <div class="d-flex align-items-center justify-content-center h-75">
                        <div class="text-center text-white">
                            <h1 class="display-4 fw-bold">LUXURY SHOPPING</h1>
                            <p class="lead">Experience the best luxury hub</p>
                            <a href="register.php" class="btn btn-warning btn-lg">Get Started</a>
                        </div>
                    </div>
                </div>
            <?php break; endwhile; ?>
            
            <?php if (!$hasCategory): ?>
                <div class="col-lg-6 col-md-6 col-sm-12 vh-50 bg-cover bg-center bg-light" style="min-height: 400px;">
                    <nav class="navbar navbar-expand-md sticky-top w-100 position-relative">
                        <div class="container-fluid">
                            <div class="m-2 text-center">
                                <div class="navbar-brand">
                                    <a class="text-dark fw-bolder fs-1 nav-link" href="#">Spurgeron.</a>
                                </div>
                            </div>
                            <button class="navbar-toggler navbar-dark" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item">
                                        <a href="home.php" class="nav-link">HOME</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="login.php" class="nav-link">LOGIN</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="register.php" class="nav-link">REGISTER</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            <?php endif; ?>

            <!-- Second Column - Info -->
            <div class="col-md-6 d-none d-md-block justify-content-center bg-light">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="text-center p-5">
                        <p class="text-uppercase fw-bold text-muted">Inspiration</p>
                        <h2 class="display-4 font-familys">Understanding<br>and Using<br>Negative Space</h2>
                        <a href="#" class="btn btn-link mt-3">READ MORE</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Hero -->
        <div class="d-md-none bg-light p-4 text-center">
            <h2 class="font-familys">Understanding and Using</h2>
            <p>Negative Space</p>
        </div>
    </div>
</section>

<!-- Products Section -->
<div class="container-fluid py-4">
    <h2 class="text-center mb-4">Our Products</h2>
    <div class="row g-4">
        <?php while ($row = mysqli_fetch_assoc($propost_exc)): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm product-card">
                    <img src="Images/<?= $row['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($row['title']) ?>" style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($row['title']) ?></h5>
                        <p class="card-text text-muted"><?= htmlspecialchars($row['description']) ?></p>
                        <p class="card-text"><?= htmlspecialchars($row['sec_description'] ?? '') ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">₦100</span>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#purchaseModal<?= $row['id'] ?>">Purchase</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Purchase Modal -->
            <div class="modal fade" id="purchaseModal<?= $row['id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Purchase <?= htmlspecialchars($row['title']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="purchaseForm<?= $row['id'] ?>">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <div class="mb-3">
                                    <label class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" id="bankName<?= $row['id'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Account Number</label>
                                    <input type="number" class="form-control" id="accountNumber<?= $row['id'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Payment Method</label>
                                    <select class="form-select" id="paymentMethod<?= $row['id'] ?>" required>
                                        <option value="bankTransfer">Bank Transfer</option>
                                        <option value="creditCard">Credit Card</option>
                                        <option value="paypal">PayPal</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" class="form-control" id="quantity<?= $row['id'] ?>" value="1" min="1" onchange="updatePrice(<?= $row['id'] ?>)">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Total Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₦</span>
                                        <input type="text" class="form-control" id="totalPrice<?= $row['id'] ?>" value="100" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="processPurchase(<?= $row['id'] ?>)">Purchase</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- Recent Comments Section -->
<div class="container mt-5 mb-5">
    <h2 class="mb-4">Recent Comments</h2>
    <div class="row">
        <?php
        $comments_exc = mysqli_query($conn, "SELECT c.*, u.firstName FROM sug_comment c LEFT JOIN sugeron u ON c.user_id = u.id ORDER BY c.id DESC LIMIT 3");
        while ($comment = mysqli_fetch_assoc($comments_exc)):
        ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text"><?= htmlspecialchars($comment['comment']) ?></p>
                        <small class="text-muted">- <?= htmlspecialchars($comment['firstName'] ?? 'Anonymous') ?></small>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php require "footer.php"; ?>
