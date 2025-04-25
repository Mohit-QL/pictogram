<?php
global $profile;
global $user;
global $profile_post;
$followersList = getFollowersList($profile['id']);
$followingList = getFollowingList($profile['id']);



?>

<div class="container col-9 rounded-0">
    <div class="col-12 rounded p-4 mt-4 d-flex gap-5">
        <div class="col-4 d-flex justify-content-end align-items-start"><img src="assets/images/Profile/<?php echo $profile['profile_pic']; ?>"
                class="img-thumbnail rounded-circle my-3" style="height:170px; width: 170px;object-fit: cover;" alt="...">
        </div>
        <div class="col-8">
            <div class="d-flex flex-column">
                <div class="d-flex gap-5 align-items-center">
                    <span style="font-size: xx-large;"> <?= $profile['first_name'] . ' ' . $profile['last_name']; ?></span>
                    <?php if ($user['id'] !== $profile['id']) { ?>
                        <div class="dropdown">
                            <span class="" style="font-size:xx-large" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-three-dots"></i> </span>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-chat-fill"></i> Message</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-x-circle-fill"></i> Block</a></li>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
                <span style="font-size: larger;" class="text-secondary">@<?= $profile['username'] ?></span>
                <div class="d-flex gap-2 align-items-center my-3">
                    <a class="btn btn-sm btn-primary">
                        <i class="bi bi-file-post-fill"></i> <?= count($profile_post) ?> Posts
                    </a>
                    <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#followersModal">
                        <i class="bi bi-people-fill"></i> <?= getFollowersCount($profile['id']) ?> Followers
                    </a>
                    <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#followingModal">
                        <i class="bi bi-person-fill"></i> <?= getFollowingCount($profile['id']) ?> Following
                    </a>
                </div>

                <?php if ($user['id'] != $profile['id']) { ?>
                    <div class="d-flex gap-2 align-items-center my-1">
                        <?php if (isFollowed($profile['id'])) { ?>
                            <button class="btn btn-sm btn-danger follow-action" data-user-id="<?= $profile['id'] ?>" data-action="unfollow">Unfollow</button>
                        <?php } else { ?>
                            <button class="btn btn-sm btn-primary follow-action" data-user-id="<?= $profile['id'] ?>" data-action="follow">Follow</button>
                        <?php } ?>
                    </div>
                <?php } ?>


            </div>
        </div>


    </div>


    <h3 class="border-bottom pb-2 ">Posts</h3>
    <?php global $profile_post;
    // echo "<pre>";
    // print_r($user);
    ?>
    <div class="gallery d-flex flex-wrap gap-3 mb-4 mt-3">
        <?php if (!empty($profile_post)): ?>
            <?php foreach ($profile_post as $post): ?>

                <img src="assets/images/Post/<?= $post['post_img'] ?>" class="post-image" style="cursor: pointer;" width="400" data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                    data-post-id="<?php echo $post['id'] ?>"
                    ?>
            <?php endforeach; ?>
            <!-- CommentsList Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body d-flex p-0">
                            <div class="col-8">
                                <img id="modal-post-image" src="" class="w-100 rounded-start">
                            </div>
                            <div class="col-4 d-flex flex-column">
                                <div class="d-flex align-items-center p-2 border-bottom">
                                    <div><img id="modal-profile-image" src="" alt="" height="50" style="height:50px; width:50px; object-fit:cover;" class="rounded-circle border"></div>
                                    <div>&nbsp;&nbsp;&nbsp;</div>
                                    <div class="d-flex flex-column justify-content-start align-items-center">
                                        <h6 id="modal-username" style="margin: 0px;"></h6>
                                        <p id="modal-userhandle" style="margin: 0px;" class="text-muted"></p>
                                    </div>
                                </div>
                                <div class="flex-fill align-self-stretch overflow-auto p-4" style="height: 100px;">
                                    <!-- Comments will be loaded here dynamically -->
                                </div>


                                <form action="assets/php/add_comment.php" method="POST" class="input-group p-2 <?php echo !empty($post['post_text']) ? 'border-top' : ''; ?>">
                                    <div class="input-group p-2 border-top">
                                        <input type="hidden" id="modal-post-id" name="post_id" value="<?= $post['id'] ?>">
                                        <input type="text" name="comment" class="form-control rounded-0 border-0" placeholder="Say something..." required>
                                        <button class="btn btn-primary rounded border-0 ms-3" type="submit" name="submit_comment">Post</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-muted text-center w-100 py-5">
                <i class="bi bi-image" style="font-size: 2rem;"></i><br>
                <strong>No posts to show yet.</strong><br>
                Start sharing your moments!
            </div>
        <?php endif; ?>
    </div>
</div>








<!-- Followers Modal -->
<div class="modal fade" id="followersModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Followers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($followersList)): ?>
                    <?php foreach ($followersList as $follower): ?>
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
                    <p class="text-muted">Not following anyone yet.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<!-- Following Modal -->
<div class="modal fade" id="followingModal" tabindex="-1" aria-labelledby="followingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Following</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (!empty($followingList)): ?>
                    <?php foreach ($followingList as $following): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center gap-2">
                                <img src="assets/images/Profile/<?= $following['profile_pic'] ?>" alt="" class="rounded-circle" style="height: 40px; width: 40px; object-fit: cover;">
                                <div>
                                    <strong><?= $following['first_name'] . ' ' . $following['last_name'] ?></strong><br>
                                    <small class="text-muted">@<?= $following['username'] ?></small>
                                </div>
                            </div>
                            <?php if ($user['id'] === $_SESSION['user']['id']): ?>
                                <form action="assets/php/unfollow.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $following['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Unfollow</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Not following anyone yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.follow-action').click(function() {
        var userId = $(this).data('user-id');
        var action = $(this).data('action');
        var button = $(this);

        $.ajax({
            url: 'assets/php/follow_unfollow.php', // adjust this path accordingly
            method: 'POST',
            data: {
                user_id: userId,
                action: action
            },
            success: function(response) {
                console.log("AJAX Response:", response);
                if (response.trim() === "success") {
                    if (action === 'follow') {
                        button.text('Unfollow');
                        button.removeClass('btn-primary').addClass('btn-danger');
                        button.data('action', 'unfollow');
                    } else if (action === 'unfollow') {
                        button.text('Follow');
                        button.removeClass('btn-danger').addClass('btn-primary');
                        button.data('action', 'follow');
                    }
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
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all images that should trigger the modal
        const postImages = document.querySelectorAll('.gallery img');

        // Modal content elements
        const modalImage = document.getElementById('modal-post-image');
        const modalProfileImage = document.getElementById('modal-profile-image');
        const modalUsername = document.getElementById('modal-username');
        const modalUserHandle = document.getElementById('modal-userhandle');

        // Add event listeners to all images
        postImages.forEach(img => {
            img.addEventListener('click', function() {
                // Update modal content with data attributes
                modalImage.src = img.getAttribute('data-image');
                modalProfileImage.src = img.getAttribute('data-userimage');
                modalUsername.textContent = img.getAttribute('data-username');
                modalUserHandle.textContent = img.getAttribute('data-userhandle');
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(".post-image").on("click", function() {
            var postId = $(this).data("post-id");

            loadPostDetails(postId);

            // Update the hidden post_id input field in the modal form
            $('#modal-post-id').val(postId);

            $('#exampleModal').modal('show');
        });
    });

    function loadPostDetails(postId) {
        $.ajax({
            url: 'assets/php/getPostDetails.php',
            method: 'GET',
            data: {
                post_id: postId
            },
            success: function(response) {
                console.log('Post Details Response:', response);

                var postDetails = JSON.parse(response);
                if (postDetails.error) {
                    console.error(postDetails.error);
                } else {
                    $('#modal-post-image').attr('src', 'assets/images/Post/' + postDetails.post_img);
                    $('#modal-profile-image').attr('src', 'assets/images/Profile/' + postDetails.profile_pic);
                    $('#modal-username').text(postDetails.first_name + ' ' + postDetails.last_name);
                    $('#modal-userhandle').text('@' + postDetails.username);

                    loadPostComments(postId);
                }
            },
            error: function(xhr, status, error) {
                console.error('Failed to load post details', status, error);
                console.log('Response:', xhr.responseText);
            }
        });
    }


    function loadPostComments(postId) {
        $.ajax({
            url: 'assets/php/getPostComments.php',
            method: 'GET',
            data: {
                post_id: postId
            },
            success: function(response) {
                var comments = JSON.parse(response);
                var commentsHtml = '';


                comments.forEach(function(comment) {
                    var deleteButtonHtml = '';




                    commentsHtml += `
        <div class="d-flex align-items-start mb-2 border-bottom mb-2 pb-2 comment">
            <img src="assets/images/Profile/${comment.profile_pic}" class="rounded-circle me-4 mt-2" width="30" height="30" style="object-fit: cover;">
            <div>
                <strong>${comment.first_name} ${comment.last_name}</strong>
                <p class="m-0">${comment.comment}</p>
                <small class="text-muted">${comment.created_at}</small>
            </div>
           
        </div>
    `;
                });

                $('.modal-body .flex-fill').html(commentsHtml);
            },
            error: function() {
                console.error('Failed to load comments');
            }
        });
    }
</script>