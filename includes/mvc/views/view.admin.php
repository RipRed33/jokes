<?php
class Admin_View {
    public function admin_dashboard_view($data){
        ?>
        <div class="container">
            <div class="section facts">
                <h2 class="header indigo-text lighten-1 section-title">
                    <span><i class="material-icons">insert_chart</i>Dashboard Administration</span>
                </h2>

                <div class="row">
                    <div class="col s12 m3">
                        <a href="http://localhost/jokes/admin/blagues">
                            <div class="card pink accent-3">
                                <div class="card-content white-text">
                                    <i class="material-icons">playlist_add_check</i>
                                    <span class="card-title">Gérer les nouvelles blagues</span>
                                    <p class="bounceEffect animated bounceIn">
                                        <?php echo sizeof($data); ?> blagues à traiter
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col s12 m3">
                        <a href="http://localhost/jokes/admin/blagues">
                            <div class="card pink accent-3">
                                <div class="card-content white-text">
                                    <i class="material-icons">library_books</i>
                                    <span class="card-title">Voir toutes les blagues</span>
                                    <p class="bounceEffect animated bounceIn">
                                        X blagues au total
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col s12 m3">
                        <a href="http://localhost/jokes/admin/blagues">
                            <div class="card pink accent-3">
                                <div class="card-content white-text">
                                    <i class="material-icons">group</i>
                                    <span class="card-title">Voir tous les utilisateurs</span>
                                    <p class="bounceEffect animated bounceIn">
                                        X utilisateurs au total
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <?php
    }

    public function admin_navbar_view(){
        ?>
        <div class="container">
            <div class="section">
                <a href="http://localhost/jokes/admin" class="waves-effect waves-light btn orange">Retour au dashboard</a>
            </div>
        </div>

        <?php
    }

    public function manage_jokes_view($data){
        ?>
        <div class="container">
            <?php
            if (isset($data) && !empty($data)){
                foreach ($data as $key => $joke){
                    ?>
                    <div class="section">
                        <div class="card" id="<?php echo $joke['id']; ?>">
                            <div class="card-header">
                                <div class="chip">
                                    <img src="<?php echo $joke['author']['avatar']; ?>" alt="Avatar">
                                    <?php echo $joke['author']['display_name']; ?>
                                </div>
                                <div class="chip">
                                    <?php echo $joke['created']; ?>
                                </div>
                                <div class="chip">
                                    <?php echo $joke['status']; ?>
                                </div>
                            </div>
                            <div class="card-content">
                                <i class="material-icons right activator">more_vert</i></span>
                                <span class="card-title grey-text text-darken-4 joke-title">
                                    <?php echo $joke['title']; ?>
                                </span>
                                <div class="card-content-content joke-content">
                                    <?php echo $joke['content']; ?>
                                </div>
                            </div>
                            <div class="card-action">
                                <span class="admin-action">
                                    <a class="waves-effect waves-light btn blue" onclick="valid_jokes(this)" data-status="active">
                                        <i class="material-icons right">done</i>Valider
                                    </a>
                                    <a class="waves-effect waves-light btn red" onclick="valid_jokes(this)" data-status="archive">
                                        <i class="material-icons right">not_interested</i>Archiver
                                    </a>
                                </span>
                                <span class="edit-action" style="display:none;">
                                    <a class="valid_edit waves-effect waves-light btn blue" onclick="valid_edit(this)" data-status="active">
                                        <i class="material-icons right">done</i>Valider la modification
                                    </a>
                                    <a class="cancel_edit waves-effect waves-light btn red" onclick="cancel_edit(this)" data-status="active">
                                        <i class="material-icons right">not_interested</i>Annuler la modification
                                    </a>
                                </span>
                            </div>
                            <div class="card-reveal">
                              <span class="card-title grey-text text-darken-4">Que souhaitez-vous faire ?<i class="material-icons right">close</i></span>
                                <a class="waves-effect waves-light btn blue" onclick="edit_joke(this)">Modifier la blague</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            else {
                ?>
                <h4>Il ne reste plus aucune blague à moderer.</h4>
                <?php
            } ?>
        </div>
        <script type="text/javascript">
        var cache_title = "";
        var cache_content = "";

        function edit_joke(clicked){
            var element = jQuery(clicked).closest('.card');
            var title = jQuery(element).find('.joke-title').text().trim();
            var content = jQuery(element).find('.joke-content').text().trim();
            jQuery(element).find('.joke-title').html('<input type="text" placeholder="Proposer un titre" value="'+title+'" />');
            jQuery(element).find('.joke-content').html('<textarea class="materialize-textarea type="text" placeholder="Proposer un titre">'+content+'</textarea>');
            jQuery(element).find('.edit-action').show();
            jQuery(element).find('.admin-action').hide();
        }

        function valid_edit(clicked){
            var element = jQuery(clicked).closest('.card');
            var title = jQuery(element).find('.joke-title input').val().trim();
            var content = jQuery(element).find('.joke-content textarea').text().trim();
            jQuery(element).find('.joke-title').html(title);
            jQuery(element).find('.joke-content').html(content);
            jQuery(element).find('.edit-action').hide();
            jQuery(element).find('.admin-action').show();
        }

        function valid_jokes(clicked){
            var status = jQuery(clicked).attr('data-status');
            var id = jQuery(clicked).closest('.card').attr('id');
            var element = jQuery(clicked).closest('.card');
            var title = jQuery(element).find('.joke-title').text().trim();
            var content = jQuery(element).find('.joke-content').text().trim();
            var ajax = $.ajax({
                url: ajaxurl,
                data: {
                    from: 'admin',
                    action: 'valid_joke',
                    id : id,
                    status: status,
                    title: title,
                    content: content,
                },
                type: 'POST',
                dataType : 'json',
                beforeSend: function (jqXHR, settings) {
                    url = settings.url + "?" + settings.data;
                    console.log(url);
                },
                error: function (thrownError) {
                    console.log(thrownError);
                    alert(thrownError.responseText);
                },
                complete: function () {
                },
                success: function (data, status) {
                    console.log(data);
                    if ( data.success){
                        alert(data.message);
                        jQuery(element).fadeOut( "slow", function() {
                            // Animation complete.
                        });
                    }
                    else {
                        alert(data.message);
                    }
                }
            });
        }
        </script>
        <?php
    }


}
?>
