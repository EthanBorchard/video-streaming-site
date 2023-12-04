<!-- Following Tab -->

<div id="Following" class="tabcontent">
    
    <div class="left-side">
        <div class="box">
            <h3>Find Users to Follow</h3>
            <input type="text" id="userSearchInput" placeholder="Search users...">
            <div id="userSearchResults"></div>
        </div>
        <script>
        $(document).ready(function() {
            $('#userSearchInput').on('input', function() {
                var searchText = $(this).val();

                if (searchText.trim() === '') {
                    $('#userSearchResults').html('');
                    return;
                }

                $.ajax({
                    url: './php/following/fetch_users.php',
                    type: 'POST',
                    data: { 'searchText': searchText },
                    success: function(response) {
                        $('#userSearchResults').html(response);
                    }
                });
            });

            $(document).on('click', '.follow-btn', function() {
                var userId = $(this).data('userid');
                var button = $(this);

                $.ajax({
                    url: './php/following/follow_user.php',
                    type: 'POST',
                    data: { 'followedUserId': userId },
                    success: function(response) {
                        if (response === 'success') {
                            button.prop('disabled', true).text('Followed');
                        } else {
                            alert('Error following user.');
                        }
                    }
                });
            });

            $(document).on('click', '.unfollow-btn', function() {
                var userId = $(this).data('userid');
                var button = $(this);

                $.ajax({
                    url: './php/following/unfollow_user.php',
                    type: 'POST',
                    data: { 'followingUserId': userId },
                    success: function(response) {
                        if (response === 'success') {
                            $('#followingTable').find('tr').each(function() {
                                if ($(this).find('.unfollow-btn').data('userid') == userId) {
                                    $(this).remove();
                                }
                            });

                            button.prop('disabled', true).text('Unfollowed');
                        } else {
                            alert('Error unfollowing user.');
                        }
                    }
                });
            });
        });
        </script>
    </div>

    <div class="right-side">
        <div class="box">
            <h3>Users I'm Following</h3>
            <table id="followingTable">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Country</th>
                        <th>Since</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <script>
        function loadFollowingUsers() {
            $.ajax({
                url: './php/following/fetch_following.php',
                type: 'GET',
                success: function(response) {
                    var users = JSON.parse(response);
                    var tableBody = $('#followingTable tbody');
                    tableBody.empty();

                    users.forEach(function(user) {
                        tableBody.append('<tr><td>' + user.Username + '</td><td>' + user.Country + 
                                         '</td><td>' + user.Since + '</td></tr>');
                    });
                }
            });
        }
        loadFollowingUsers();
        </script>
    </div>
</div>