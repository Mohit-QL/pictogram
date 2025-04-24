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
    <?php global $profile_post; ?>
    <div class="gallery d-flex flex-wrap gap-3 mb-4 mt-3">
        <?php if (!empty($profile_post)): ?>
            <?php foreach ($profile_post as $post): ?>
                <img src="assets/images/Post/<?= $post['post_img'] ?>" width="400px" class="rounded" />
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-muted text-center w-100 py-5">
                <i class="bi bi-image" style="font-size: 2rem;"></i><br>
                <strong>No posts to show yet.</strong><br>
                Start sharing your moments!
            </div>
        <?php endif; ?>
    </div>


</div>

<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body d-flex p-0">
                <div class="col-8">
                    <img src="img/post2.jpg" class="w-100 rounded-start">
                </div>



                <div class="col-4 d-flex flex-column">
                    <div class="d-flex align-items-center p-2 border-bottom">
                        <div><img src="./img/profile.jpg" alt="" height="50" class="rounded-circle border">
                        </div>
                        <div>&nbsp;&nbsp;&nbsp;</div>
                        <div class="d-flex flex-column justify-content-start align-items-center">
                            <h6 style="margin: 0px;">Monu Giri</h6>
                            <p style="margin:0px;" class="text-muted">@oyeitsmg</p>
                        </div>
                    </div>
                    <div class="flex-fill align-self-stretch overflow-auto" style="height: 100px;">

                        <div class="d-flex align-items-center p-2">
                            <div><img src="./img/profile2.jpg" alt="" height="40" class="rounded-circle border">
                            </div>
                            <div>&nbsp;&nbsp;&nbsp;</div>
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <h6 style="margin: 0px;">@osilva</h6>
                                <p style="margin:0px;" class="text-muted">its nice pic very good</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center p-2">
                            <div><img src="./img/profile2.jpg" alt="" height="40" class="rounded-circle border">
                            </div>
                            <div>&nbsp;&nbsp;&nbsp;</div>
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <h6 style="margin: 0px;">@osilva</h6>
                                <p style="margin:0px;" class="text-muted">its nice pic very good</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center p-2">
                            <div><img src="./img/profile2.jpg" alt="" height="40" class="rounded-circle border">
                            </div>
                            <div>&nbsp;&nbsp;&nbsp;</div>
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <h6 style="margin: 0px;">@osilva</h6>
                                <p style="margin:0px;" class="text-muted">its nice pic very good</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-center p-2">
                            <div><img src="./img/profile2.jpg" alt="" height="40" class="rounded-circle border">
                            </div>
                            <div>&nbsp;&nbsp;&nbsp;</div>
                            <div class="d-flex flex-column justify-content-start align-items-start">
                                <h6 style="margin: 0px;">@osilva</h6>
                                <p style="margin:0px;" class="text-muted">its nice pic very good</p>
                            </div>
                        </div>

                    </div>
                    <div class="input-group p-2 border-top">
                        <input type="text" class="form-control rounded-0 border-0" placeholder="say something.."
                            aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-primary rounded-0 border-0" type="button"
                            id="button-addon2">Post</button>
                    </div>
                </div>



            </div>

        </div>
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


<!-- Modal -->
<div class="modal fade" id="addpost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="max-height: 900px; max-width:800px">
            <div class="modal-header">
                <h5 class="modal-title">Add New Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto">
                <img src="" id="post_image" class="w-100 rounded border mb-3" style="display: none;">
                <form method="POST" action="assets/php/actions.php?add_post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input class="form-control" type="file" id="select_post_image" name="post_image">

                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Say Something</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Write a caption..." name="post_text"></textarea>

                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
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