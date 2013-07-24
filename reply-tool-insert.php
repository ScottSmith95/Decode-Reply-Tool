<div class="decode-reply-tool-plugin">

	<a href="https://twitter.com/intent/tweet?screen_name=<?php echo get_option( 'twitter-username' ); ?>&text=(about%3A%20<?php the_permalink(); ?>) " class="twitterreply replylink left" target="_blank" data-related="<?php echo get_option( 'twitter-username' ); ?>">With Twitter</a>

	<div class="replytrigger">Reply</div>

	<a href="https://alpha.app.net/intent/post?text=@<?php echo get_option( 'adn-username' ); ?> (about%3A%20<?php the_permalink(); ?>) " class="adnreply replylink right" target="_blank">With ADN</a>

</div>