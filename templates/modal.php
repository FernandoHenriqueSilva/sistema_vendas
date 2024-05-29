<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <?php foreach ($photos as $photo): ?>
        <img src="<?php echo htmlspecialchars($photo); ?>" alt="Product Image" class="product-img">
    <?php endforeach; ?>
  </div>
</div>

<script>
document.getElementById('show-more-photos').onclick = function() {
    document.getElementById('myModal').style.display = "block";
}

document.getElementsByClassName('close')[0].onclick = function() {
    document.getElementById('myModal').style.display = "none";
}

window.onclick = function(event) {
    if (event.target == document.getElementById('myModal')) {
        document.getElementById('myModal').style.display = "none";
    }
}
</script>
