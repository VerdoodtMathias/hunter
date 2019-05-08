<header>
    <section class="content">
        <nav>
            <a href="index.php" id="nav_logo">logo</a>

            <form action="" method="get">
                    <input type="text" name="search" placeholder="Search" id="search">
            </form>

            <div id="links">
                <a href="upload.php" id="upload-a" style="color: white;"><span>+</span> UPLOAD</a>
                <a href="discover.php" id="profile-b">DISCOVER</a>
                <a href="account.php"  id="profile-a">PROFILE</a>
                <a href="logout.php" id="logout-a">LOG OUT</a>
            </div>

        </nav>
    </section>
</header>


<?

// SEARCH
if (!empty($_GET['search'])) {
    include_once ('classes/Search.class.php');
    $search_term = $_GET['search'];
    $test = new Search();
    $test->setSearchTerm($search_term);
    $result = $test->_Search();
}

?>
