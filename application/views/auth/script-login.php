<script>
    $(document).ready(function() {
        $('#btnLogin').on('click', function(e) {
            e.preventDefault();
            var url = '<?= base_url('login') ?>';

            var data = {
                'username': $('#user-login').val(),
                'password': $('#password-login').val(),
                'action': 'login'
            };

            console.log(data);

            $.ajax({
                url: url,
                data: data,
                type: 'post',
                dataType: 'json',
                cache: 'false',
                beforeSend: function() {

                },
                success: function(data) {
                    if (parseInt(data.stat) === 1) {
                        $('#message-notif').append(data.mesg);
                        setTimeout(function() {
                            window.location.href = '<?= base_url() ?>' + data.data;
                        }, 500);
                    } else if (parseInt(data.stat) === 0) {
                        $('#message-notif').append(data.mesg);
                    }
                },
                error: function(xhr, status, err) {

                }
            });
        });

    });
</script>