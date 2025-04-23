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

<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery-3.7.1.min.js"></script>
<script src="assets/js/custome.js?v=<?php time() ?>"></script>
</body>

</html>