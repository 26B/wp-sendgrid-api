# wp-sendgrid-api

Replacement `wp_mail()` to use Sendgrid API.

## Configuration

```php_
    define( 'TWENTYSIXB_SENDGRID_API_KEY', '<YOUR_API_KEY>' );
    define( 'TWENTYSIXB_SENDGRID_FROM_EMAIL', 'hello@26b.io' );
    define( 'TWENTYSIXB_SENDGRID_FROM_NAME', 'Your name' );
```

## Examples

Define a template by setting `<YOUR_TEMPLATE_ID>` and add a category.

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

Add custom template variables and their replacements.
```php
    add_filter(
        'twentysixb_sendgrid_template_data',
        function( $data ) {

            $data['calltoaction'] = 'this should be a call to action link';

            return $data;
        }
    );
```