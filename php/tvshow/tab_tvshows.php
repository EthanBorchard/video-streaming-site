<!-- Add TV Shows Tab -->

<div id="AddTVShows" class="tabcontent">
    <h3>Add Watched TV Shows</h3>
        
        <input type="text" id="TVShowSearch" placeholder="Search for TV shows...">
        <div id="TVShowSearchResults"></div>

        <form id="addTVShowForm" method="post">
            <input type="text" id="TVShowTitleInput" name="TVShowTitle" placeholder="TV Show Title" readonly>
            <input type="hidden" name="TVShowId" id="selectedTVShowId">
            <input type="number" name="EpisodesWatched" min="1" placeholder="Episodes Watched">
            <button type="submit">Add TV Show</button>
        </form>

        <div id="addTVShowMessage"></div>
        <div style="height: 100px;"></div>

        <button id="addRandomTVShow">Add Random TV Show Entry</button>

        <div id="addRandomTVShowMessage"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#TVShowSearch').keyup(function() {
            var searchText = $(this).val();
            if (searchText != '') {
                $.ajax({
                    url: './php/tvshow/fetch_tvshows.php',
                    method: 'post',
                    data: {query: searchText},
                    success: function(response) {
                        $('#TVShowSearchResults').html(response);
                    }
                });
            } else {
                $('#TVShowSearchResults').html('');
            }
        });

        $(document).on('click', '.TVShowOption', function() {
            var TVShowTitle = $(this).data('title');
            var TVShowId = $(this).data('id');

            $('#TVShowTitleInput').val(TVShowTitle);
            $('#selectedTVShowId').val(TVShowId);
            $('#TVShowSearchResults').empty();
        });
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#addTVShowForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: './php/tvshow/add_tvshow.php',
                type: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addTVShowMessage').text("TV Show entry successfully added!");
                },
                error: function() {
                    $('#addTVShowMessage').text("An error occurred while adding the TV Show.");
                }
            });
        });
    });
    </script>

    <script>

    $(document).ready(function() {

        $('#addRandomTVShow').click(function() {
            $.ajax({
                url: './php/tvshow/add_random_tvshow.php',
                type: 'post',
                data: {},
                success: function(response) {
                    $('#addRandomTVShowMessage').text("New random TV Show entry added successfully!");
                },
                error: function() {
                    $('#addRandomTVShowMessage').text("An error occurred while adding a random TV Show.");
                }
            });
        });
    });
    </script>
</div>
