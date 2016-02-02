<?php
    require_once 'vendor/autoload.php';
    
    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
    $settings = array(
        'oauth_access_token' => $_ENV['TTA_TOKEN'],
        'oauth_access_token_secret' => $_ENV['TTA_SECRET'],
        'consumer_key' => $_ENV['TTC_KEY'],
        'consumer_secret' => $_ENV['TTC_SECRET']
    );
    
    $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
    $requestMethod = "GET";
    $getfield = '?screen_name=bladeandsoul&count=10';
    $twitter = new TwitterAPIExchange($settings);
    
    $string = json_decode($twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest(),$assoc = TRUE);
?>


<div id="ribbon">
    <div class="media">
        <div class="panel panel-default">
<?php
    foreach($string as $items)
    {
        $dt = DateTime::createFromFormat('D M d H:i:s P Y', $items['created_at']);
?>
        
            <div class="panel-heading">
                <a href="https://twitter.com/bladeandsoul">
                    <img class="media-object" src="<?php echo $items['user']['profile_image_url'] ?>" alt="Generic placeholder image">
                </a>
                <h4 class="media-heading"><?php echo $items['user']['name'] ?></h4>
                <h6 class="media-heading"><?php echo $dt->format('D M d Y g:i A') ?></h6>
            </div>
            <div class="panel-body">
                <?php echo $items['text'] ?>
            </div>
<?php
    }
?>
        </div>
    </div>
</div>
