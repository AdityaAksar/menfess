<?php 
            if (!$result_post) {
                die("Query error: " . mysqli_error($db));
            }

            while ($row = mysqli_fetch_assoc($result_post)) {
                $post_id = $row['id_post'];
                $user_id = $_SESSION['id_user'];
            
                // Cek apakah user sudah like post ini
                $like_check_query = "SELECT id_like FROM likes WHERE id_post = $post_id AND id_user = $user_id";
                $like_check_result = mysqli_query($db, $like_check_query);
                $is_liked = mysqli_num_rows($like_check_result) > 0;
            
                // Pilih warna tombol sesuai status like
                $like_btn_class = $is_liked ? 'btn-success' : 'btn-secondary';
            
                echo "<div class='col-12 mb-4'>
                    <div class='card mx-auto' style='max-width: 600px;'>
                        <div class='card-body'>
                            <h5 class='card-title mb-3'>".htmlspecialchars($row["name"])."</h5>
                            <h6 class='card-subtitle mb-2 text-body-secondary'>".htmlspecialchars($row["tanggal_posting"])."</h6>
                            <p class='card-text'>".nl2br(htmlspecialchars($row["content"]))."</p>
                            <form action='like.php' method='POST' class='d-inline'>
                                <input type='hidden' name='post_id' value='".$post_id."'>
                                <button type='submit' class='btn $like_btn_class'>
                                    <img src='./node_modules/bootstrap-icons/icons/hand-thumbs-up.svg'> 
                                    ".$row['like_count']." Like
                                </button>
                            </form>
                            <a href='#' class='btn btn-success' data-bs-toggle='modal' data-bs-target='#commentModal' 
                                onclick='loadComments($post_id)'>
                                <img src='./node_modules/bootstrap-icons/icons/chat.svg'> Comment
                            </a>
                        </div>
                    </div>
                </div>";
            }
            
            ?>