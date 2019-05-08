<ul style="display: flex; flex-flow: wrap;">
    <?php foreach($result as $row): ?>
        <li class="post" data-id="<?php echo $row['id'];?>" value="<?php echo $row['id'];?>">

            <a href="account.php?userID=<?php echo $row['user_id']; ?>" id="user-link">
                <?php foreach ($username as $u): ?>
                    <?php if ($row['user_id'] == $u['id']):?>
                        <div id="user-img-div"><img src="images/uploads/avatar/<?php echo $u['user_img']; ?>" alt=""></div>
                        <h3><?php echo htmlspecialchars($u['username']); ?></h3>
                        <br><p id="time-set"><?php echo $row['time_set']; ?></p>

                        <p class="locationName"><?php echo $row['city']; ?></p>

                    <?php endif; ?>
                <?php endforeach; ?>
            </a>

           <br>
            <div id="img-div">
                <a href="details.php?watch=<?echo $row['id'];?>">
                    <figure class="<?php echo $row['filter'] ?>">
                        <img src="<?php echo 'images/uploads/'.$row['post_img']; ?>" alt="post_img" width="50px" height="auto">
                    </figure>
                </a>
            </div>
            <h2><?php echo htmlspecialchars($row['title']); ?></h2>




        </li>
    <?php endforeach; ?>
</ul>
