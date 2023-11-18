<!-- Account Tab -->

<div id="Account" class="tabcontent">
    <h3>Account Details</h3>
    
    <p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>

    <p>Email: <?php echo htmlspecialchars($email); ?></p>

    <p>Country: <?php echo htmlspecialchars($country); ?></p>

    <button id="deleteUserButton" class="delete-btn">Delete My Account</button>

    <script>
    document.getElementById('deleteUserButton').addEventListener('click', function() {
        if (confirm('Are you sure you want to delete your account? This cannot be undone.')) {
            $.ajax({
                url: './php/delete_user.php',
                type: 'POST',
                data: { userId: '<?php echo $_SESSION['userid']; ?>' },
                success: function(response) {
                    window.location.href = './index.php';
                },
                error: function() {
                    alert('An error occurred while deleting the account.');
                }
            });
        }
    });
    </script>
</div>
