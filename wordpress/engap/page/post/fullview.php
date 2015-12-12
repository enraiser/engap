<?php
  header('Access-Control-Allow-Origin: *');
     header('Cache-Control: max-age=2592000');
require( dirname(dirname(dirname(dirname(dirname(dirname( __FILE__ )))))) . '/wp-load.php' );
    $id = $_GET['id'];
    error_log("ID   =  ".$id);
    $post = get_post($id);
    $authorid  = get_the_author_id($post);
    $iconurl = get_avatar_url($authorid);
?>

<ons-page   style="background-color: #f9f9f9;" >
    <ons-toolbar>
        <div class="left" style="color: #1284ff;" onclick="handle_go_back()"><ons-icon icon="ion-android-arrow-back"></ons-icon>Back</div>
<div class="center"><?php echo $post->post_title;?></div>
        <div class="right" style="margin-right:15px;">
            <ons-icon icon="ion-android-share" onclick='load_page("sharepage");'></ons-icon>
        </div>
    </ons-toolbar>
<div >
<img src="<?php echo $iconurl ?>" width='100px' alt='entry photo' />
<?php echo "<h3>".$post->post_title; ?></h3>
<?php echo  $post->post_content; ?>
</ons-page>