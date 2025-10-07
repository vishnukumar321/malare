<main>
  <?php
  include_once "lib/load.php";
  if (session::session_get('token')) {
    include __DIR__ . "/index/_logged.php";
  } else {
    include __DIR__ . "/index/_not_login.php";
  }
  ?>

  <div class="album py-5 bg-body-tertiary">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php
        $post_ids=post::getallposts();
        foreach($post_ids as $post){
          $post_data=new post($post['id']);
          ?>
          <div class="col">
          <div class="card shadow-sm">
            <!-- <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
              <title>Placeholder</title>
              <rect width="100%" height="100%" fill="https://funloader.selfmade.social/image.php?name=08b20d2bccde94ff7166b57018a2977cjpg" /><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
            </svg> -->
            <img src="<?=$post_data->getimage_url()?>" alt="" class="bd-placeholder-img card-img-top" width="100%" height="225">
            <div class="card-body">
              <p class="card-text"><?=$post_data->getpost_text()?></p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                </div>
                <small class="text-body-secondary">9 mins</small>
              </div>
            </div>
          </div>
        </div>
          <?php
        }
        ?>
    </div>
  </div>

</main>
<?php
if (isset($_GET['logout'])) {
  session::session_delete();
}

?>