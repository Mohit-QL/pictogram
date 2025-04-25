<?php
global $user;
global $posts;
global $follow_suggestion;
$name = $user['first_name'] . ' ' . $user['last_name'];

// echo "<pre>";
// print_r($user);
// print_r("ID = " . $user['id']);
// die();



?>

<div class="container col-9 rounded-0 d-flex justify-content-between">
    <div class="col-8">
        <?php
        showError('post_image');
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $check = checkLike($post['id']);
                $alreadyLiked = ($check['user']['ROW'] ?? 0) > 0;
                $post['likes_count'] = getLikesCount($post['id']);
                $likes = getPostLikes($post['id']);
        ?>
                <div class="card mt-4">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <a href="?u=<?php echo $post['username']; ?>" class="d-flex align-items-center text-decoration-none text-black p-2">
                            <img src="assets/images/Profile/<?php echo $post['profile_pic'] ?>" alt="" height="30" style="height: 30px; width:30px; object-fit:cover;" class="rounded-circle border">
                            &nbsp;&nbsp;<?php echo $post['first_name'] ?> <?php echo $post['last_name'] ?>
                        </a>
                        <div class="p-2">
                            <i class="bi bi-three-dots-vertical"></i>
                        </div>
                    </div>
                    <img src="assets/images/Post/<?php echo $post['post_img'] ?>" class="" alt="Post Image" style="object-fit: contain; width: 100%;">
                    <h4 style="font-size: x-larger" class="p-2 m-0 d-flex align-items-center">
                        <i class="d-block me-3 bi <?= $alreadyLiked ? 'bi-heart-fill' : 'bi-heart' ?> like_btn"
                            data-post-id="<?= $post['id'] ?>"
                            style="cursor: pointer; <?= $alreadyLiked ? 'color: red;' : '' ?>"></i>
                        <i class="d-block bi bi-chat" style="margin-top: -4px;"></i>
                    </h4>
                    <span class="likes-count d-block border-bottom px-2"
                        style="font-size: 17px; letter-spacing: 1px;"
                        data-bs-toggle="modal"
                        data-bs-target="#likes<?php echo $post['id']; ?>"
                        data-post-id="<?php echo $post['id']; ?>">
                        <?= $post['likes_count'] ?? 0 ?> likes
                    </span>

                    <?php if (!empty($post['post_text'])) { ?>
                        <div class="card-body">
                            <?php echo $post['post_text'] ?>
                        </div>
                    <?php } ?>

                    <!-- Comment Form -->
                    <form action="assets/php/add_comment.php" method="POST" class="input-group p-2 <?php echo !empty($post['post_text']) ? 'border-top' : ''; ?>">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <input type="text" name="comment" class="form-control rounded-0 border-0 border-bottom mb-3 pb-3" placeholder="Say something..." required>
                        <button class="btn btn-outline-primary rounded-0 border-0 border-bottom fs-5 ms-3 mb-3 px-5 py-2" type="submit" name="submit_comment">Post</button>
                    </form>
                    <style>
                        .show-more-comments {
                            display: inline-block;
                            margin-top: 5px;
                            cursor: pointer;
                            font-size: 14px;
                        }
                    </style>
                    <!-- Comment Display Section -->
                    <?php
                    $comments = getPostComments($post['id']);
                    $totalComments = count($comments);
                    $maxVisible = 1;
                    ?>

                    <?php if (!empty($comments)): ?>
                        <div class="px-3 pb-2 comment-section" id="comment-section-<?= $post['id'] ?>">
                            <?php foreach ($comments as $index => $c): ?>
                                <div class="d-flex align-items-start mb-2 border-bottom mb-2 pb-2 comment <?= $index >= $maxVisible ? 'd-none' : '' ?>" data-post-id="<?= $post['id'] ?>" data-comment-id="<?= $c['id'] ?>">
                                    <img src="assets/images/Profile/<?= $c['profile_pic'] ?>" class="rounded-circle me-4 mt-2" width="30" height="30" style="object-fit: cover;">
                                    <div>
                                        <strong><?= $c['first_name'] . ' ' . $c['last_name'] ?></strong>
                                        <p class="m-0"><?= htmlspecialchars($c['comment']) ?></p>
                                        <small class="text-muted"><?= date("d M Y, H:i", strtotime($c['created_at'])) ?></small>
                                    </div>

                                    <?php if ($user['id'] == $c['user_id']) { ?>
                                        <div class="ms-auto pt-4 pe-3">
                                            <a href="javascript:void(0);" class="text-danger ms-2 delete-comment text-decoration-none" data-comment-id="<?= $c['id'] ?>" data-post-id="<?= $post['id'] ?>">Delete</a>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php endforeach; ?>

                            <!-- Show More / Show Less Toggle -->
                            <?php if ($totalComments > $maxVisible): ?>
                                <div class="text-center mt-3">
                                    <a href="javascript:void(0);" class="text-primary toggle-comments text-decoration-none text-black" data-post-id="<?= $post['id'] ?>" data-show-more="true">Show more...</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>



                </div>

                <!-- LikeList Modal -->
                <div class="modal fade" id="likes<?php echo $post['id'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Likes</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <?php if (!empty($likes)): ?>
                                    <?php foreach ($likes as $follower): ?>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center gap-2">
                                                <img src="assets/images/Profile/<?= $follower['profile_pic'] ?>" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                                <div class="ms-2">
                                                    <strong><?= $follower['first_name'] . ' ' . $follower['last_name'] ?></strong>
                                                    <div class="text-muted">@<?= $follower['username'] ?></div>
                                                </div>
                                            </div>
                                            <?php if ($user['id'] != $follower['id']) { ?>
                                                <div class="d-flex gap-2 align-items-center my-1">
                                                    <?php if (isFollowed($follower['id'])) { ?>
                                                        <button class="btn btn-sm btn-danger follow-action" data-user-id="<?= $follower['id'] ?>" data-action="unfollow">Unfollow</button>
                                                    <?php } else { ?>
                                                        <button class="btn btn-sm btn-primary follow-action" data-user-id="<?= $follower['id'] ?>" data-action="follow">Follow</button>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">No likes yet.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo '<div class="alert alert-info mt-4">No posts to show yet. Follow someone or create your own post!</div>';
        }
        ?>
    </div>



    <style>
        .follow-btn {
            min-width: 100px;
            padding: 5px 12px;
            background-color: #0d6efd;
            color: #fff;
            border: none;
            text-align: center;
            transition: all 0.2s ease-in-out;
        }

        .follow-btn:hover {
            background-color: #0b5ed7;
        }
    </style>

    <div class="col-4 mt-4 p-3">

        <a href="?u=<?php echo $user['username']; ?>" class="d-flex align-items-center text-decoration-none text-black p-2">
            <div><img src="assets/images/Profile/<?php echo $user['profile_pic'] ?>" alt="" style="height: 60px;width: 60px;object-fit: cover;" class="rounded-circle border">
            </div>
            <div>&nbsp;&nbsp;&nbsp;</div>
            <div class="d-flex flex-column justify-content-center">
                <h6 style="margin: 0px;"><?php echo $name; ?></h6>
                <p style="" class="text-muted m-0">@<?php echo $user['username']; ?></p>
            </div>
        </a>

        <div>
            <h6 class="text-muted p-2">You Can Follow Them</h6>

            <?php if (count($follow_suggestion) < 1) { ?>
                <p class="text-muted" style="padding: 8px;">No suggestions available right now. Maybe try later!</p>
            <?php } else { ?>
                <?php foreach ($follow_suggestion as $follow) { ?>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center">
                            <a href="?u=<?php echo $follow['username']; ?>" class="d-flex align-items-center text-decoration-none text-black p-2">

                                <div><img src="assets/images/Profile/<?php echo $follow['profile_pic']; ?>" alt="" style="height: 40px;width: 40px;object-fit: cover;" class="rounded-circle border"></div>
                                <div>&nbsp;&nbsp;</div>
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 style="margin: 0px;font-size: small;"><?php echo $follow['first_name'] . ' ' . $follow['last_name']; ?></h6>
                                    <p style="margin:0px;font-size:small" class="text-muted">@<?php echo $follow['username']; ?></p>
                                </div>
                            </a>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-primary follow-btn" data-user-id="<?php echo $follow['id']; ?>">Follow</button>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>

</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<!-- Your Follow AJAX Script -->
<script>
    $('.follow-btn').click(function() {
        var userId = $(this).data('user-id');
        var button = $(this);

        $.ajax({
            url: 'assets/php/follow_user.php',
            method: 'POST',
            data: {
                user_id: userId
            },
            success: function(response) {
                console.log("AJAX Response:", response);
                if (response.trim() === "success") {
                    button.text('Following');
                } else {
                    alert("Something went wrong! " + response);
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error:", error);
                alert("AJAX request failed!");
            }
        });
    });

    // $(document).on('click', '.like_btn', function() {
    //     var postId = $(this).data('post-id');
    //     var button = $(this);
    //     var isLiked = button.hasClass('bi-heart-fill');

    //     var url = isLiked ? 'assets/php/ajax.php?unlike' : 'assets/php/ajax.php?like';

    //     button.attr('disabled', true);

    //     $.ajax({
    //         url: url,
    //         method: 'POST',
    //         data: {
    //             post_id: postId
    //         },
    //         success: function(response) {
    //             console.log("AJAX Response:", response);
    //             button.attr('disabled', false);

    //             let res = JSON.parse(response);
    //             if (res.status) {
    //                 if (res.liked) {
    //                     button.removeClass('bi-heart').addClass('bi-heart-fill').css('color', 'red');
    //                 } else {
    //                     button.removeClass('bi-heart-fill').addClass('bi-heart').css('color', '');
    //                 }
    //             }
    //         },
    //         error: function() {
    //             button.attr('disabled', false);
    //             alert("AJAX request failed!");
    //         }
    //     });
    // });

    $(document).on('click', '.like_btn', function() {
        var postId = $(this).data('post-id');
        var button = $(this);
        var isLiked = button.hasClass('bi-heart-fill');

        var url = isLiked ? 'assets/php/ajax.php?unlike' : 'assets/php/ajax.php?like';

        button.attr('disabled', true);

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                post_id: postId
            },
            success: function(response) {
                button.attr('disabled', false);
                let res = JSON.parse(response);

                if (res.status) {
                    if (res.liked) {
                        button.removeClass('bi-heart').addClass('bi-heart-fill').css('color', 'red');
                    } else {
                        button.removeClass('bi-heart-fill').addClass('bi-heart').css('color', '');
                    }

                    $('.likes-count[data-post-id="' + postId + '"]').text(res.likes_count + ' likes');
                }
            },
            error: function() {
                button.attr('disabled', false);
                alert("AJAX request failed!");
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.toggle-comments', function() {
            var postId = $(this).data('post-id');
            var showMore = $(this).data('show-more');
            var commentSection = $('#comment-section-' + postId);

            if (showMore) {
                commentSection.find('.comment.d-none').removeClass('d-none');
                $(this).data('show-more', false).text('Show less...');
            } else {
                commentSection.find('.comment').each(function(index) {
                    if (index >= <?= $maxVisible ?>) {
                        $(this).addClass('d-none');
                    }
                });
                $(this).data('show-more', true).text('Show more...');
            }
        });
    });
</script>
<script>
    $(document).on('click', '.delete-comment', function() {
        var comment_id = $(this).data('comment-id');
        var post_id = $(this).data('post-id');

        $.ajax({
            url: 'assets/php/delete_comment.php',
            type: 'POST',
            data: {
                comment_id: comment_id,
                post_id: post_id
            },
            success: function(response) {
                console.log("Response from server:", response);
                if (response === "Comment deleted successfully") {
                    $('[data-comment-id="' + comment_id + '"]').remove();
                } else {
                    alert(response);
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX error:", error);
                alert("An error occurred while deleting the comment.");
            }
        });

    });
</script>