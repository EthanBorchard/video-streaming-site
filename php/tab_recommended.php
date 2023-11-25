<!-- Recommended Tab -->

<div id="Recommended" class="tabcontent">
    <div class="left-side">
        <div class="box">
            <h3>Recommended Movies</h3>
            <div id="recommendedMovies"></div>
            <script>
            function fetchMovieRecommendations() {
                $.ajax({
                    url: './php/movie/fetch_recommended_movies.php',
                    type: 'GET',
                    success: function(response) {
                        var movies = JSON.parse(response);
                        movies.forEach(function(movie) {
                            var movieHtml = '<div class="recommended-item">' +
                                                '<p><strong>Title:</strong> ' + movie.title + '</p>' +
                                                '<p><strong>Genre:</strong> ' + movie.genre + '</p>' +
                                                '<p><strong>Available on:</strong> ' + movie.streamingService + '</p>' +
                                            '</div>';
                            $('#recommendedMovies').append(movieHtml);
                        });
                    }
                });
            }
            fetchMovieRecommendations();
            </script>
        </div>
        <div class="box">
            <h3>Recommended TV Shows</h3>
            <div id="recommendedTVShows"></div>
            <script>
            function fetchTVShowRecommendations() {
                $.ajax({
                    url: './php/tvshow/fetch_recommended_tvshows.php',
                    type: 'GET',
                    success: function(response) {
                        var tvshows = JSON.parse(response);
                        tvshows.forEach(function(tvshow) {
                            var tvshowHtml = '<div class="recommended-item">' +
                                                '<p><strong>Title:</strong> ' + tvshow.title + '</p>' +
                                                '<p><strong>Genre:</strong> ' + tvshow.genre + '</p>' +
                                                '<p><strong>Available on:</strong> ' + tvshow.streamingService + '</p>' +
                                            '</div>';
                            $('#recommendedTVShows').append(tvshowHtml);
                        });
                    }
                });
            }
            fetchTVShowRecommendations();
            </script>
        </div>
    </div>
    <!-- Placeholder for the right side of the Recommended tab -->
    <div class="right-side">
        <!-- Future content -->
    </div>
</div>