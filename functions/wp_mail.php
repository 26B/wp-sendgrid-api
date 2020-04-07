<?php

if ( ! function_exists( 'wp_mail' ) ) {

	function wp_mail( $to, $subject, $message, $headers = '', $attachments = array() ) {

		// FIXME: Check for the use of necessary constants.

		if ( ! defined( 'TWENTYSIXB_SENDGRID_API_KEY' ) ) {

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			error_log( 'TWENTYSIXB_SENDGRID_API_KEY not defined.' );
		}

		/**
		 * Filters the wp_mail() arguments.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args A compacted array of wp_mail() arguments, including the "to" email,
		 *                    subject, message, headers, and attachments values.
		 */
		$filtered_wp_mail = apply_filters( 'wp_mail', compact( 'to', 'subject', 'message', 'headers', 'attachments' ) );
		extract( $filtered_wp_mail );

		$email = new \SendGrid\Mail\Mail();

		$email->setFrom( TWENTYSIXB_SENDGRID_FROM_EMAIL, TWENTYSIXB_SENDGRID_FROM_NAME );

		// Set the defaults
		$email->setSubject( $subject );
		$email->addContent( 'text/plain', $message );

		// FIXME: Default WP e-mails do not work well with HTML.
		$email->addContent( 'text/html', $message );

		// Destination.
		$email->addTo( $to );

		// Template customization if any template specified.
		$template_data = [
			'body'    => $message,
			'subject' => $subject,
		];

		/**
		 * Filters the template data.
		 *
		 * Allows adding an array with keys to replace on the Sendgrid template.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Should be a key, value list of strings.
		 */
		$template_data = apply_filters( 'twentysixb_sendgrid_template_data', $template_data );
		$email->addDynamicTemplateDatas( $template_data );

		/**
		 * Filters the \SendGrid\Mail\Mail object.
		 *
		 * Allows direct customization of the Mail object.
		 *
		 * @since 1.0.0
		 *
		 * @param \SendGrid\Mail\Mail $email
		 */
		$email = apply_filters( 'twentysixb_sendgrid_mail', $email );

		try {

			$sendgrid = new \SendGrid( TWENTYSIXB_SENDGRID_API_KEY );
			$response = $sendgrid->send( $email );

			if ( $response->statusCode() !== 202 ) {
				throw new \Exception( 'Sendgrid API did not accept' );
			}
		} catch ( \Exception $e ) {

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			error_log( 'Sendgrid API expection: ' . $e->getMessage() );
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			error_log( 'Sendgrid API payload: ' . print_r( $response, true ) );
		}

		// FIXME: Remove debug code.
		// echo '<pre>';
		// var_dump(
		// 	$filtered_wp_mail,
		// 	$email
		// );
		// die('xx');
	}
}
