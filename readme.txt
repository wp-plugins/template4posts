=== Template4posts ===
Contributors: djudorange
Donate link: http://www.beapi.fr/donate/
Tags: template, posts, templating for posts, template for posts, multiple template
Requires at least: 2.0
Tested up to: 2.0
Stable tag: 2.1

This plugin allows you to display items in the lists with a particular template

== Description ==

This plugin allows you to display items in the lists with a particular template

== Installation ==

1. Download, unzip and upload to your WordPress plugins directory
2. Activate the plugin within you WordPress Administration Backend
3. Go to Appearence > Listing layout setting and follow the steps on the [Template4posts](http://redmine.beapi.fr/projects/show/template4posts) page.

To use this plugin, you copy/paste the next code between:

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<?php do_action('template4posts') ?> ou <?php get_template4posts() ?> // The copy/paste code
	
<?php endwhile; endif; ?>


To create a new post template, your template must include this in the top:

<?php
/**
Template Post Name: (the name of your template
Description: (the description of your template)
**/
?>

------------------------------------------------------------------------------------

Pour utiliser le plugin, il faut inclure dans category.php ou/et index.php :

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
	<?php do_action('template4posts') ?> ou <?php get_template4posts() ?>
	
<?php endwhile; endif; ?>

Pour créer une nouvelle mise en place, vous devez inclure ceci dans le haut de votre template

<?php
/**
Template Post Name: (the name of your template
Description: (the description of your template)
**/
?>