# Matomo Module
 
File has been created with `module/create` command. 
 
## Installation

In order to add the modules to your project go into the modules section of your config:

```php
return [
    'modules' => [
    	'matomoadmin' => [
    		'class' => 'luya\matomo\Module',
    		'serverUrl' => 'https://matomo.example.com',
    		'siteId' => 1,
    		'apiToken' => 'THE_API_TOKEN',
    	]
    ],
];
```