<!-- Wrapped Tab -->

<div id="Wrapped" class="tabcontent">
    <div id="wrappedSlider">

        <div class="slide" id="slide1">
            <br></br><br></br><br></br><br></br>
            <h1>Your 2023 Wrapped</h1>
            <h2>Unwrap your streaming highlights</h2>
        </div>

        <div class="slide" id="slide2">
            <h1>My Top Genres</h1>
            <div id="topGenresList"></div>
            <script>
            function loadTopGenres() {
                fetch('./php/wrapped/fetch_top_genres.php')
                .then(response => response.json())
                .then(genres => {
                    const genresListDiv = document.getElementById('topGenresList');
                    genresListDiv.innerHTML = '';
                    genres.forEach(genre => {
                        const genreDiv = document.createElement('div');
                        genreDiv.textContent = genre;
                        genreDiv.className = 'genre-row';
                        genresListDiv.appendChild(genreDiv);
                    });
                })
                .catch(error => console.error('Error:', error));
            }
            loadTopGenres();
            </script>
        </div>

        <div class="slide" id="slide3" style="background: linear-gradient(to right, #6ee2ff, #ffbffe);">
            <h2 id="topMovieTitle">Top Movie</h2>
            <img id="topMovieImage" src="./php/wrapped/images/movie.jpg" alt="Top Movie Image" style="max-width: 75%; height: auto;">
            <h3 id="topMovieWatchCount">Times Watched: </h3>

            <script>
            function loadTopMovie() {
                fetch('./php/wrapped/fetch_top_movie.php')
                .then(response => response.json())
                .then(movie => {
                    if (movie) {
                        document.getElementById('topMovieTitle').textContent = 'Top Movie: ' + movie.Title;
                        document.getElementById('topMovieWatchCount').textContent = 'Times Watched: ' + movie.TotalWatchCount;
                    } else {
                        document.getElementById('topMovieTitle').textContent = 'Top Movie: Not Available';
                        document.getElementById('topMovieWatchCount').textContent = 'Times Watched: N/A';
                    }
                })
                .catch(error => console.error('Error:', error));
            }
            loadTopMovie();
            </script>
        </div>

        <div class="slide" id="slide4" style="background: linear-gradient(to right, #70f295, #ecff72);">
            <h2 id="topTVShowTitle">Top TV Show</h2>
            <img id="topTVShowImage" src="./php/wrapped/images/tvshow.jpg" alt="Top TV Show Image" style="max-width: 75%; height: auto;">
            <h3 id="topTVShowWatchCount">Episodes Watched: </h3>

            <script>
            function loadTopTVShow() {
                fetch('./php/wrapped/fetch_top_tvshow.php')
                .then(response => response.json())
                .then(TVShow => {
                    if (TVShow) {
                        document.getElementById('topTVShowTitle').textContent = 'Top TV Show: ' + TVShow.Title;
                        document.getElementById('topTVShowWatchCount').textContent = 'Episodes Watched: ' + TVShow.TotalWatchCount;
                    } else {
                        document.getElementById('topTVShowTitle').textContent = 'Top TV Show: Not Available';
                        document.getElementById('topTVShowWatchCount').textContent = 'Episodes Watched: N/A';
                    }
                })
                .catch(error => console.error('Error:', error));
            }
            loadTopTVShow();
            </script>
        </div>

        <div class="slide" id="slide5" style="background: linear-gradient(to right, #f2709c, #ff9472);">
            <h2 id="topCreatorName">Top Creator</h2>
            <img id="topCreatorImage" src="./php/wrapped/images/contentcreator.jpg" alt="Top Creator Image" style="max-width: 75%; height: auto;">
            <h3 id="topCreatorWatchCount">Hours Watched: </h3>

            <script>
            function loadTopCreator() {
                fetch('./php/wrapped/fetch_top_creator.php')
                .then(response => response.json())
                .then(creator => {
                    if (creator) {
                        document.getElementById('topCreatorName').textContent = 'Top Creator: ' + creator.Name;
                        document.getElementById('topCreatorWatchCount').textContent = 'Hours Watched: ' + creator.TotalWatchCount;
                    } else {
                        document.getElementById('topCreatorName').textContent = 'Top Creator: Not Available';
                        document.getElementById('topCreatorWatchCount').textContent = 'Hours Watched: N/A';
                    }
                })
                .catch(error => console.error('Error:', error));
            }
            loadTopCreator();
            </script>
        </div>

        <div class="slide" id="slide6" style="background: linear-gradient(to right, #FEE715FF, #F2AA4CFF);">
            <br></br>
            <img id="streamingIcon" src="./php/wrapped/images/streaming-icon.png" alt="" style="max-width: 70%; height: auto;">
            <br></br>
            <h1 id="totalHoursStreamed">Total Hours Streamed in 2023: </h1>
            <h1 id="totalHoursNumber"></h1>
            <div class="social-share-buttons">
                <h4>Share On:</h4>
                <a href="#" id="shareTwitter" target="_blank">Twitter</a>
                <a href="#" id="shareFacebook" target="_blank">Facebook</a>
                <a href="#" id="shareEmail">Email</a>
            </div>

            <script>
            function loadTotalHoursStreamed() {
                fetch('./php/wrapped/fetch_total_hours.php')
                .then(response => response.json())
                .then(totalHours => {
                    document.getElementById('totalHoursNumber').textContent = totalHours.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    updateSocialShareLinks(totalHours);
                    updateEmailShareLink(totalHours);
                })
                .catch(error => console.error('Error:', error));
            }

            loadTotalHoursStreamed();
            </script>

            <script>
            function updateSocialShareLinks(totalHours) {
                const shareMessage = encodeURIComponent(`Video Streaming Wrapped - My total hours streamed in 2023: ${totalHours}`);

                const twitterUrl = `https://twitter.com/intent/tweet?text=${shareMessage}`;
                document.getElementById('shareTwitter').href = twitterUrl;

                const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${window.location.href}&quote=${shareMessage}`;
                document.getElementById('shareFacebook').href = facebookUrl;
            }

            function updateEmailShareLink(totalHours) {
                const subject = encodeURIComponent('Video Streaming Wrapped - My 2023 in Review');
                const body = encodeURIComponent(`Check out my Video Streaming Wrapped for 2023! I streamed a total of ${totalHours} hours this year!`);

                const mailtoLink = `mailto:?subject=${subject}&body=${body}`;
                document.getElementById('shareEmail').href = mailtoLink;
            }
            </script>
        </div>

    </div>
    <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
    <button class="next" onclick="moveSlide(1)">&#10095;</button>

    <script>
    let slideIndex = 1;
    showSlides(slideIndex);

    function moveSlide(n) {
        showSlides(slideIndex += n);
    }

    function showSlides(n) {
    let i;
    let slides = document.getElementsByClassName("slide");
    if (n > slides.length) {slideIndex = 1}    
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    slides[slideIndex-1].style.display = "block";  
    }
    </script>
</div>
