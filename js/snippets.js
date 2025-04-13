// function setPostId(postId) {
//     document.querySelector('input[name="id_post"]').value = postId;
//     const url = new URL(window.location.href);
//     url.searchParams.set('id_post', postId);
//     window.history.pushState({}, '', url);
// }
document.addEventListener('DOMContentLoaded', function() {
    const commentForm = document.getElementById('comment-form');
    
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const postId = document.querySelector('input[name="id_post"]').value;
            const commentContent = document.querySelector('textarea[name="comment_content_form"]').value;
            
            if (!postId || !commentContent.trim()) {
                alert('Please enter a comment');
                return;
            }
            
            const formData = new FormData();
            formData.append('id_post', postId);
            formData.append('comment_content_form', commentContent);
            formData.append('kirim_comment', 'true');
            
            fetch('process_comment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('textarea[name="comment_content_form"]').value = '';
                    
                    loadComments(postId);
                    
                    Swal.fire({
                        title: 'Success',
                        text: 'Your comment has been posted!',
                        icon: 'success',
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.message || 'Failed to post comment',
                        icon: 'error',
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred. Please try again.',
                    icon: 'error',
                });
            });
        });
    }
});

(() => {
    'use strict'
    
    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(form => {
        const passwordInput = form.querySelector('#password');
        
        passwordInput.addEventListener('input', () => {
            if (passwordInput.value.length <= 7) {
                passwordInput.setCustomValidity('Password harus lebih dari 8 karakter');
            } else {
                passwordInput.setCustomValidity('');
            }
            passwordInput.reportValidity();
        });

        form.addEventListener('submit', event => {
            if (passwordInput.value.length <= 8) {
                passwordInput.setCustomValidity('Password harus lebih dari 8 karakter');
                event.preventDefault();
                event.stopPropagation();
            } else {
                passwordInput.setCustomValidity('');
            }
            
            form.classList.add('was-validated');
            
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
        }, false)
    })
    
    const commentModal = document.getElementById('commentModal');
    if (commentModal) {
        commentModal.addEventListener('hidden.bs.modal', function () {
            const url = new URL(window.location.href);
            url.searchParams.delete('id_post');
            window.history.replaceState({}, document.title, url.toString());
            
            location.reload();
        });
    }
    
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('id_post')) {
            const modal = new bootstrap.Modal(document.getElementById('commentModal'));
            modal.show();
        }
    });


})();