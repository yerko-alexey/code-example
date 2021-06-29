Simple plugin to get data via WP REST Api

Usage:
Simply send curl request to desired endpoint

Endpoints:
https://example.com/wp-json/code-example-plugin/v1/products
https://example.com/wp-json/code-example-plugin/v1/users

Curl Example:
curl --location --request POST 'https://example.com/wp-json/code-example-plugin/v1/users' \
--header 'Authorization: Basic (yout auth token)'