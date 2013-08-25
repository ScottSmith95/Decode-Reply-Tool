<div class="decode-reply-tool-plugin">

	<a href="https://twitter.com/intent/tweet?screen_name=<?php echo get_option( 'twitter-username' ); ?>&text=(about%3A%20<?php the_permalink(); ?>) " class="twitterreply replylink left" target="_blank" data-related="<?php echo get_option( 'twitter-username' ); ?>"><?php _e( 'With Twitter', 'decode-reply-tool' ); ?></a>

	<div class="replytrigger"><?php _e( 'Reply', 'decode-reply-tool' ); ?></div>

	<a href="https://alpha.app.net/intent/post?text=@<?php echo get_option( 'adn-username' ); ?> (about%3A%20<?php the_permalink(); ?>) " class="adnreply replylink right" target="_blank"><?php _e( 'With ADN', 'decode-reply-tool' ); ?></a>

</div>