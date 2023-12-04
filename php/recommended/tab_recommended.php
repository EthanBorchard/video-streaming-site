<!-- Recommended Tab -->

<div id="Recommended" class="tabcontent">
    <div class="left-side">

        <div class="box">
            <h3>Recommended Movies</h3>
            <div id="recommendedMovies"></div>
            <script>
            function fetchMovieRecommendations() {
                $.ajax({
                    url: './php/recommended/fetch_recommended_movies.php',
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
                    url: './php/recommended/fetch_recommended_tvshows.php',
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


    <div class="right-side">

        <div class="box">
            <h3>What My Following is Watching</h3>
            <div id="followingActivity"></div>
            <script>
            function loadFollowingActivity() {
                $.ajax({
                    url: './php/recommended/fetch_following_activity.php',
                    type: 'GET',
                    success: function(response) {
                        var activities = JSON.parse(response);
                        var container = $('#followingActivity');
                        container.empty();

                        activities.forEach(function(activity) {
                            var htmlContent = '<div class="user-activity">';

                            htmlContent += '<h4>' + activity.userName + '\'s Top Picks:</h4>';

                            if (activity.topMovie) {
                                htmlContent += '<div class="top-movie">' +
                                            '<strong>Movie:</strong> ' + activity.topMovie.Title + '<br>' +
                                            'Released: ' + activity.topMovie.Year + ', Genre: ' + activity.topMovie.Genre + 
                                            ', Duration: ' + activity.topMovie.Duration + ' mins' +
                                            '</div>';
                            }

                            if (activity.topTVShow) {
                                htmlContent += '<div class="top-tvshow">' +
                                            '<strong>TV Show:</strong> ' + activity.topTVShow.Title + '<br>' +
                                            'Released: ' + activity.topTVShow.Year + ', Genre: ' + activity.topTVShow.Genre + 
                                            ', Duration: ' + activity.topTVShow.Duration + ' mins per episode' +
                                            '</div>';
                            }

                            if (activity.topCreator) {
                                htmlContent += '<div class="top-contentcreator">' +
                                            '<strong>Content Creator:</strong> ' + activity.topCreator.Name + '<br>' +
                                            'Followers: ' + activity.topCreator.Followers +
                                            '</div>';
                            }

                            htmlContent += '</div>';
                            container.append(htmlContent);
                        });
                    }
                });
            }
            loadFollowingActivity();
            </script>
        </div>
        
    </div>
</div>