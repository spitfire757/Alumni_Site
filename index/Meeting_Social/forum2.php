<link rel='stylesheet' type='text/css' href='../style/global_style.css'>
<div id="forumContent"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchForumData() {
            $.ajax({
                url: 'fetch_forum.php',
                type: 'GET',
                success: function(data) {
                    $('#forumContent').html(data);
                },
                error: function() {
                    $('#forumContent').html('<p>Error loading forums.</p>');
                }
            });
        }
        fetchForumData();

        $('form.search-form').submit(function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: 'fetch_forum.php',
                type: 'GET',
                data: formData,
                success: function(data) {
                    $('#forumContent').html(data);
                },
                error: function() {
                    $('#forumContent').html('<p>Error loading forums.</p>');
                }
            });
        });
    });
</script>

<style>
    /* Your CSS styles here */
</style>

<body>
    <hr class="separator">
    <a href="create_forum.php" class="btn">Create a Forum</a>
    <hr class="separator">
    <form action="forum2.php" method="get" class="search-form">
        <input type="text" name="search_query" placeholder="Search..." class="search-input"><br>
        <select name="search_criteria" class="search-select">
            <option value="title">Title</option>
            <option value="Description">Description</option>
            <option value="userID">Author</option>
        </select><br>
        <button type="submit" class="btn">Search</button>
        <button type="submit" name="clear_search" class="btn">Clear Search</button>
    </form>
    <hr class="separator">
</body>
