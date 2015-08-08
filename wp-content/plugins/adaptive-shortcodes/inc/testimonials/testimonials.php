<?php
/**
 * Plugin Name: Testimonials
 * Plugin URI: http://Adap.com/
 * Description: Hi, I'm your testimonials management plugin for WordPress. Show off what your customers or website users are saying about your business and how great they say you are, using our shortcode, widget or template tag.
 * Author: adapThemes
 * Version: 1.3.1
 * Author URI: http://Adap.com/
 *
 * @package WordPress
 * @subpackage Adap_Testimonials
 * @author Matty
 * @since 1.0.0
 */

require_once('classes/class-adap-testimonials.php');
require_once('classes/class-adap-testimonials-taxonomy.php');
require_once('adap-testimonials-template.php');
require_once('classes/class-adap-widget-testimonials.php');
global $adap_testimonials;
$adap_testimonials = new Adap_Testimonials(__FILE__);
$adap_testimonials->version = '1.3.1';
?>
