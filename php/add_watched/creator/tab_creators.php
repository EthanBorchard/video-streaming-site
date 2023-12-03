<!-- Add Content Creators Tab -->

<div id="AddContentCreators" class="tabcontent">
    <h3>Add Watched Content Creators</h3>
        
        <input type="text" id="CreatorSearch" placeholder="Search for content creators...">
        <div id="CreatorSearchResults"></div>

        <form id="addCreatorForm" method="post">
            <input type="text" id="CreatorNameInput" name="CreatorName" placeholder="Content Creator Name" readonly>
            <input type="hidden" name="CreatorId" id="selectedCreatorId">
            <input type="number" name="HoursWatched" min="1" placeholder="Hours Watched">
            <button type="submit">Add Content Creator</button>
        </form>

        <div id="addCreatorMessage"></div>
        <div style="height: 100px;"></div>

        <button id="addRandomCreator">Add Random Creator Entry</button>

        <div id="addRandomCreatorMessage"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#CreatorSearch').keyup(function() {
            var searchText = $(this).val();
            if (searchText != '') {
                $.ajax({
                    url: './php/add_watched/creator/fetch_creators.php',
                    method: 'post',
                    data: {query: searchText},
                    success: function(response) {
                        $('#CreatorSearchResults').html(response);
                    }
                });
            } else {
                $('#CreatorSearchResults').html('');
            }
        });

        $(document).on('click', '.CreatorOption', function() {
            var CreatorName = $(this).data('name');
            var CreatorId = $(this).data('id');

            $('#CreatorNameInput').val(CreatorName);
            $('#selectedCreatorId').val(CreatorId);
            $('#CreatorSearchResults').empty();
        });
    });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#addCreatorForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: './php/add_watched/creator/add_creator.php',
                type: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addCreatorMessage').text("Content creator entry successfully added!");
                },
                error: function() {
                    $('#addCreatorMessage').text("An error occurred while adding the content creator.");
                }
            });
        });
    });
    </script>

    <script>
    $(document).ready(function() {

        $('#addRandomCreator').click(function() {
            $.ajax({
                url: './php/add_watched/creator/add_random_creator.php',
                type: 'post',
                data: {},
                success: function(response) {
                    $('#addRandomCreatorMessage').text("New random content creator entry added successfully!");
                },
                error: function() {
                    $('#addRandomCreatorMessage').text("An error occurred while adding a random content creator.");
                }
            });
        });
    });
    </script>
</div>
