<?php
require 'config.php';

$query = "SELECT p.id, p.title, p.price, p.payment_mode, ph.photo_url
          FROM products p
          LEFT JOIN product_photos ph ON p.id = ph.product_id
          GROUP BY p.id
          ORDER BY p.id DESC
          LIMIT 10";
$result = $conn->query($query);
?>

<ul>
    <?php while ($row = $result->fetch_assoc()): ?>
    <li>
        <?php if ($row['photo_url']): ?>
        <img src="<?php echo $row['photo_url']; ?>" alt="<?php echo $row['title']; ?>" />
        <?php endif; ?>
        <div>
            <h2><?php echo $row['title']; ?></h2>
            <p>Price: $<?php echo $row['price']; ?></p>
            <p>Payment Mode: <?php echo $row['payment_mode']; ?></p>
            <a href="product_details.php?id=<?php echo $row['id']; ?>">View Details</a>
        </div>
    </li>
    <?php endwhile; ?>
</ul>
