<!-- Account Tab -->

<div id="Account" class="tabcontent">
    <h3>Account Details</h3>
    
    <p>Username: <?php echo htmlspecialchars($_SESSION['username']); ?></p>

    <p>Email: <?php echo htmlspecialchars($email); ?></p>

    <p>Country: <?php echo htmlspecialchars($country); ?></p>

    <br></br>
    <h3>Milestone Badges</h3>
    <div class="badges-grid">
        <div class="badge-container">
            <div class="badge" id="badge-first-timer"></div>
            <div class="badge-name">First Timer</div>
            <div class="badge-description">Watch your first movie, TV show, or content creator</div>
        </div>
        <div class="badge-container">
            <div class="badge" id="badge-novice-watcher"></div>
            <div class="badge-name">Novice Watcher</div>
            <div class="badge-description">Watch 1,000 total hours across all media</div>
        </div>
        <div class="badge-container">
            <div class="badge" id="badge-regular-watcher"></div>
            <div class="badge-name">Regular Watcher</div>
            <div class="badge-description">Watch 5,000 total hours across all media</div>
        </div>
        <div class="badge-container">
            <div class="badge" id="badge-binge-watcher"></div>
            <div class="badge-name">Binge Watcher</div>
            <div class="badge-description">Watch 10,000 total hours across all media</div>
        </div>
        <div class="badge-container">
            <div class="badge" id="badge-genre-explorer"></div>
            <div class="badge-name">Genre Explorer</div>
            <div class="badge-description">Watch 15 unique genres</div>
        </div>
        <div class="badge-container">
            <div class="badge" id="badge-movie-buff"></div>
            <div class="badge-name">Movie Buff</div>
            <div class="badge-description">Watch 20 unique movies</div>
        </div>
        <div class="badge-container">
            <div class="badge" id="badge-series-master"></div>
            <div class="badge-name">Series Master</div>
            <div class="badge-description">Watch 20 unique TV shows</div>
        </div>
        <div class="badge-container">
            <div class="badge" id="badge-content-king"></div>
            <div class="badge-name">Content King</div>
            <div class="badge-description">Watch 20 unique content creators</div>
        </div>
        <div class="badge-container">
            <div class="badge" id="badge-social-butterfly"></div>
            <div class="badge-name">Social Butterfly</div>
            <div class="badge-description">Follow 10 other users</div>
        </div>
        <div class="badge-container">
            <div class="badge" id="badge-influencer"></div>
            <div class="badge-name">Influencer</div>
            <div class="badge-description">Earned when 10 users follow you</div>
        </div>
    </div>
    
    <script>
    function loadBadges() {
        $.ajax({
            url: './php/account/milestones_check.php',
            type: 'GET',
            success: function(response) {
                var badgesEarned = JSON.parse(response);
                if (badgesEarned.firstTimer) {
                    $('#badge-first-timer').addClass('earned');
                }
                if (badgesEarned.noviceWatcher) {
                    $('#badge-novice-watcher').addClass('earned');
                }
                if (badgesEarned.regularWatcher) {
                    $('#badge-regular-watcher').addClass('earned');
                }
                if (badgesEarned.bingeWatcher) {
                    $('#badge-binge-watcher').addClass('earned');
                }
                if (badgesEarned.genreExplorer) {
                    $('#badge-genre-explorer').addClass('earned');
                }
                if (badgesEarned.movieBuff) {
                    $('#badge-movie-buff').addClass('earned');
                }
                if (badgesEarned.seriesMaster) {
                    $('#badge-series-master').addClass('earned');
                }
                if (badgesEarned.contentKing) {
                    $('#badge-content-king').addClass('earned');
                }
                if (badgesEarned.socialButterfly) {
                    $('#badge-social-butterfly').addClass('earned');
                }
                if (badgesEarned.influencer) {
                    $('#badge-influencer').addClass('earned');
                }
            }
        });
    }
    loadBadges();
    </script>
    
    <br></br>
    <br></br>
    <button id="deleteUserButton" class="delete-btn">Delete My Account</button>
    <script>
    document.getElementById('deleteUserButton').addEventListener('click', function() {
        if (confirm('Are you sure you want to delete your account? This cannot be undone.')) {
            $.ajax({
                url: './php/account/delete_user.php',
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
