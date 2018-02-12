# Matomo Module
 
Provide TrackingCode implementation Widget and admin dashboard object to see latest visits.

<p align="center">
  <img src="https://raw.githubusercontent.com/luyadev/luya-module-matomo/master/matomo.png" alt="LUYA Logo"/>
</p>
 
## Installation

In order to add the modules to your project go into the modules section of your config:

```php
return [
    'modules' => [
    	'matomoadmin' => [
    		'class' => 'luya\matomo\Module',
    		'serverUrl' => 'https://matomo.example.com', // without trailing slash, use full schema path.
    		'siteId' => 1,
    		'apiToken' => 'THE_API_TOKEN',
    	]
    ],
];
```