<?php
/*
Plugin Name:    champs d'informations produits
Description:    Pierre aime les chouquettes
Version:        1.0
Author:         craburant/cloé
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', 'champs_information_creation' );


function champs_information_creation() {

	// creation des champs de l'edit
	if ( function_exists( 'acf_add_local_field_group' ) ):

		acf_add_local_field_group( array(
			'key'      => 'infos-event',
			'title'    => 'Informations events',
			'fields'   => array(
				array(
					'key'   => 'info_horaire_start',
					'label' => 'Horaires début',
					'name'  => 'horaire_start',
					'type'  => 'time_picker',
				),
				array(
					'key'   => 'info_horaire_end',
					'label' => 'Horaires fin',
					'name'  => 'horaire_end',
					'type'  => 'time_picker',
				),
				array(
					'key'   => 'info_Adresse',
					'label' => 'Adresse',
					'name'  => 'adresse',
					'type'  => 'text',
				),
				array(
					'key'   => 'info_jours',
					'label' => 'Date',
					'name'  => 'date',
					'type'  => 'date_picker',
				),
				array(
					'key'   => 'info_liste',
					'label' => 'Liste des groupes',
					'name'  => 'liste',
					'type'  => 'text',
				)
			),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'product',
					),
				),
			),
		) );

	endif;

	// ajout du shortcode
	add_shortcode( 'display_infos_event', 'affichage_champs_produit_event' );
	add_shortcode( 'display_hidden_infos_event', 'display_hidden_infos_event' );
}

function affichage_champs_produit_event() {


	// check de la date
	$date_ojd   = date_create();
	$date_check = date_modify( $date_ojd, '+1 day' );
	$date_check = date_format( $date_check, 'd/m/Y' );
	$date_event = get_field( 'date' );
	$timer      = '';
	//affichage du timer
	if ( $date_event == $date_check ) {
		$timer = '<div> <p id="heure_compteur_cloe_plugin">23</p> <p id="minute_compteur_cloe_plugin">59</p> <p id="seconde_compteur_cloe_plugin">60</p> </div>';
		echo $timer;
		event_start_soon();
	}

	$horaire_start = date( 'H:i', strtotime( get_field( 'horaire_start' ) ) );
	$horaire_end   = date( 'H:i', strtotime( get_field( 'horaire_end' ) ) );
	//affichage du contenue des champs
	$infos =
		'<p id="info_1"> l\'événement auras lieu le ' . get_field( 'date' ) . ' ,' .
		' de <span id="time_start_event">' . $horaire_start . '</span> heure à ' . $horaire_end . ' heure </p>' .
		'<p id="info_3">Vous retrouverez sur place les groupes suivants :  <br>' . get_field( 'liste' ) . '.</p>';
	wp_enqueue_style( 'css_infos_events', plugin_dir_url( __FILE__ ) . 'css/css_infos.css' );

	return $infos;
}

function display_hidden_infos_event() {
	$product = wc_get_product();
	if ( isset( $product ) && $product != null ) {
		if ( wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) {
			return '<p id="info_2">Nous vous retrouverons à l\'adresse ' . get_field( 'adresse' ) . '.</p>';
		}
	}
}

function event_start_soon() {
	wp_enqueue_script( 'compteur_event', plugin_dir_url( __FILE__ ) . 'js/timer.js' );
}