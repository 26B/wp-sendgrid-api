<?php

if ( ! function_exists( 'wp_mail' ) ) {

	function wp_mail( $to, $subject, $message, $headers = '', $attachments = array() ) {

		if ( ! defined( 'TWENTYSIXB_SENDGRID_API_KEY' ) ) {

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			error_log( 'TWENTYSIXB_SENDGRID_API_KEY not defined.' );
		}

		/**
		 * Filters the wp_mail() arguments.
		 *
		 * @since 0.0.1
		 *
		 * @param array $args A compacted array of wp_mail() arguments, including the "to" email address,
		 *                    subject, message, headers, and attachments values.
		 */
		$filtered_wp_mail = apply_filters( 'wp_mail', compact( 'to', 'subject', 'message', 'headers', 'attachments' ) );
		extract( $filtered_wp_mail );

		$email = new \SendGrid\Mail\Mail();

		$email->setFrom( TWENTYSIXB_SENDGRID_FROM_EMAIL, TWENTYSIXB_SENDGRID_FROM_NAME );

		// Set the defaults
		$email->setSubject( $subject );

		// Destination.
		$email->addTo( $to );

		// Template customization if any template specified.
		$template_data = [
			'body'    => wpautop( $message ),
			'subject' => $subject,
		];

		/**
		 * Filters the template data.
		 *
		 * Allows adding an array with keys to replace on the Sendgrid template.
		 *
		 * @since 0.0.1
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
		 * @since 0.0.1
		 *
		 * @param \SendGrid\Mail\Mail $email
		 */
		$email = apply_filters( 'twentysixb_sendgrid_mail', $email );

		try {

			$sendgrid = new \SendGrid( TWENTYSIXB_SENDGRID_API_KEY );
			$response = $sendgrid->send( $email );

			if ( $response->statusCode() !== 202 ) {
				throw new \Exception( 'Sendgrid API did not accept email' );
			}
			
			return true;
			
		} catch ( \Exception $e ) {

			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			error_log( 'Sendgrid API expection: ' . $e->getMessage() );
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions
			error_log( 'Sendgrid API payload: ' . print_r( $response, true ) );
			
			return false;
		}
	}
}
