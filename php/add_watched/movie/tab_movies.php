<!-- Add Movies Tab -->

<div id="AddMovies" class="tabcontent">
    <h3>Add Watched Movies</h3>
        
        <input type="text" id="movieSearch" placeholder="Search for movies...">
        <div id="movieSearchResults"></div>

        <form id="addMovieForm" method="post">
            <input type="text" id="movieTitleInput" name="movieTitle" placeholder="Movie Title" readonly>
            <input type="hidden" name="movieId" id="selectedMovieId">
            <input type="number" name="watchCount" min="1" placeholder="Times Watched">
            <button type="submit">Add Movie</button>
        </form>

        <div id="addMovieMessage"></div>
        <div style="height: 100px;"></div>

        <button id="addRandomMovie">Add Random Movie Entry</button>

        <div id="addRandomMovieMessage"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#movieSearch').keyup(function() {
            var searchText = $(this).val();
            if (searchText != '') {
                $.ajax({
                    url: './php/add_watched/movie/fetch_movies.php',
                    method: 'post',
                    data: {query: searchText},
                    success: function(response) {
                        $('#movieSearchResults').html(response);
                    }
                });
            } else {
                $('#movieSearchResults').html('');
            }
        });

        $(document).on('click', '.movieOption', function() {
            var movieTitle = $(this).data('title');
            var movieId = $(this).data('id');

            $('#movieTitleInput').val(movieTitle);
            $('#selectedMovieId').val(movieId);

            $('#movieSearchResults').empty();
        });
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#addMovieForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: './php/add_watched/movie/add_movie.php',
                type: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addMovieMessage').text("Movie entry successfully added!");
                },
                error: function() {
                    $('#addMovieMessage').text("An error occurred while adding the movie.");
                }
            });
        });
    });
    </script>

    <script>
    $(document).ready(function() {

        $('#addRandomMovie').click(function() {
            $.ajax({
                url: './php/add_watched/movie/add_random_movie.php',
                type: 'post',
                data: {},
                success: function(response) {
                    $('#addRandomMovieMessage').text("New random movie entry added successfully!");
                },
                error: function() {
                    $('#addRandomMovieMessage').text("An error occurred while adding a random movie.");
                }
            });
        });
    });
    </script>
</div>
