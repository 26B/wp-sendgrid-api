# wp-sendgrid-api

Replacement `wp_mail()` to use Sendgrid API.

## Configuration

Add your default configuration to maybe wp-config.php 
by adding the constants described below.

```php
define( 'TWENTYSIXB_SENDGRID_API_KEY', '<YOUR_API_KEY>' );
define( 'TWENTYSIXB_SENDGRID_FROM_EMAIL', 'hello@26b.io' );
define( 'TWENTYSIXB_SENDGRID_FROM_NAME', 'Your name' );
```

Define a template by replacing `<YOUR_TEMPLATE_ID>` with a template of your choice and or a category.

```php
add_filter(
    'twentysixb_sendgrid_mail',
    function( $email ) {

        $email->setTemplateId( '<YOUR_TEMPLATE_ID>' );
        $email->addCategory( 'website' );

        return $email;
    }
);
```

## Hooks

### `twentysixb_sendgrid_template_data`

Define the values for the variables in your template.

```php
add_filter(
    'twentysixb_sendgrid_template_data',
    function( $data ) {

        $data['cta_text'] = 'Subscribe CTA';
        $data['cta_url']  = 'https://awesome.newsletter.com';

        return $data;
    }
);
```

### `twentysixb_sendgrid_mail` (required)

Configuration hook to define the template ID that is used.

```php
add_filter(
    'twentysixb_sendgrid_mail',
    function( $email ) {

        $email->setTemplateId( '<YOUR_TEMPLATE_ID>' );
        $email->addCategory( 'website' );

        return $email;
    }
);
```
