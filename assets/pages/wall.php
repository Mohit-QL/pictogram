<?php
global $user;
global $posts;
global $follow_suggestion;
$name = $user['first_name'] . ' ' . $user['last_name'];

?>

<div class="container col-9 rounded-0 d-flex justify-content-between">
    <div class="col-8">

        <?php
        showError('post_image');
        foreach ($posts as $post) {
        ?>

            <div class="card mt-4">
                <div class="card-title d-flex justify-content-between  align-items-center">

                    <div class="d-flex align-items-center p-2">
                        <img src="assets/images/Profile/<?php echo $post['profile_pic'] ?>" alt="" height="30" width="" class="rounded-circle border">&nbsp;&nbsp;<?php echo $post['first_name'] ?> <?php echo $post['last_name'] ?>
                    </div>
                    <div class="p-2">
                        <i class="bi bi-three-dots-vertical"></i>
                    </div>
                </div>
                <img src="assets/images/Post/<?php echo $post['post_img'] ?>" class="" alt="..." height="" style="object-fit: contain;">
                <h4 style="font-size: x-larger" class="p-2 border-bottom"><i class="bi bi-heart"></i>&nbsp;&nbsp;<i
                        class="bi bi-chat-left"></i>
                </h4>


                <?php if (!empty($post['post_text'])) { ?>
                    <div class="card-body">
                        <?php echo $post['post_text'] ?>
                    </div>
                <?php } ?>

                <div class="input-group p-2 <?php echo !empty($post['post_text']) ? 'border-top' : ''; ?>">
                    <input type="text" class="form-control rounded-0 border-0" placeholder="say something.."
                        aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary rounded-0 border-0" type="button"
                        id="button-addon2">Post</button>
                </div>

            </div>
        <?php
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
        <div class="d-flex align-items-center p-2">
            <div><img src="assets/images/Profile/<?php echo $user['profile_pic'] ?>" alt="" style="height: 60px;width: 60px;object-fit: cover;" class="rounded-circle border">
            </div>
            <div>&nbsp;&nbsp;&nbsp;</div>
            <div class="d-flex flex-column justify-content-center align-items-center">
                <h6 style="margin: 0px;"><?php echo $name; ?></h6>
                <p style="margin:0px;" class="text-muted"><?php echo $user['username']; ?></p>
            </div>
        </div>
        <div>
            <h6 class="text-muted p-2">You Can Follow Them</h6>

            <?php if (count($follow_suggestion) < 1) { ?>
                <p class="text-muted" style="padding: 8px;">No suggestions available right now. Maybe try later!</p>
            <?php } else { ?>
                <?php foreach ($follow_suggestion as $follow) { ?>
                    <div class="d-flex justify-content-between">
                        <div class="d-flex align-items-center p-2">
                            <div><img src="assets/images/Profile/<?php echo $follow['profile_pic']; ?>" alt="" style="height: 40px;width: 40px;object-fit: cover;" class="rounded-circle border"></div>
                            <div>&nbsp;&nbsp;</div>
                            <div class="d-flex flex-column justify-content-center">
                                <h6 style="margin: 0px;font-size: small;"><?php echo $follow['first_name'] . ' ' . $follow['last_name']; ?></h6>
                                <p style="margin:0px;font-size:small" class="text-muted">@<?php echo $follow['username']; ?></p>
                            </div>
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
</script>