<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
        <meta charset="<?php echo esc_attr(get_bloginfo('charset')); ?>">
        <meta name="viewport" content="width=device-width">
        <link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>
<body class="antialiased">
	<div class="md:flex min-h-screen">
		<div class="w-full md:w-1/2 flex items-center justify-center">
			<div class="max-w-sm m-8">
				<div class="text-5xl md:text-15xl text-dark border-light border-b">404</div>
				<div class="w-16 h-1 bg-purple-light my-3 md:my-6"></div>
                                <p class="text-dark/90 text-2xl md:text-3xl font-light leading-relaxed mb-8"><?php esc_html_e( 'Sorry, the page you are looking for could not be found.', 'webmakerr' ); ?></p>
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex rounded px-4 py-1.5 text-sm font-semibold transition bg-dark text-white hover:bg-dark/90 !no-underline">
                                        <?php esc_html_e( 'Go Home', 'webmakerr' ); ?>
				</a>
			</div>
		</div>
	</div>

    <?php wp_footer(); ?>
</body>
</html>
