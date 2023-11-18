<!-- Tab Home -->

<div id="Home" class="tabcontent">
    <div class="left-side">

        <div class="box">
            <h3 class="title">My Movies</h3>
            <div class="scrollable-table">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Times Watched</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $userId = $_SESSION['userid'];
                        $query = "SELECT Movie.Title, WatchedMovie.WatchCount, WatchedMovie.WatchedMovieID FROM WatchedMovie
                                  INNER JOIN Movie ON WatchedMovie.MovieID = Movie.MovieID WHERE WatchedMovie.UserID = '$userId'";
                        $result = $conn->query($query);

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                            echo "<td>" . $row['WatchCount'] . "</td>";
                            echo "<td><button class='remove-btn' data-id='" . $row['WatchedMovieID'] . "' data-type='movie' 
                                  aria-label='Delete'><i class='fas fa-trash'></i></button></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box">
        <h3 class="title">My TV Shows</h3>
            <div class="scrollable-table">
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Episodes Watched</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $userId = $_SESSION['userid'];
                        $query = "SELECT TVShow.Title, WatchedTVShow.EpisodesWatched, WatchedTVShow.WatchedTVShowID FROM WatchedTVShow 
                                  INNER JOIN TVShow ON WatchedTVShow.TVShowID = TVShow.TVShowID WHERE WatchedTVShow.UserID = '$userId'";
                        $result = $conn->query($query);

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                            echo "<td>" . $row['EpisodesWatched'] . "</td>";
                            echo "<td><button class='remove-btn' data-id='" . $row['WatchedTVShowID'] . "' data-type='tvshow' 
                                  aria-label='Delete'><i class='fas fa-trash'></i></button></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box">
        <h3 class="title">My Creators</h3>
            <div class="scrollable-table">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Hours Watched</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $userId = $_SESSION['userid'];
                        $query = "SELECT ContentCreator.Name, WatchedCreator.HoursWatched, WatchedCreator.WatchedCreatorID FROM WatchedCreator 
                                  INNER JOIN ContentCreator ON WatchedCreator.CreatorID = ContentCreator.CreatorID WHERE WatchedCreator.UserID = '$userId'";
                        $result = $conn->query($query);

                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                            echo "<td>" . $row['HoursWatched'] . "</td>";
                            echo "<td><button class='remove-btn' data-id='" . $row['WatchedCreatorID'] . "' data-type='creator'
                                  aria-label='Delete'><i class='fas fa-trash'></i></button></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
        document.querySelectorAll('.remove-btn').forEach(button => {
            button.addEventListener('click', function() {
                var watchedId = this.getAttribute('data-id');
                var entryType = this.getAttribute('data-type');

                $.ajax({
                    url: './php/remove_watched_entry.php',
                    type: 'POST',
                    data: { 'watchedId': watchedId, 'entryType': entryType },
                    success: function(response) {
                        button.closest('tr').remove();
                    },
                    error: function() {
                        alert('An error occurred while removing the entry.');
                    }
                });
            });
        });
        </script>
    </div>


    <div class="right-side">

        <div class="box">
        <h3>Your Statistics</h3>
        
        <p>You've watched:</p>
        <div class="statistics-box">
            <?php
            $totalHours = 0;
            $moviesQuery = "SELECT SUM(Movie.Duration/60 * WatchedMovie.WatchCount) AS TotalHours FROM WatchedMovie JOIN Movie ON 
                                       WatchedMovie.MovieID = Movie.MovieID WHERE WatchedMovie.UserID = '$userId'";
            $moviesResult = $conn->query($moviesQuery);
            if ($row = $moviesResult->fetch_assoc()) {
                $totalHours += $row['TotalHours'];
            }

            $tvShowsQuery = "SELECT SUM(TVShow.Duration/60 * WatchedTVShow.EpisodesWatched) AS TotalHours FROM WatchedTVShow JOIN TVShow ON 
                                        WatchedTVShow.TVShowID = TVShow.TVShowID WHERE WatchedTVShow.UserID = '$userId'";
            $tvShowsResult = $conn->query($tvShowsQuery);
            if ($row = $tvShowsResult->fetch_assoc()) {
                $totalHours += $row['TotalHours'];
            }

            $contentCreatorsQuery = "SELECT SUM(HoursWatched) AS TotalHours FROM WatchedCreator WHERE UserID = '$userId'";
            $contentCreatorsResult = $conn->query($contentCreatorsQuery);
            if ($row = $contentCreatorsResult->fetch_assoc()) {
                $totalHours += $row['TotalHours'];
            }

            echo "<div>Total Hours: " . floor($totalHours) . "</div>";
            ?>
        </div>

        <p>Most Watched Movie:</p>
        <div class="statistics-box">
            <?php
            $mostWatchedMovieQuery = "SELECT Movie.Title, Movie.Year, Movie.Genre, Movie.Duration, MAX(WatchedMovie.WatchCount) as MaxWatchCount 
                                      FROM WatchedMovie JOIN Movie ON WatchedMovie.MovieID = Movie.MovieID WHERE WatchedMovie.UserID = '$userId' 
                                      GROUP BY WatchedMovie.MovieID ORDER BY MaxWatchCount DESC LIMIT 1";
            $mostWatchedMovieResult = $conn->query($mostWatchedMovieQuery);

            if ($row = $mostWatchedMovieResult->fetch_assoc()) {
                echo "<div>" . htmlspecialchars($row['Title']) . "</div><div>" . "Released: " . $row['Year'] . ", Genre: " 
                             . htmlspecialchars($row['Genre']) . ", Duration: " . htmlspecialchars($row['Duration']) . " mins</div>";
            } else {
                echo "<div>No movies watched yet</div>";
            }
            ?>
        </div>

        <p>Most Watched TV Show:</p>
        <div class="statistics-box">
            <?php
            $mostWatchedTVShowQuery = "SELECT TVShow.Title, TVShow.Year, TVShow.Genre, TVShow.Duration, MAX(WatchedTVShow.EpisodesWatched) as MaxEpisodesWatched 
                                       FROM WatchedTVShow JOIN TVShow ON WatchedTVShow.TVShowID = TVShow.TVShowID WHERE WatchedTVShow.UserID = '$userId' 
                                       GROUP BY WatchedTVShow.TVShowID ORDER BY MaxEpisodesWatched DESC LIMIT 1";
            $mostWatchedTVShowResult = $conn->query($mostWatchedTVShowQuery);

            if ($row = $mostWatchedTVShowResult->fetch_assoc()) {
                echo "<div>" . htmlspecialchars($row['Title']) . "</div><div>" . "Released: " . $row['Year'] . ", Genre: " 
                             . htmlspecialchars($row['Genre']) . ", Episode Length: " . htmlspecialchars($row['Duration']) . " mins</div>";
            } else {
                echo "<div>No TV shows watched yet</div>";
            }
            ?>
        </div>

        <p>Most Watched Content Creator:</p>
        <div class="statistics-box">
            <?php
            $mostWatchedCreatorQuery = "SELECT ContentCreator.Name, ContentCreator.Followers, MAX(WatchedCreator.HoursWatched) as MaxHoursWatched 
                                        FROM WatchedCreator JOIN ContentCreator ON WatchedCreator.CreatorID = ContentCreator.CreatorID WHERE WatchedCreator.UserID = '$userId' 
                                        GROUP BY WatchedCreator.CreatorID ORDER BY MaxHoursWatched DESC LIMIT 1";
            $mostWatchedCreatorResult = $conn->query($mostWatchedCreatorQuery);

            if ($row = $mostWatchedCreatorResult->fetch_assoc()) {
                echo "<div>" . htmlspecialchars($row['Name']) . "</div><div>" . "Number of followers: " . number_format($row['Followers'], 0, '.', ',') . "</div>";
            } else {
                echo "<div>No creators watched yet</div>";
            }
            ?>
        </div>
        
    </div>
</div>
