</div>
<?php
require_once 'footer.php';
?>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script
        src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
        crossorigin="anonymous">
</script>
<script>
    window.onload = (event) => {

        let btnAddComment = document.querySelector('#btnAddComment');

        btnAddComment.addEventListener("click", updateComments);

        function updateComments() {
            let formData = new FormData();

            formData.append('username', document.querySelector('#user_name').value);
            formData.append('email', document.querySelector('#user_email').value);
            formData.append('comment', document.querySelector('#user_comment').value);

            axios({
                method: "post",
                url: "/",
                data: formData,
                headers: {"Content-Type": "multipart/form-data"},
            })
                .then(response => {
                    document
                        .querySelector('#comments_area')
                        .innerHTML = response.data +
                        document.querySelector('#comments_area').innerHTML;

                    //console.log(response.data);
                })
                .catch(response => {
                    console.log(response);
                });
        }

        function showSortComments() {
            let formData = new FormData();

            formData.append('sortByName', document.querySelector('#sort_by_name_value').value);
            formData.append('sortByDate', document.querySelector('#sort_by_date_value').value);

            axios({
                method: "post",
                url: "/sort",
                data: formData,
                headers: {"Content-Type": "multipart/form-data"},
            })
                .then(response => {
                    document
                        .querySelector('#comments_area')
                        .innerHTML = response.data;

                    //console.log(response.data);
                })
                .catch(response => {
                    console.log(response);
                });
        }

        let sortByName = document.querySelector('#sortByName');
        let sortByDate = document.querySelector('#sortByDate');

        function sortByNameHandler() {
            let sort = document.querySelector('#sort_by_name_value').value;
            document.querySelector('#sort_by_name_value').value = sort === 'ASC' ? 'DESC' : 'ASC';
            showSortComments();
        }

        sortByName.addEventListener("click", sortByNameHandler);

        function sortByDateHandler() {
            let sort = document.querySelector('#sort_by_date_value').value;
            document.querySelector('#sort_by_date_value').value = sort === 'ASC' ? 'DESC' : 'ASC';
            showSortComments();
        }

        sortByDate.addEventListener("click", sortByDateHandler);


    };
</script>
</body>
</html>